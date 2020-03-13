<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web\Backend;

use Model\CoreSettings;

use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\LocalizationMapper;
use Modules\Admin\Models\NullAccount;
use Modules\Organization\Models\UnitMapper;

use Modules\Profile\Models\ProfileMapper;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\PermissionType;
use phpOMS\Asset\AssetType;
use phpOMS\Auth\Auth;
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
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Model\Html\Head;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\RouteVerb;
use phpOMS\Router\WebRouter;
use phpOMS\System\File\PathException;
use phpOMS\Uri\UriFactory;

use phpOMS\Views\View;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package Web\Backend
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
     * @var array{db:array{core:array{masters:array{select:array{db:string, host:string, port:int, login:string, password:string, database:string}}}}, log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]}
     * @since 1.0.0
     */
    private array $config;

    /**
     * Constructor.
     *
     * @param WebApplication                                                                                                                                                                                                                                                                                                                            $app    WebApplication
     * @param array{db:array{core:array{masters:array{select:array{db:string, host:string, port:int, login:string, password:string, database:string}}}}, log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]} $config Application config
     *
     * @since 1.0.0
     */
    public function __construct(WebApplication $app, array $config)
    {
        $this->app          = $app;
        $this->app->appName = 'Backend';
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
        $this->app->l11nManager = new L11nManager($this->app->appName);

        $pageView = new BackendView($this->app->l11nManager, $request, $response);
        $head     = new Head();

        $pageView->setData('head', $head);
        $response->set('Content', $pageView);

        /* Backend only allows GET */
        if ($request->getMethod() !== RequestMethod::GET) {
            $this->create406Response($response, $pageView);

            return;
        }

        $this->app->dbPool = new DatabasePool();
        $this->app->router = new WebRouter();
        $this->app->router->importFromFile(__DIR__ . '/Routes.php');
        $this->app->router->add(
            '/backend/e403',
            function() use ($request, $response) {
                $view = new View($this->app->l11nManager, $request, $response);
                $view->setTemplate('/Web/Backend/Error/403_inline');
                $response->getHeader()->setStatusCode(RequestStatusCode::R_403);


                return $view;
            },
            RouteVerb::GET
        );

        $this->app->sessionManager = new HttpSession(36000);
        $this->app->cookieJar      = new CookieJar();
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../Modules');
        $this->app->dispatcher     = new Dispatcher($this->app);

        $this->app->dbPool->create('select', $this->config['db']['core']['masters']['select']);

        /* Database OK? */
        if ($this->app->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            $this->create503Response($response, $pageView);

            return;
        }

        /* CSRF token OK? */
        if ($request->getData('CSRF') !== null
            && !\hash_equals($this->app->sessionManager->get('CSRF'), $request->getData('CSRF'))
        ) {
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);

            return;
        }

        /** @var ConnectionAbstract $con */
        $con = $this->app->dbPool->get();
        DataMapperAbstract::setConnection($con);

        $this->app->cachePool      = new CachePool();
        $this->app->appSettings    = new CoreSettings($con);
        $this->app->eventManager   = new EventManager($this->app->dispatcher);
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

        $this->loadLanguageFromPath(
            $response->getHeader()->getL11n()->getLanguage(),
            __DIR__ . '/lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php'
        );

        $response->getHeader()->set('content-language', $response->getHeader()->getL11n()->getLanguage(), true);

        /* Create html head */
        $this->initResponseHead($head, $request, $response);

        /* Handle not logged in */
        if ($account->getId() < 1) {
            $this->createLoggedOutResponse($response, $head, $pageView);

            return;
        }

        /* No reading permission */
        if (!$account->hasPermission(PermissionType::READ, $this->app->orgId, $this->app->appName, 'Dashboard')) {
            $this->create403Response($response, $pageView);

            return;
        }

        $this->app->moduleManager->initRequestModules($request);
        $this->createDefaultPageView($request, $response, $pageView);

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
        $pageView->addData('dispatch', $dispatched);
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

    /**
     * Create 406 response.
     *
     * @param HttpResponse $response Response
     * @param View         $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function create406Response(HttpResponse $response, View $pageView) : void
    {
        $response->getHeader()->setStatusCode(RequestStatusCode::R_406);
        $pageView->setTemplate('/Web/Backend/Error/406');
        $this->loadLanguageFromPath(
            $response->getHeader()->getL11n()->getLanguage(),
            __DIR__ . '/Error/lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php'
        );
    }

    /**
     * Create 406 response.
     *
     * @param HttpResponse $response Response
     * @param View         $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function create503Response(HttpResponse $response, View $pageView) : void
    {
        $response->getHeader()->setStatusCode(RequestStatusCode::R_503);
        $pageView->setTemplate('/Web/Backend/Error/503');
        $this->loadLanguageFromPath(
            $response->getHeader()->getL11n()->getLanguage(),
            __DIR__ . '/Error/lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php'
        );
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
    private function loadLanguageFromPath(string $language, string $path) : void
    {
        /* Load theme language */
        if (($absPath = \realpath($path)) === false) {
            throw new PathException($path);
        }

        /** @noinspection PhpIncludeInspection */
        $themeLanguage = include $absPath;
        $this->app->l11nManager->loadLanguage($language, '0', $themeLanguage);
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
     * Create 406 response.
     *
     * @param HttpResponse $response Response
     * @param View         $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function create403Response(HttpResponse $response, View $pageView) : void
    {
        $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
        $pageView->setTemplate('/Web/Backend/Error/403');
        $this->loadLanguageFromPath(
            $response->getHeader()->getL11n()->getLanguage(),
            __DIR__ . '/Error/lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php'
        );
    }

    /**
     * Initialize response head
     *
     * @param Head         $head     Head to fill
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function initResponseHead(Head $head, HttpRequest $request, HttpResponse $response) : void
    {
        /* Load assets */
        $head->addAsset(AssetType::CSS, 'Resources/fontawesome/css/font-awesome.min.css');
        $head->addAsset(AssetType::CSS, 'cssOMS/styles.css');
        $head->addAsset(AssetType::CSS, '//fonts.googleapis.com/css?family=Roboto:100,300,300i,400,700,900');

        // Framework
        $head->addAsset(AssetType::JS, 'jsOMS/Utils/oLib.js');
        $head->addAsset(AssetType::JS, 'jsOMS/UnhandledException.js');
        $head->addAsset(AssetType::JS, 'Web/Backend/js/backend.js', ['type' => 'module']);
        $head->addAsset(AssetType::JSLATE, 'Modules/Navigation/Controller.js', ['type' => 'module']);

        $script = '';
        $response->getHeader()->set(
            'content-security-policy',
            'base-uri \'self\'; script-src \'self\' blob: \'sha256-'
            . \base64_encode(\hash('sha256', $script, true))
            . '\'; worker-src \'self\'',
            true
        );

        if ($request->hasData('debug')) {
            $head->addAsset(AssetType::CSS, 'cssOMS/debug.css');
        }

        $css = \file_get_contents(__DIR__ . '/css/backend-small.css');
        if ($css === false) {
            $css = '';
        }

        $css = \preg_replace('!\s+!', ' ', $css);
        $head->setStyle('core', $css ?? '');
        $head->setTitle('Orange Management Backend');
    }

    /**
     * Create logged out response
     *
     * @param HttpResponse $response Response
     * @param Head         $head     Head to fill
     * @param View         $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function createLoggedOutResponse(HttpResponse $response, Head $head, View $pageView) : void
    {
        $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
        $pageView->setTemplate('/Web/Backend/login');
    }

    /**
     * Create default page view
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     * @param BackendView  $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function createDefaultPageView(HttpRequest $request, HttpResponse $response, BackendView $pageView) : void
    {
        $pageView->setOrganizations(UnitMapper::getAll());
        $pageView->setProfile(ProfileMapper::getFor($request->getHeader()->getAccount(), 'account'));
        $pageView->setData('nav', $this->getNavigation($request, $response));

        $pageView->setTemplate('/Web/Backend/index');
    }

    /**
     * Create navigation
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return View
     *
     * @since 1.0.0
     */
    private function getNavigation(HttpRequest $request, HttpResponse $response) : View
    {
        /** @var \Modules\Navigation\Controller\BackendController $navController */
        $navController = $this->app->moduleManager->get('Navigation');
        $navController->loadLanguage($request, $response);

        return $navController->getView($request, $response);
    }
}
