<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @package    Web\Backend
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
namespace Web\Backend;

use Modules\Admin\Models\AccountPermissionMapper;
use Modules\Admin\Models\GroupPermissionMapper;
use Modules\Organization\Models\UnitMapper;
use Modules\Admin\Models\AccountMapper;
use Modules\Profile\Models\ProfileMapper;

use phpOMS\Account\AccountManager;
use phpOMS\Account\Account;
use phpOMS\Account\PermissionType;
use phpOMS\Asset\AssetType;
use phpOMS\Auth\Auth;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\Http\Response;
use phpOMS\Model\Html\Head;
use phpOMS\System\File\PathException;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\Event\EventManager;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\L11nManager;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\Router;

use Model\CoreSettings;

use Web\WebApplication;

/**
 * Application class.
 *
 * @package    Web\Backend
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Application
{
    /**
     * WebApplication.
     *
     * @var WebApplication
     * @since 1.0.0
     */
    private $app = null;

    /**
     * Temp config.
     *
     * @var array
     * @since 1.0.0
     */
    private $config = [];

    /**
     * Constructor.
     *
     * @param WebApplication $app    WebApplication
     * @param array          $config Application config
     *
     * @since  1.0.0
     */
    public function __construct(WebApplication $app, array $config)
    {
        $this->app          = $app;
        $this->app->appName = 'Backend';
        $this->config       = $config;
        UriFactory::setQuery('/app', strtolower($this->app->appName));
    }

    /**
     * Rendering backend.
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function run(Request $request, Response $response) : void
    {
        $this->app->orgId = (int) ($request->getData('u') ?? 1);
        $pageView         = new BackendView($this->app, $request, $response);
        $head             = new Head();

        $pageView->setData('head', $head);
        $response->set('Content', $pageView);

        /* Backend only allows GET */
        if ($request->getMethod() !== RequestMethod::GET) {
            $this->create406Response($response, $pageView);

            return;
        }

        $this->app->l11nManager = new L11nManager();
        $this->app->dbPool      = new DatabasePool();
        $this->app->router      = new Router();
        $this->app->router->importFromFile(__DIR__ . '/Routes.php');

        $this->app->sessionManager = new HttpSession(36000);
        $this->app->moduleManager  = new ModuleManager($this->app, __DIR__ . '/../../Modules');
        $this->app->dispatcher     = new Dispatcher($this->app);

        $this->app->dbPool->create('select', $this->config['db']['core']['masters']['select']);

        /* Database OK? */
        if ($this->app->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            $this->create503Response($response, $pageView);

            return;
        }

        /* CSRF token OK? */
        if ($request->getData('CSRF') !== null && $this->app->sessionManager->get('CSRF') !== $request->getData('csrf')) {
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);

            return;
        }

        DataMapperAbstract::setConnection($this->app->dbPool->get());

        $this->app->cachePool      = new CachePool();
        $this->app->appSettings    = new CoreSettings($this->app->dbPool->get());
        $this->app->eventManager   = new EventManager();
        $this->app->accountManager = new AccountManager($this->app->sessionManager);

        $aid = Auth::authenticate($this->app->sessionManager);
        $request->getHeader()->setAccount($aid);
        $response->getHeader()->setAccount($aid);

        $options = $this->app->appSettings->get([1000000009, 1000000029]);
        $account = $this->loadAccount($request);

        $response->getHeader()->getL11n()->setLanguage(
            !in_array(
                $request->getHeader()->getL11n()->getLanguage(), 
                $this->config['language']
            ) ? $options[1000000029] : $request->getHeader()->getL11n()->getLanguage()
        );
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
        if (!$account->hasPermission(PermissionType::READ, $this->app->orgId, $this->app->appName)) {
            $this->create403Response($response, $pageView);

            return;
        }

        $this->createDefaultPageView($request, $response, $pageView);
        $this->app->moduleManager->initRequestModules($request);

        $dispatched = $this->app->dispatcher->dispatch($this->app->router->route($request), $request, $response);
        $pageView->addData('dispatch', $dispatched);
    }

    /**
     * Create 406 response.
     *
     * @param Response $response Response
     * @param View     $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function create406Response(Response $response, View $pageView) : void
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
     * @param Response $response Response
     * @param View     $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function create503Response(Response $response, View $pageView) : void
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
     * @since  1.0.0
     */
    private function loadLanguageFromPath(string $language, string $path) : void
    {
        /* Load theme language */
        if (($absPath = realpath($path)) === false) {
            throw new PathException($path);
        }

        /** @noinspection PhpIncludeInspection */
        $themeLanguage = include $absPath;
        $this->app->l11nManager->loadLanguage($language, 0, $themeLanguage);
    }

    /**
     * Load permission
     *
     * @param Request $request Current request
     *
     * @return Account
     *
     * @since  1.0.0
     */
    private function loadAccount(Request $request) : Account
    {
        $this->app->accountManager->add(AccountMapper::get($request->getHeader()->getAccount()));
        $account = $this->app->accountManager->get($request->getHeader()->getAccount());

        $groupPermissions = GroupPermissionMapper::getFor(array_keys($account->getGroups()), 'group');
        $account->addPermissions(is_array($groupPermissions) ? $groupPermissions : [$groupPermissions]);

        $accountPermissions = AccountPermissionMapper::getFor($request->getHeader()->getAccount(), 'account');
        $account->addPermissions(is_array($accountPermissions) ? $accountPermissions : [$accountPermissions]);

        return $account;
    }

    /**
     * Create 406 response.
     *
     * @param Response $response Response
     * @param View     $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function create403Response(Response $response, View $pageView) : void
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
     * @param Head     $head     Head to fill
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function initResponseHead(Head $head, Request $request, Response $response) : void
    {
        /* Load assets */
        $head->addAsset(AssetType::CSS, '/Resources/fontawesome/css/font-awesome.min.css');
        $head->addAsset(AssetType::CSS, '/cssOMS/styles.css');

        /* @todo: this should be loaded in one file for releases. right now this is done for easier debugging purposes */
        // Framework
        $head->addAsset(AssetType::JS, '/jsOMS/Utils/oLib.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Asset/AssetManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Autoloader.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UnhandledException.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Account/AccountType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Account/AccountManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Uri/Http.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Uri/UriFactory.js');
        $head->addAsset(AssetType::JS, '/jsOMS/DataStorage/CacheManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/DataStorage/CookieJar.js');
        $head->addAsset(AssetType::JS, '/jsOMS/DataStorage/LocalStorage.js');
        $head->addAsset(AssetType::JS, '/jsOMS/DataStorage/StorageManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Event/EventManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Request/RequestData.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Request/BrowserType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Request/OSType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Request/RequestMethod.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Request/RequestType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Request/Request.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/ActionManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Response/ResponseType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Response/ResponseResultType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Response/ResponseManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Response/Response.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Notification/App/AppNotification.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Notification/Browser/BrowserNotification.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Notification/NotificationType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Notification/NotificationLevel.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Notification/NotificationManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Message/Notification/NotificationMessage.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Module/ModuleFactory.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Module/ModuleManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Dispatcher/Dispatcher.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Log/Logger.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Log/LogLevel.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Component/Form.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/InputManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Keyboard/KeyboardManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Mouse/ClickType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Mouse/EventType.enum.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Mouse/MouseManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Touch/TouchManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Voice/VoiceManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Voice/ReadManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Input/Voice/SpeechManager.js');
        //$head->addAsset(AssetType::JS, '/jsOMS/UI/Element/Button.js');
        //$head->addAsset(AssetType::JS, '/jsOMS/UI/Element/Select.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Component/Table.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Component/Tab.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/Loader.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/DragNDrop.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/GeneralUI.js');
        $head->addAsset(AssetType::JS, '/jsOMS/UI/UIManager.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Views/FormView.js');
        $head->addAsset(AssetType::JS, '/jsOMS/Utils/Parser/Markdown.js');

        // Models
        $head->addAsset(AssetType::JS, '/Model/Message/DomActionType.enum.js');
        $head->addAsset(AssetType::JS, '/Model/Message/DomAction.js');
        $head->addAsset(AssetType::JS, '/Model/Message/FormValidation.js');
        $head->addAsset(AssetType::JS, '/Model/Message/NotifyType.enum.js');
        $head->addAsset(AssetType::JS, '/Model/Message/Notify.js');
        $head->addAsset(AssetType::JS, '/Model/Message/Redirect.js');
        $head->addAsset(AssetType::JS, '/Model/Message/Reload.js');

        $head->addAsset(AssetType::JS, '/Model/Action/Message/Request.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Popup.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Remove.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Show.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Hide.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Focus.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Datalist/Clear.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Datalist/Append.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Table/Clear.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/Table/Append.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Utils/Timer.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Validate/Keypress.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/SetValue.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/RemoveValue.js');
        $head->addAsset(AssetType::JS, '/Model/Action/Dom/GetValue.js');

        $head->addAsset(AssetType::JS, '/Web/Backend/js/config.js');
        $head->addAsset(AssetType::JS, '/Web/Backend/js/global/ActionEvents.js');
        $head->addAsset(AssetType::JS, '/Web/Backend/js/global/KeyboardEvents.js');
        $head->addAsset(AssetType::JS, '/Web/Backend/js/global/MouseEvents.js');
        $head->addAsset(AssetType::JS, '/Web/Backend/js/global/ResponseEvents.js');
        $head->addAsset(AssetType::JS, '/Web/Backend/js/global/TouchEvents.js');
        $head->addAsset(AssetType::JS, '/Web/Backend/js/global/VoiceEvents.js');

        $head->addAsset(AssetType::JS, '/Web/Backend/ServiceWorker.js');
        $head->addAsset(AssetType::JSLATE, '/Web/Backend/js/backend.js');

        $head->addAsset(AssetType::JSLATE, '/Modules/Navigation/Controller.js');
        $head->addAsset(AssetType::JSLATE, '/Modules/Navigation/Models/Navigation.js');

        $head->setScript('core', $script = 'const assetManager = new jsOMS.Asset.AssetManager();');
        $response->getHeader()->set(
            'content-security-policy', 
            'base-uri \'self\'; script-src \'self\' blob: \'sha256-' 
            . base64_encode(hash('sha256', $script, true)) 
            . '\'; worker-src \'self\'', 
            true
        );

        $head->addAsset(AssetType::CSS, '/Web/Backend/css/backend.css');

        if ($request->hasData('debug')) {
            $head->addAsset(AssetType::CSS, '/cssOMS/debug.css');
        }

        $head->addAsset(AssetType::JS, '/Resources/d3/d3.min.js');
        $head->setStyle('core', preg_replace('!\s+!', ' ', file_get_contents(__DIR__ . '/css/backend-small.css')));

        $head->setTitle('Orange Management Backend');
    }

    /**
     * Create logged out response
     *
     * @param Response $response Response
     * @param Head     $head     Head to fill
     * @param View     $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function createLoggedOutResponse(Response $response, Head $head, View $pageView) : void
    {
        $pageView->setTemplate('/Web/Backend/login');
    }

    /**
     * Create default page view
     *
     * @param Request     $request  Request
     * @param Response    $response Response
     * @param BackendView $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function createDefaultPageView(Request $request, Response $response, BackendView $pageView) : void
    {
        $pageView->setOrganizations(UnitMapper::getAll());
        $pageView->setProfile(ProfileMapper::getFor($request->getHeader()->getAccount(), 'account'));
        $pageView->setData('nav', $this->getNavigation($request, $response));

        $pageView->setTemplate('/Web/Backend/index');
    }

    /**
     * Create navigation
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return View
     *
     * @since  1.0.0
     */
    private function getNavigation(Request $request, Response $response) : View
    {
        /** @var \Modules\Navigation\Controller $navController */
        $navController = $this->app->moduleManager->get('Navigation');
        $navController->loadLanguage($request, $response);

        return $navController->getView($request, $response);
    }
}
