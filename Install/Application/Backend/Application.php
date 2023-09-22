<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Backend;

use Model\CoreSettings;
use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\AppMapper;
use Modules\Admin\Models\LocalizationMapper;
use Modules\Admin\Models\NullAccount as ModelsNullAccount;
use Modules\Media\Models\MediaMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Profile\Models\ProfileMapper;
use Modules\Profile\Models\SettingsEnum;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\Account\NullAccount;
use phpOMS\Account\PermissionType;
use phpOMS\Asset\AssetType;
use phpOMS\Auth\Auth;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Cookie\CookieJar;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
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
use phpOMS\Router\RouteStatus;
use phpOMS\Router\RouteVerb;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package Web\Backend
 * @license OMS License 2.0
 * @link    https://jingga.app
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
     *
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
        $this->app->l11nManager    = new L11nManager();
        $this->app->dbPool         = new DatabasePool();
        $this->app->sessionManager = new HttpSession(0);
        $this->app->cookieJar      = new CookieJar();
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../Modules/');
        $this->app->dispatcher     = new Dispatcher($this->app);

        $this->app->dbPool->create('select', $this->config['db']['core']['masters']['select']);

        $this->app->router = new WebRouter();
        $this->app->router->importFromFile(__DIR__ . '/Routes.php');
        $this->app->router->add(
            '/backend/e403',
            function() use ($request, $response) {
                $view = new View($this->app->l11nManager, $request, $response);
                $view->setTemplate('/Web/Backend/Error/403_inline');
                $response->header->status = RequestStatusCode::R_403;

                return $view;
            },
            RouteVerb::GET
        );

        /* CSRF token OK? */
        if ($request->hasData('CSRF')
            && !\hash_equals($this->app->sessionManager->data['CSRF'] ?? '', $request->getDataString('CSRF'))
        ) {
            $response->header->status = RequestStatusCode::R_403;

            return;
        }

        /** @var \phpOMS\DataStorage\Database\Connection\ConnectionAbstract $con */
        $con = $this->app->dbPool->get();
        $con->connect();
        DataMapperFactory::db($con);

        $this->app->moduleManager->get('Monitoring', '')->helperLogRequestStat($request);

        /** @var \Modules\Admin\Models\App $app */
        $app = AppMapper::get()
            ->where('name', $this->app->appName)
            ->execute();

        $this->app->appId = $app->id;

        $this->app->cachePool      = new CachePool();
        $this->app->appSettings    = new CoreSettings();
        $this->app->eventManager   = new EventManager($this->app->dispatcher);
        $this->app->accountManager = new AccountManager($this->app->sessionManager);
        $this->app->l11nServer     = LocalizationMapper::get()->where('id', 1)->execute();
        $this->app->unitId         = $this->getApplicationOrganization($request, $this->config['app']);

        $aid                       = Auth::authenticate($this->app->sessionManager);
        $account                   = $this->loadAccount($aid);
        $request->header->account  = $account->id;
        $response->header->account = $account->id;

        if ($account->id > 0) {
            $response->header->l11n = $account->l11n;
        } elseif (isset($this->app->sessionManager->data['language'])
            && $response->header->l11n->language !== $this->app->sessionManager->data['language']
        ) {
            $response->header->l11n
                ->loadFromLanguage(
                    $this->app->sessionManager->data['language'],
                    $this->app->sessionManager->data['country'] ?? '*'
                );
        } else {
            $this->app->setResponseLanguage($request, $response, $this->config);
        }

        if (!\in_array($response->header->l11n->language, $this->config['language'])) {
            $response->header->l11n->language = $this->app->l11nServer->language;
        }

        $pageView = new BackendView($this->app->l11nManager, $request, $response);
        $head     = new Head();

        $pageView->setData('unitId', $this->app->unitId);
        $pageView->head = $head;
        $response->set('Content', $pageView);

        /* Backend only allows GET */
        if ($request->getMethod() !== RequestMethod::GET) {
            $this->create406Response($response, $pageView);

            return;
        }

        /* Database OK? */
        if ($this->app->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            $this->create503Response($response, $pageView);

            return;
        }

        UriFactory::setQuery('/lang', $response->header->l11n->language);

        $this->app->loadLanguageFromPath(
            $response->header->l11n->language,
            __DIR__ . '/lang/' . $response->header->l11n->language . '.lang.php'
        );

        $response->header->set('content-language', $response->header->l11n->language, true);

        /* Create html head */
        $this->initResponseHead($head, $request, $response);

        /* Handle not logged in */
        if ($account->id < 1) {
            $this->createBaseLoggedOutResponse($request, $response, $head, $pageView);

            return;
        }

        /* No reading permission */
        if (!$account->hasPermission(PermissionType::READ, $this->app->unitId, $this->app->appId, 'Dashboard')) {
            $this->create403Response($response, $pageView);

            return;
        }

        $this->app->moduleManager->initRequestModules($request);
        $this->createDefaultPageView($request, $response, $pageView);

        $dispatched = $this->routeDispatching($request, $response, $account);
        $pageView->addData('dispatch', $dispatched);
    }

    /**
     * Initialize response head
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     * @param Account      $account  Account
     *
     * @return array
     *
     * @since 1.0.0
     */
    private function routeDispatching(HttpRequest $request, HttpResponse $response, Account $account) : array
    {
        $routes = $this->app->router->route(
            $request->uri->getRoute(),
            $request->getDataString('CSRF'),
            $request->getRouteVerb(),
            $this->app->appId,
            $this->app->unitId,
            $account,
            $request->data
        );

        if ($routes === ['dest' => RouteStatus::INVALID_CSRF]
            || $routes === ['dest' => RouteStatus::INVALID_PERMISSIONS]
            || $routes === ['dest' => RouteStatus::INVALID_DATA]
        ) {
            return $this->app->dispatcher->dispatch(
                $this->app->router->route(
                    '/' . \strtolower($this->app->appName) . '/e403',
                    $request->getDataString('CSRF'),
                    $request->getRouteVerb()
                ),
                $request, $response);
        } elseif ($routes === ['dest' => RouteStatus::NOT_LOGGED_IN]) {
            return $this->app->dispatcher->dispatch(
                $this->app->router->route(
                    '/' . \strtolower($this->app->appName) . '/login',
                    $request->getDataString('CSRF'),
                    $request->getRouteVerb()
                ),
                $request, $response);
        } else {
            return $this->app->dispatcher->dispatch($routes, $request, $response);
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
    private function getApplicationOrganization(HttpRequest $request, array $config) : int
    {
        return (int) (
            $request->getDataString('u') ?? (
                $config['domains'][$request->uri->host]['org'] ?? $config['default']['org']
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
        $response->header->status = RequestStatusCode::R_406;
        $pageView->setTemplate('/Web/Backend/Error/406');
        $this->app->loadLanguageFromPath(
            $response->header->l11n->language,
            __DIR__ . '/Error/lang/' . $response->header->l11n->language . '.lang.php'
        );
    }

    /**
     * Create 503 response.
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
        $response->header->status = RequestStatusCode::R_503;
        $pageView->setTemplate('/Web/Backend/Error/503');
        $this->app->loadLanguageFromPath(
            $response->header->l11n->language,
            __DIR__ . '/Error/lang/' . $response->header->l11n->language . '.lang.php'
        );
    }

    /**
     * Load permission
     *
     * @param int $uid User Id
     *
     * @return Account
     *
     * @since 1.0.0
     */
    private function loadAccount(int $uid) : Account
    {
        $account = AccountMapper::getWithPermissions($uid);

        if ($account instanceof ModelsNullAccount) {
            $account = new NullAccount();
        }

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
        $response->header->status = RequestStatusCode::R_403;
        $pageView->setTemplate('/Web/Backend/Error/403');
        $this->app->loadLanguageFromPath(
            $response->header->l11n->language,
            __DIR__ . '/Error/lang/' . $response->header->l11n->language . '.lang.php'
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
        $head->addAsset(AssetType::CSS, 'Resources/fonts/fontawesome/css/font-awesome.min.css?v=1.0.0');
        $head->addAsset(AssetType::CSS, 'Resources/fonts/linearicons/css/style.css?v=1.0.0');
        $head->addAsset(AssetType::CSS, 'Resources/fonts/lineicons/css/lineicons.css?v=1.0.0');
        $head->addAsset(AssetType::CSS, 'cssOMS/styles.css?v=1.0.0');
        $head->addAsset(AssetType::CSS, 'Resources/fonts/Roboto/roboto.css?v=1.0.0');

        // Framework
        $head->addAsset(AssetType::JS, 'jsOMS/Utils/oLib.js?v=1.0.0');
        $head->addAsset(AssetType::JS, 'jsOMS/UnhandledException.js?v=1.0.0');
        $head->addAsset(AssetType::JS, 'Web/Backend/js/backend.js?v=1.0.0', ['type' => 'module']);

        $script = '';
        $response->header->set(
            'content-security-policy',
            'base-uri \'self\'; script-src \'self\' blob: \'sha256-'
            . \base64_encode(\hash('sha256', $script, true))
            . '\'; worker-src \'self\'',
            true
        );

        if ($request->hasData('debug')) {
            $head->addAsset(AssetType::CSS, 'cssOMS/debug.css?v=1.0.0');
            \phpOMS\DataStorage\Database\Query\Builder::$log = true;
        }

        $css = \file_get_contents(__DIR__ . '/css/backend-small.css');
        if ($css === false) {
            $css = '';
        }

        $css = \preg_replace('!\s+!', ' ', $css);
        $head->setStyle('core', $css ?? '');
        $head->title = 'Jingga Backend';
    }

    /**
     * Create forgot response
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     * @param Head         $head     Head to fill
     * @param View         $pageView View
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function createBaseLoggedOutResponse(HttpRequest $request, HttpResponse $response, Head $head, View $pageView) : void
    {
        $file = \in_array($request->uri->getPathElement(0), ['forgot', 'reset', 'privacy', 'imprint', 'terms'])
            ? 'Themes/login/' . $request->uri->getPathElement(0)
            : 'login';

        $response->header->status = RequestStatusCode::R_403;
        $pageView->setTemplate('/Web/Backend/' . $file);

        $css = \file_get_contents(__DIR__ . '/css/logout-small.css');
        if ($css === false) {
            $css = '';
        }

        $css = \preg_replace('!\s+!', ' ', $css);
        $head->setStyle('core', $css ?? '');
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
        /** @var \Modules\Organization\Models\Unit[] $units */
        $units = UnitMapper::getAll()->execute();
        $pageView->setOrganizations($units);

        /** @var \Modules\Profile\Models\Profile $profile */
        $profile           = ProfileMapper::get()->where('account', $request->header->account)->execute();
        $pageView->profile = $profile;

        $pageView->setData('nav', $this->getNavigation($request, $response));

        /** @var \Model\Setting $profileImage */
        $profileImage = $this->app->appSettings->get(names: SettingsEnum::DEFAULT_PROFILE_IMAGE, module: 'Profile');

        /** @var \Modules\Media\Models\Media $image */
        $image                         = MediaMapper::get()
            ->where('id', (int) $profileImage->content)
            ->execute();
        $pageView->defaultProfileImage = $image;

        $pageView->setTemplate('/Web/Backend/index');

        /** @var \Model\Setting $setting */
        $setting = $this->app->appSettings->get(names: \Modules\Admin\Models\SettingsEnum::LOGIN_STATUS);
        $pageView->setData('appStatus', (int) ($setting->content ?? 0));
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
