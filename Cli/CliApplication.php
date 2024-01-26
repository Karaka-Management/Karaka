<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package    Cli
 * @copyright  Dennis Eichhorn
 * @license    OMS License 2.0
 * @version    1.0.0
 * @link       https://jingga.app
 */
declare(strict_types=1);

namespace Cli;

use Model\CoreSettings;
use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\LocalizationMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Profile\Models\ProfileMapper;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Cookie\CookieJar;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\L11nManager;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Cli\CliRequest;
use phpOMS\Message\Cli\CliResponse;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\SocketRouter;
use phpOMS\System\File\PathException;
use phpOMS\Uri\Argument;
use phpOMS\Views\View;

/**
 * Application class.
 *
 * @package    Cli
 * @license    OMS License 2.0
 * @link       https://jingga.app
 * @since      1.0.0
 *
 * @property \phpOMS\Router\SocketRouter $router
 */
final class CliApplication extends ApplicationAbstract
{
    /**
     * Temp config.
     *
     * @var array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string, user?:int}, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}}
     *
     * @since 1.0.0
     */
    private array $config;

    /**
     * Constructor.
     *
     * @param array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string, user?:int}, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}} $config Application config
     *
     * @since 1.0.0
     */
    public function __construct(array $config)
    {
        $this->appName = 'Cli';
        $this->config  = $config;
        $this->logger  = FileLogger::getInstance($config['log']['file']['path'], true);

        $this->setupHandlers();

        $this->l11nManager    = new L11nManager();
        $this->dbPool         = new DatabasePool();
        $this->sessionManager = new HttpSession(0);
        $this->cookieJar      = new CookieJar();
        $this->moduleManager  = new ModuleManager($this, __DIR__ . '/../Modules/');
        $this->dispatcher     = new Dispatcher($this);

        $this->dbPool->create('select', $this->config['db']['core']['masters']['select']);

        $this->router = new SocketRouter();
        $this->router->importFromFile(__DIR__ . '/Routes.php');

        /** @var \phpOMS\DataStorage\Database\Connection\ConnectionAbstract $con */
        $con = $this->dbPool->get();
        DataMapperFactory::db($con);

        $this->appId          = 1;
        $this->cachePool      = new CachePool();
        $this->appSettings    = new CoreSettings();
        $this->eventManager   = new EventManager($this->dispatcher);
        $this->accountManager = new AccountManager($this->sessionManager);
        $this->l11nServer     = LocalizationMapper::get()->where('id', 1)->execute();
    }

    /**
     * Rendering backend.
     *
     * @param array $arg Cli commands
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function run(array $arg) : void
    {
        $request  = $this->initRequest($arg, $this->config['app'], __DIR__);
        $response = $this->initResponse($request, $this->config);

        $aid                       = $request->getDataInt('uid') ?? ($this->config['app']['default']['user'] ?? 1);
        $request->header->account  = $aid;
        $response->header->account = $aid;

        $this->unitId = $request->getDataInt('u') ?? ($this->config['app']['default']['org'] ?? 1);

        $this->router->add(
            '/cli/e403',
            function() use ($request, $response) {
                $view = new View($this->l11nManager, $request, $response);
                $view->setTemplate('/Cli/Error/403');
                $response->header->status = RequestStatusCode::R_403;

                return $view;
            }
        );

        $account = $this->loadAccount($request);

        if ($account->id > 0) {
            $response->header->l11n = $account->l11n;
        } elseif (($this->sessionManager->data['language'] ?? null) !== null
            && $response->header->l11n->language !== $this->sessionManager->data['language']
        ) {
            $response->header->l11n
                ->loadFromLanguage(
                    $this->sessionManager->data['language'],
                    $this->sessionManager->data['country'] ?? '*'
                );
        }

        if (!\in_array($response->header->l11n->language, $this->config['language'])) {
            $response->header->l11n->language = $this->l11nServer->language;
        }

        $pageView = new CliView($this->l11nManager, $request, $response);
        $pageView->setData('unitId', $this->unitId);
        $response->set('Content', $pageView);

        /* Database OK? */
        if ($this->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            $this->create503Response($response, $pageView);

            $body = $response->getBody(true);
            echo $body;

            return;
        }

        $this->loadLanguageFromPath(
            $response->header->l11n->language,
            __DIR__ . '/lang/' . $response->header->l11n->language . '.lang.php'
        );

        $response->header->set('content-language', $response->header->l11n->language, true);

        /* No reading permission */
        if (!$account->hasPermission(PermissionType::READ, $this->unitId, $this->appId, 'Dashboard')) {
            $this->create403Response($response, $pageView);

            return;
        }

        $this->moduleManager->initRequestModules($request);
        $this->createDefaultPageView($request, $response, $pageView);

        $dispatched = $this->dispatcher->dispatch(
            $this->router->route(
                $request->uri->getRoute(),
                null,
                $request->getRouteVerb(),
                $this->appId,
                $this->unitId,
                $account,
                $request->data
            ),
            $request,
            $response
        );
        $pageView->addData('dispatch', $dispatched);

        $body = $response->getBody(true);
        echo $body;
    }

    /**
     * Setup general handlers for the application.
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function setupHandlers() : void
    {
        \set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        \set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        \register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
        \mb_internal_encoding('UTF-8');
    }

    /**
     * Initialize current application request
     *
     * @param array  $arg      Cli arguments
     * @param array  $config   Application config
     * @param string $rootPath Cli root path
     *
     * @return CliRequest Initial client request
     *
     * @since 1.0.0
     */
    private function initRequest(array $arg, array $config, string $rootPath) : CliRequest
    {
        $start  = \stripos($arg[1] ?? '', ':');
        $method = RequestMethod::GET;

        if ($start !== false) {
            $method = \strtoupper(\substr($arg[1], 0, $start));

            $end = \stripos($arg[1], ' ', $start + 1);

            if ($end === false) {
                $end = \strlen($arg[1]); // @codeCoverageIgnore
            }

            $arg[1] = $start < 8 ? \substr($arg[1], $start + 1, $end - $start - 1) : $arg[1];
        }

        \array_shift($arg);

        $request = new CliRequest(new Argument(\implode(' ', $arg)));

        if (!RequestMethod::isValidValue($method)) {
            $method = RequestMethod::GET;
        }

        $request->setMethod($method);

        $defaultLang = $config['domains'][$request->uri->host]['lang'] ?? $config['default']['lang'];
        $uriLang     = \strtolower($request->uri->getPathElement(0));
        $langCode    = ISO639x1Enum::isValidValue($uriLang) ? $uriLang : $defaultLang;

        $pathOffset = 0;
        $request->createRequestHashs($pathOffset);
        $request->uri->setRootPath($rootPath);
        $request->uri->setPathOffset($pathOffset);

        $request->header->l11n->loadFromLanguage($langCode, '*');

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param CliRequest $request Client request
     * @param array      $config  App config
     *
     * @return CliResponse Initial client request
     *
     * @since 1.0.0
     */
    private function initResponse(CliRequest $request, array $config) : CliResponse
    {
        $response = new CliResponse(new Localization());

        $defaultLang = $config['app']['domains'][$request->uri->host]['lang'] ?? $config['app']['default']['lang'];
        $uriLang     = \strtolower($request->uri->getPathElement(0));

        $requestLang = $request->header->l11n->language;
        $langCode    = ISO639x1Enum::isValidValue($requestLang) && \in_array($requestLang, $config['language'])
            ? $requestLang
            : (ISO639x1Enum::isValidValue($uriLang) && \in_array($uriLang, $config['language'])
                ? $uriLang
                : $defaultLang
            );

        $response->header->l11n->loadFromLanguage($langCode, '*');

        return $response;
    }

    /**
     * Load theme language from path
     *
     * @param string $language Language name
     * @param string $path     Language path
     *
     * @return void
     *
     * @throws PathException
     *
     * @since 1.0.0
     */
    public function loadLanguageFromPath(string $language, string $path) : void
    {
        /* Load theme language */
        if (($absPath = \realpath($path)) === false) {
            throw new PathException($path);
        }

        /** @noinspection PhpIncludeInspection */
        $themeLanguage = include $absPath;
        $this->l11nManager->loadLanguage($language, '0', $themeLanguage);
    }

    /**
     * Load permission
     *
     * @param CliRequest $request Current request
     *
     * @return Account
     *
     * @since 1.0.0
     */
    private function loadAccount(CliRequest $request) : Account
    {
        $account = AccountMapper::getWithPermissions($request->header->account);
        $this->accountManager->add($account);

        return $account;
    }

    /**
     * Create 503 response.
     *
     * @param CliResponse $response Response
     * @param View        $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function create503Response(CliResponse $response, View $pageView) : void
    {
        $response->header->status = RequestStatusCode::R_503;
        $pageView->setTemplate('/Web/Backend/Error/503');
        $this->loadLanguageFromPath(
            $response->header->l11n->language,
            __DIR__ . '/Error/lang/' . $response->header->l11n->language . '.lang.php'
        );
    }

    /**
     * Create 403 response.
     *
     * @param CliResponse $response Response
     * @param View        $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function create403Response(CliResponse $response, View $pageView) : void
    {
        $response->header->status = RequestStatusCode::R_403;
        $pageView->setTemplate('/Web/Backend/Error/403');
        $this->loadLanguageFromPath(
            $response->header->l11n->language,
            __DIR__ . '/Error/lang/' . $response->header->l11n->language . '.lang.php'
        );
    }

    /**
     * Create default page view
     *
     * @param CliRequest  $request  Request
     * @param CliResponse $response Response
     * @param CliView     $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function createDefaultPageView(CliRequest $request, CliResponse $response, CliView $pageView) : void
    {
        /** @var \Modules\Organization\Models\Unit[] $unit */
        $unit = UnitMapper::getAll()->execute();
        $pageView->setOrganizations($unit);

        /** @var \Modules\Profile\Models\Profile $profile */
        $profile           = ProfileMapper::get()
            ->where('account', $request->header->account)
            ->execute();
        $pageView->profile = $profile;

        $pageView->setTemplate('/Cli/index');
    }
}
