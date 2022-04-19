<?php

/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web\Api
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */

declare(strict_types=1);

namespace Web\Api;

use Model\CoreSettings;
use Model\SettingsEnum;
use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\LocalizationMapper;
use Modules\Admin\Models\NullAccount;
use Modules\Admin\Models\PermissionCategory;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Application\ApplicationStatus;
use phpOMS\Auth\Auth;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Cookie\CookieJar;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Model\Html\Head;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\RouteVerb;
use phpOMS\Router\WebRouter;
use phpOMS\System\File\PathException;
use phpOMS\System\MimeType;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package Web\Api
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class Application
{
    /**
     * WebApplication.
     *
     * @var WebApplication
     * @since 1.0.0
     */
    private WebApplication $app;

    /**
     * Temp config.
     *
     * @var array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}}
     *
     * @since 1.0.0
     */
    private array $config;

    /**
     * Constructor.
     *
     * @param WebApplication                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       $app    WebApplication
     * @param array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}} $config Application config
     *
     * @since 1.0.0
     */
    public function __construct(WebApplication $app, array $config)
    {
        $this->app          = $app;
        $this->app->appName = 'Api';
        $this->config       = $config;
        UriFactory::setQuery('/app', \strtolower($this->app->appName));
    }

    /**
     * Rendering backend.
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function run(HttpRequest $request, HttpResponse $response): void
    {
        $response->header->set('Content-Type', 'text/plain; charset=utf-8');
        $pageView = new View($this->app->l11nManager, $request, $response);

        $this->app->l11nManager = new L11nManager($this->app->appName);
        $this->app->dbPool      = new DatabasePool();
        $this->app->router      = new WebRouter();
        $this->app->router->importFromFile(__DIR__ . '/Routes.php');

        $this->app->sessionManager = new HttpSession(0);
        $this->app->cookieJar      = new CookieJar();
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../Modules/');
        $this->app->dispatcher     = new Dispatcher($this->app);

        $this->app->dbPool->create('core', $this->config['db']['core']['masters']['admin']);
        $this->app->dbPool->create('insert', $this->config['db']['core']['masters']['insert']);
        $this->app->dbPool->create('select', $this->config['db']['core']['masters']['select']);
        $this->app->dbPool->create('update', $this->config['db']['core']['masters']['update']);
        $this->app->dbPool->create('delete', $this->config['db']['core']['masters']['delete']);
        $this->app->dbPool->create('schema', $this->config['db']['core']['masters']['schema']);

        /* Checking csrf token, if a csrf token is required at all has to be decided in the route or controller */
        if ($request->getData('CSRF') !== null
            && !\hash_equals($this->app->sessionManager->get('CSRF'), $request->getData('CSRF'))
        ) {
            $response->header->status = RequestStatusCode::R_403;

            return;
        }

        /** @var \phpOMS\DataStorage\Database\Connection\ConnectionAbstract $con */
        $con = $this->app->dbPool->get();
        DataMapperFactory::db($con);

        $this->app->cachePool    = new CachePool();
        $this->app->appSettings  = new CoreSettings();
        $this->app->eventManager = new EventManager($this->app->dispatcher);
        $this->app->eventManager->importFromFile(__DIR__ . '/Hooks.php');

        $this->app->accountManager = new AccountManager($this->app->sessionManager);
        $this->app->l11nServer     = LocalizationMapper::get()->where('id', 1)->execute();

        $this->app->orgId = $this->getApplicationOrganization($request, $this->config['app']);
        $pageView->setData('orgId', $this->app->orgId);

        $aid                       = Auth::authenticate($this->app->sessionManager);
        $request->header->account  = $aid;
        $response->header->account = $aid;

        $account = $this->loadAccount($request);

        if (!($account instanceof NullAccount)) {
            $response->header->l11n = $account->l11n;
        } elseif ($this->app->sessionManager->get('language') !== null) {
            $response->header->l11n
                ->loadFromLanguage(
                    $this->app->sessionManager->get('language'),
                    $this->app->sessionManager->get('country') ?? '*'
                );
        } elseif ($this->app->cookieJar->get('language') !== null) {
            $response->header->l11n
                ->loadFromLanguage(
                    $this->app->cookieJar->get('language'),
                    $this->app->cookieJar->get('country') ?? '*'
                );
        }

        UriFactory::setQuery('/lang', $response->getLanguage());
        $response->header->set('content-language', $response->getLanguage(), true);

        // Cache general settings
        $this->app->appSettings->get(null, [
            SettingsEnum::LOGGING_STATUS, SettingsEnum::CLI_ACTIVE,
        ]);

        $appStatus = (int) ($this->app->appSettings->get(null, SettingsEnum::LOGIN_STATUS)->content ?? 0);
        if ($appStatus === ApplicationStatus::READ_ONLY ||  $appStatus === ApplicationStatus::DISABLED) {
            if (!$account->hasPermission(PermissionType::CREATE | PermissionType::MODIFY, module: 'Admin', type: PermissionCategory::APP)) {
                if ($request->getRouteVerb() !== RouteVerb::GET) {
                    // Application is in read only mode or completely disabled
                    // If read only mode is active only GET requests are allowed
                    // A user who is part of the admin group is excluded from this rule
                    $response->header->status = RequestStatusCode::R_405;

                    return;
                }

                $this->app->dbPool->remove('admin');
                $this->app->dbPool->remove('insert');
                $this->app->dbPool->remove('update');
                $this->app->dbPool->remove('delete');
                $this->app->dbPool->remove('schema');
            }
        }

        if (!empty($uris = $request->uri->getQuery('r'))) {
            $this->handleBatchRequest($uris, $request, $response);

            return;
        }

        $this->app->moduleManager->initRequestModules($request);

        // add tpl loading
        $this->app->router->add(
            '/api/tpl/.*',
            function () use ($account, $request, $response): void {
                $appName = \ucfirst($request->getData('app') ?? 'Backend');
                $app     = new class() extends ApplicationAbstract
                {
                };

                $app->appName        = $appName;
                $app->dbPool         = $this->app->dbPool;
                $app->orgId          = $this->app->orgId;
                $app->accountManager = $this->app->accountManager;
                $app->appSettings    = $this->app->appSettings;
                $app->l11nManager    = new L11nManager($app->appName);
                $app->moduleManager  = new ModuleManager($app, __DIR__ . '/../../Modules/');
                $app->dispatcher     = new Dispatcher($app);
                $app->eventManager   = new EventManager($app->dispatcher);
                $app->router         = new WebRouter();

                $app->eventManager->importFromFile(__DIR__ . '/../' . $appName . '/Hooks.php');
                $app->router->importFromFile(__DIR__ . '/../' . $appName . '/Routes.php');

                $route = \str_replace('/api/tpl', '/' . $appName, $request->uri->getRoute());

                $view = new View();
                $view->setTemplate('/Web/Api/index');

                $response->set('Content', $view);
                $response->get('Content')->setData('head', new Head());

                $app->l11nManager->loadLanguage(
                    $response->getLanguage(),
                    '0',
                    include __DIR__ . '/../' . $appName . '/lang/' . $response->getLanguage() . '.lang.php'
                );

                $routed = $app->router->route(
                    $route,
                    $request->getData('CSRF'),
                    $request->getRouteVerb(),
                    $appName,
                    $this->app->orgId,
                    $account,
                    $request->getData()
                );

                $response->get('Content')->setData('dispatch', $app->dispatcher->dispatch($routed, $request, $response));
            },
            RouteVerb::GET
        );

        $routed = $this->app->router->route(
            $request->uri->getRoute(),
            $request->getData('CSRF'),
            $request->getRouteVerb(),
            $this->app->appName,
            $this->app->orgId,
            $account,
            $request->getData()
        );

        $dispatched = $this->app->dispatcher->dispatch($routed, $request, $response);

        if (empty($dispatched)) {
            $response->header->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);
            $response->header->status = RequestStatusCode::R_404;
            $response->set($request->uri->__toString(), [
                'status'   => \phpOMS\Message\NotificationLevel::ERROR,
                'title'    => '',
                'message'  => '',
                'response' => [],
            ]);
        }

        $pageView->addData('dispatch', $dispatched);
    }

    /**
     * Load permission
     *
     * @param HttpRequest $request Current request
     *
     * @return Account
     *
     * @since 1.0.0
     */
    private function loadAccount(HttpRequest $request): Account
    {
        $account = AccountMapper::getWithPermissions($request->header->account);
        $this->app->accountManager->add($account);

        return $account;
    }

    /**
     * Handle batch requests
     *
     * @param string       $uris     Uris to handle
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function handleBatchRequest(string $uris, HttpRequest $request, HttpResponse $response): void
    {
        $request_r = clone $request;
        $uris      = \json_decode($uris, true);

        foreach ($uris as $key => $uri) {
            //$request_r->init($uri);

            $modules = $this->app->moduleManager->getRoutedModules($request_r);
            $this->app->moduleManager->initModule($modules);

            $this->app->dispatcher->dispatch(
                $this->app->router->route(
                    $request->uri->getRoute(),
                    $request->getData('CSRF') ?? null
                ),
                $request,
                $response
            );
        }
    }

    /**
     * Get application organization
     *
     * @param HttpRequest $request Client request
     * @param array       $config  App config
     *
     * @return int Organization id
     *
     * @since 1.0.0
     */
    private function getApplicationOrganization(HttpRequest $request, array $config): int
    {
        return (int) ($request->getData('u') ?? ($config['domains'][$request->uri->host]['org'] ?? $config['default']['org']));
    }

    /**
     * Load theme language from path
     *
     * @param string $language Language name
     * @param string $path     Language path
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function loadLanguageFromPath(string $language, string $path): void
    {
        /* Load theme language */
        if (($absPath = \realpath($path)) === false) {
            throw new PathException($path);
        }

        /** @noinspection PhpIncludeInspection */
        $themeLanguage = include $absPath;
        $this->app->l11nManager->loadLanguage($language, '0', $themeLanguage);
    }
}
