<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web\Api
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web\Api;

use Model\CoreSettings;

use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\LocalizationMapper;

use Modules\Admin\Models\NullAccount;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Auth\Auth;
use phpOMS\Auth\LoginReturnType;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Cookie\CookieJar;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\NotificationLevel;
use phpOMS\Model\Message\Notify;
use phpOMS\Model\Message\NotifyType;
use phpOMS\Model\Message\Reload;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\System\MimeType;

use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package Web\Api
 * @license OMS License 1.0
 * @link    https://orange-management.org
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
    public function run(HttpRequest $request, HttpResponse $response) : void
    {
        $response->getHeader()->set('Content-Type', 'text/plain; charset=utf-8');
        $pageView = new View($this->app->l11nManager, $request, $response);

        $this->app->l11nManager = new L11nManager($this->app->appName);
        $this->app->dbPool      = new DatabasePool();
        $this->app->router      = new WebRouter();
        $this->app->router->importFromFile(__DIR__ . '/Routes.php');

        $this->app->sessionManager = new HttpSession(36000);
        $this->app->cookieJar      = new CookieJar();
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../Modules');
        $this->app->dispatcher     = new Dispatcher($this->app);

        $this->app->dbPool->create('core', $this->config['db']['core']['masters']['admin']);
        $this->app->dbPool->create('insert', $this->config['db']['core']['masters']['insert']);
        $this->app->dbPool->create('select', $this->config['db']['core']['masters']['select']);
        $this->app->dbPool->create('update', $this->config['db']['core']['masters']['update']);
        $this->app->dbPool->create('delete', $this->config['db']['core']['masters']['delete']);
        $this->app->dbPool->create('schema', $this->config['db']['core']['masters']['schema']);

        if ($this->app->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            $response->getHeader()->setStatusCode(RequestStatusCode::R_503);

            return;
        }

        /* Checking csrf token, if a csrf token is required at all has to be decided in the route or controller */
        if ($request->getData('CSRF') !== null
            && !\hash_equals($this->app->sessionManager->get('CSRF'), $request->getData('CSRF'))
        ) {
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);

            return;
        }

        /** @var ConnectionAbstract $con */
        $con = $this->app->dbPool->get();
        DataMapperAbstract::setConnection($con);

        $this->app->cachePool    = new CachePool();
        $this->app->appSettings  = new CoreSettings($con);
        $this->app->eventManager = new EventManager($this->app->dispatcher);
        $this->app->eventManager->importFromFile(__DIR__ . '/Hooks.php');

        $this->app->accountManager = new AccountManager($this->app->sessionManager);
        $this->app->l11nServer     = LocalizationMapper::get(1);

        $this->app->orgId = $this->getApplicationOrganization($request, $this->config['app']);
        $pageView->setData('orgId', $this->app->orgId);

        $aid = Auth::authenticate($this->app->sessionManager);
        $request->getHeader()->setAccount($aid);
        $response->getHeader()->setAccount($aid);

        $account = $this->loadAccount($request);

        if (!($account instanceof NullAccount)) {
            $response->getHeader()->setL11n($account->getL11n());
        } elseif ($this->app->sessionManager->get('language') !== null) {
            $response->getHeader()->getL11n()
                ->loadFromLanguage(
                    $this->app->sessionManager->get('language'),
                    $this->app->sessionManager->get('country') ?? '*'
                );
        } elseif ($this->app->cookieJar->get('language') !== null) {
            $response->getHeader()->getL11n()
                ->loadFromLanguage(
                    $this->app->cookieJar->get('language'),
                    $this->app->cookieJar->get('country') ?? '*'
                );
        }

        UriFactory::setQuery('/lang', $response->getHeader()->getL11n()->getLanguage());
        $response->getHeader()->set('content-language', $response->getHeader()->getL11n()->getLanguage(), true);

        if (!empty($uris = $request->getUri()->getQuery('r'))) {
            $this->handleBatchRequest($uris, $request, $response);

            return;
        }

        if ($request->getUri()->getPathElement(0) === 'login') {
            $this->handleLogin($request, $response);

            return;
        } elseif ($request->getUri()->getPathElement(0) === 'logout') {
            $this->handleLogout($request, $response);

            return;
        }

        $this->app->moduleManager->initRequestModules($request);

        $dispatched = $this->app->dispatcher->dispatch(
            $this->app->router->route(
                $request->getUri()->getRoute(),
                $request->getData('CSRF'),
                $request->getRouteVerb(),
                $this->app->appName,
                $this->app->orgId,
                $account,
                $request->getData()
            ),
            $request,
            $response
        );

        if (empty($dispatched)) {
            $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);
            $response->getHeader()->setStatusCode(RequestStatusCode::R_404);
            $response->set($request->getUri()->__toString(), [
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
    private function loadAccount(HttpRequest $request) : Account
    {
        $account = AccountMapper::getWithPermissions($request->getHeader()->getAccount());
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
    private function handleBatchRequest(string $uris, HttpRequest $request, HttpResponse $response) : void
    {
        $request_r = clone $request;
        $uris      = \json_decode($uris, true);

        foreach ($uris as $key => $uri) {
            //$request_r->init($uri);

            $modules = $this->app->moduleManager->getRoutedModules($request_r);
            $this->app->moduleManager->initModule($modules);

            $this->app->dispatcher->dispatch(
                $this->app->router->route(
                    $request->getUri()->getRoute(),
                    $request->getData('CSRF') ?? null
                ), $request, $response
            );
        }
    }

    /**
     * Handle login request
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function handleLogin(HttpRequest $request, HttpResponse $response) : void
    {
        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);

        $login = AccountMapper::login((string) ($request->getData('user') ?? ''), (string) ($request->getData('pass') ?? ''));

        if ($login >= LoginReturnType::OK) {
            $this->app->sessionManager->set('UID', $login, true);
            $this->app->sessionManager->save();
            $response->set($request->getUri()->__toString(), new Reload());
        } else {
            $response->set($request->getUri()->__toString(), new Notify(
                'Login failed due to wrong login information',
                NotifyType::INFO
            ));
        }
    }

    /**
     * Handle logout request
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function handleLogout(HttpRequest $request, HttpResponse $response) : void
    {
        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);

        $this->app->sessionManager->remove('UID');
        $this->app->sessionManager->save();

        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);
        $response->set($request->getUri()->__toString(), [
            'status'   => NotificationLevel::OK,
            'title'    => 'Logout successfull',
            'message'  => 'You are redirected to the login page',
            'response' => null,
        ]);
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
    private function getApplicationOrganization(HttpRequest $request, array $config) : int
    {
        return (int) (
            $request->getData('u') ?? (
                $config['domains'][$request->getUri()->getHost()]['org'] ?? $config['default']['org']
            )
        );
    }
}
