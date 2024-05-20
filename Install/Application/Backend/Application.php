<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Backend;

use Model\CoreSettings;
use Modules\Admin\Models\Account as AdminAccount;
use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\App;
use Modules\Admin\Models\AppMapper;
use Modules\Admin\Models\LocalizationMapper;
use Modules\Media\Models\MediaMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Profile\Models\ProfileMapper;
use Modules\Profile\Models\SettingsEnum;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
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
use phpOMS\Router\WebRouter;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package Web\Backend
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class Application
{
    /**
     * Application version
     *
     * @var string
     * @since 1.0.0
     */
    public const VERSION = '1.0.0';

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
        $this->app->version = self::VERSION;
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

        /* CSRF token OK? */
        if ($request->hasData('CSRF')
            && !\hash_equals($this->app->sessionManager->data['CSRF'] ?? '', $request->getDataString('CSRF'))
        ) {
            $response->header->status = RequestStatusCode::R_403;

            return;
        }

        /** @var \phpOMS\DataStorage\Database\Connection\ConnectionAbstract $con */
        $con = $this->app->dbPool->get();
        DataMapperFactory::db($con);

        /** @var \Modules\Admin\Models\App $app */
        $app = AppMapper::get()
            ->where('name', $this->app->appName)
            ->execute();

        $this->app->appId = $app->id;

        $this->app->cachePool = new CachePool();
        foreach (($this->config['cache'] ?? []) as $name => $cache) {
            $this->app->cachePool->create($name, $cache);
        }

        $this->app->appSettings    = new CoreSettings($this->app->cachePool->get());
        $this->app->eventManager   = new EventManager($this->app->dispatcher);
        $this->app->accountManager = new AccountManager($this->app->sessionManager);
        $this->app->l11nServer     = LocalizationMapper::get()->where('id', 1)->execute();
        $this->app->unitId         = $this->getApplicationOrganization($request, $app, $this->config['app']);

        $this->app->sessionManager->data['unit'] = $this->app->unitId;

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

        $this->app->moduleManager->get('Monitoring', '')->helperLogRequestStat($request);
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
            $response->header->status = RequestStatusCode::R_403;

            return $this->app->dispatcher->dispatch(
                $this->app->router->route(
                    '/' . \strtolower($this->app->appName) . '/e403',
                    $request->getDataString('CSRF'),
                    $request->getRouteVerb()
                ),
                $request, $response);
        } elseif ($routes === ['dest' => RouteStatus::NOT_LOGGED_IN]) {
            $response->header->status = RequestStatusCode::R_403;

            return $this->app->dispatcher->dispatch(
                $this->app->router->route(
                    '/' . \strtolower($this->app->appName) . '/login',
                    $request->getDataString('CSRF'),
                    $request->getRouteVerb()
                ),
                $request, $response);
        } else {
            if (empty($routes)) {
                $response->header->status = RequestStatusCode::R_404;
            }

            return $this->app->dispatcher->dispatch($routes, $request, $response);
        }
    }

    /**
     * Get application organization
     *
     *  1. Use uri parameter
     *  2. Use session
     *  3. Use app config
     *  3. Use host config
     *
     * @param HttpRequest $request Client request
     * @param App         $app     Application
     * @param array       $config  App config
     *
     * @return int Organization id
     *
     * @since 1.0.0
     */
    private function getApplicationOrganization(HttpRequest $request, App $app, array $config) : int
    {
        return (int) (
            $request->getDataInt('u') ?? (
                $this->app->sessionManager->data['unit'] ?? (
                    ($app->defaultUnit ?? 0) === 0
                        ? ($config['domains'][$request->uri->host]['org'] ?? $config['default']['org'])
                        : $app->defaultUnit
                )
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
        if (($json = $this->app->cachePool->get()->get('account:' . $uid)) === null || ($json['id'] ?? 0) === 0) {
            $account = AccountMapper::getWithPermissions($uid);

            $this->app->cachePool->get()->add('account:' . $uid, $account->jsonSerialize(), 3600);
        } else {
            $account = AdminAccount::fromJson($json);
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
        $scriptSrc = \bin2hex(\random_bytes(32));
        $this->app->appSettings->setOption('script-nonce', $scriptSrc);

        // @security 'unsafe-eval' is required for wasm ('wasm-unsafe-eval' is not working?!)
        //      Remove once wasm can be loaded via nonce
        $response->header->set('content-security-policy',
            'base-uri \'self\';'
            . 'object-src \'none\';'
            . 'script-src \'nonce-' . $scriptSrc . '\' \'strict-dynamic\' \'unsafe-eval\';'
            . 'worker-src \'self\';'
        );

        /*
        $response->header->set('content-security-policy',
            'base-uri \'self\';'
            . 'object-src \'none\';'
            . 'script-src \'nonce-' . $scriptSrc . '\' \'strict-dynamic\' https: \'self\''
                . ' blob: \'sha256-' . \base64_encode(\hash('sha256', $script, true)) . '\';'
            . 'worker-src \'self\';'
        );
        */

        /* Load assets */
        $head->addAsset(AssetType::CSS, 'cssOMS/styles.css?v=' . self::VERSION, ['defer']);
        $head->addAsset(AssetType::CSS, 'cssOMS/print.css?v=' . self::VERSION, ['media' => 'print', 'defer']);

        // Framework
        $head->addAsset(AssetType::JS, 'Web/Backend/js/backend.min.js?v=' . self::VERSION, ['nonce' => $scriptSrc, 'type' => 'module', 'defer']);

        // @feature Make user setting by storing it in the localstorage of the user
        if ($request->hasKey('darkmode')) {
            $head->addAsset(AssetType::CSS, 'Web/Backend/css/backend-dark.css?v=1.0.0', ['defer']);
        }

        if ($request->hasKey('debug')) {
            $account = $this->app->accountManager->get($request->header->account);
            if ($account->hasPermission(PermissionType::CREATE, $this->app->unitId, $this->app->appId)) {
                $head->addAsset(AssetType::CSS, 'cssOMS/debug.css?v=' . self::VERSION);
                \phpOMS\DataStorage\Database\Query\Builder::$log = true;
            }
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
        $response->header->status = RequestStatusCode::R_403;

        if (\in_array($request->uri->getPathElement(0), ['privacy', 'imprint', 'terms'])) {
            /** @var \Modules\CMS\Models\Page $page */
            $page = \Modules\CMS\Models\PageMapper::get()
                ->with('l11n')
                ->where('app', 2)
                ->where('name', \strtolower($request->uri->getPathElement(0)))
                ->where('l11n/language', $response->header->l11n->language)
                ->execute();

            $pageView->setTemplate('/Web/Backend/Themes/login/legal');
            $pageView->data['content'] = $page->getL11n(\strtolower($request->uri->getPathElement(0)))->content;
        } elseif (\in_array($request->uri->getPathElement(0), ['forgot', 'reset'])) {
            $pageView->setTemplate('/Web/Backend/Themes/login/' . $request->uri->getPathElement(0));
        } else {
            $pageView->setTemplate('/Web/Backend/login');
        }

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
        $units = UnitMapper::getAll()->executeGetArray();
        $pageView->setOrganizations($units);

        /** @var \Modules\Profile\Models\Profile $profile */
        $profile           = ProfileMapper::get()->where('account', $request->header->account)->execute();
        $pageView->profile = $profile;

        $pageView->setData('nav', $this->getNavigation($request, $response));

        // Cache general settings
        $this->app->appSettings->get(null, [
            SettingsEnum::DEFAULT_PROFILE_IMAGE, \Modules\Admin\Models\SettingsEnum::LOGIN_STATUS,
        ]);

        /** @var \Model\Setting $profileImage */
        $profileImage = $this->app->appSettings->get(names: SettingsEnum::DEFAULT_PROFILE_IMAGE, module: 'Profile');

        /** @var \Modules\Media\Models\Media $image */
        $image = MediaMapper::get()
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
