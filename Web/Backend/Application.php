<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Web\Backend;

use Modules\Admin\Models\AccountPermissionMapper;
use Modules\Admin\Models\NullAccountPermission;
use Modules\Admin\Models\GroupPermissionMapper;
use Modules\Admin\Models\NullGroupPermission;
use Modules\Organization\Models\UnitMapper;
use Modules\Admin\Models\AccountMapper;
use Modules\Profile\Models\ProfileMapper;

use phpOMS\Account\AccountManager;
use phpOMS\Account\Account;
use phpOMS\Account\PermissionType;
use phpOMS\Asset\AssetType;
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
 * @category   Framework
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
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
    public function run(Request $request, Response $response) /* : void */
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
        $this->app->dbPool = new DatabasePool();
        $this->app->router = new Router();
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

        $aid = $this->app->accountManager->getAuth()->authenticate();
        $request->getHeader()->setAccount($aid);
        $response->getHeader()->setAccount($aid);

        $options = $this->app->appSettings->get([1000000009, 1000000029]);
        $account = $this->loadAccount($request);

        $response->getHeader()->getL11n()->setLanguage(!in_array($request->getHeader()->getL11n()->getLanguage(), $this->config['language']) ? $options[1000000029] : $request->getHeader()->getL11n()->getLanguage());
        UriFactory::setQuery('/lang', $response->getHeader()->getL11n()->getLanguage());

        $this->loadLanguageFromPath(
            $response->getHeader()->getL11n()->getLanguage(),
            __DIR__ . '/lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php'
        );
        
        $response->getHeader()->set('content-language', $response->getHeader()->getL11n()->getLanguage(), true);

        /* Create html head */
        $baseUri = $request->getUri()->getBase();
        $this->initResponseHead($head, $request, $response, $baseUri);

        /* Handle not logged in */
        if ($account->getId() < 1) {
            $this->createLoggedOutResponse($response, $head, $baseUri, $pageView);

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
     * @param View $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function create406Response(Response $response, View $pageView) /* : void */
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
     * @param View $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function create503Response(Response $response, View $pageView) /* : void */
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
     * @param string $path Language path
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function loadLanguageFromPath(string $language, string $path) /* : void */
    {
        /* Load theme language */
        if (($absPath = realpath($path)) === false) {
            throw new PathException($oldPath);
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
     * @param View $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function create403Response(Response $response, View $pageView) /* : void */
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
     * @param Head $head Head to fill
     * @param Request $request Request
     * @param Response $response Response
     * @param string $baseUri Base uri for asset path
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function initResponseHead(Head $head, Request $request, Response $response, string $baseUri)
    {
        /* Load assets */
        $head->addAsset(AssetType::CSS, $baseUri . 'Resources/fontawesome/css/font-awesome.min.css');
        $head->addAsset(AssetType::CSS, $baseUri . 'cssOMS/styles.css');
        //$head->addAsset(AssetType::CSS, $baseUri . 'cssOMS/debug.css');
        /* @todo: this should be loaded in one file for releases. right now this is done for easier debugging purposes */
        // Framework
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Utils/oLib.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Asset/AssetManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Autoloader.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UnhandledException.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Account/AccountType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Account/AccountManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Uri/Http.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Uri/UriFactory.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/DataStorage/CacheManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/DataStorage/CookieJar.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/DataStorage/LocalStorage.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/DataStorage/StorageManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Event/EventManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Request/RequestData.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Request/BrowserType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Request/OSType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Request/RequestMethod.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Request/RequestType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Request/Request.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/ActionManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Response/ResponseType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Response/ResponseResultType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Response/ResponseManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Response/Response.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Notification/App/AppNotification.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Notification/Browser/BrowserNotification.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Notification/NotificationType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Notification/NotificationManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Message/Notification/NotificationMessage.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Module/ModuleFactory.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Module/ModuleManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Dispatcher/Dispatcher.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Log/Logger.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Log/LogLevel.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Component/Form.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/InputManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Keyboard/KeyboardManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Mouse/ClickType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Mouse/EventType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Mouse/MouseManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Touch/TouchManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Voice/VoiceManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Voice/ReadManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Input/Voice/SpeechManager.js');
        //$head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Element/Button.js');
        //$head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Element/Select.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Component/Table.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Component/Tab.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/Loader.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/DragNDrop.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/GeneralUI.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/UI/UIManager.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Views/FormView.js');
        
        // Models
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Message/DomActionType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Message/DomAction.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Message/FormValidation.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Message/NotifyType.enum.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Message/Notify.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Message/Redirect.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Message/Reload.js');
        
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Message/Request.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Popup.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Remove.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Show.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Hide.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Focus.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Datalist/Clear.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Datalist/Append.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Table/Clear.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/Table/Append.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Utils/Timer.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Validate/Keypress.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/SetValue.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/RemoveValue.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Model/Action/Dom/GetValue.js');
        
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/js/config.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/js/global/ActionEvents.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/js/global/KeyboardEvents.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/js/global/MouseEvents.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/js/global/ResponseEvents.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/js/global/TouchEvents.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/js/global/VoiceEvents.js');
        
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Backend/ServiceWorker.js');
        $head->addAsset(AssetType::JSLATE, $baseUri . 'Web/Backend/js/backend.js');

        $head->addAsset(AssetType::JSLATE, $baseUri . 'Modules/Navigation/Controller.js');
        $head->addAsset(AssetType::JSLATE, $baseUri . 'Modules/Navigation/Models/Navigation.js');

        $head->setScript('core', $script = 'const RootPath = "' . $request->getUri()->getRootPath() . '", assetManager = new jsOMS.Asset.AssetManager();');
        $response->getHeader()->set('content-security-policy', 'script-src \'self\' \'sha256-' . base64_encode(hash('sha256', $script, true)) . '\'; child-src \'self\'', true);

        $head->addAsset(AssetType::CSS, $baseUri . 'Web/Backend/css/backend.css');
        $head->addAsset(AssetType::JS, $baseUri . 'Resources/d3/d3.min.js');
        $head->setStyle('core', preg_replace('!\s+!', ' ', file_get_contents(__DIR__ . '/css/backend-small.css')));

        $head->setTitle('Orange Management Backend');
    }

    /**
     * Create logged out response
     *
     * @param Response $response Response
     * @param Head $head Head to fill
     * @param string $baseUri Base uri for asset path
     * @param View $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function createLoggedOutResponse(Response $response, Head $head, string $baseUri, View $pageView) 
    {
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Animation/Animation.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Animation/Canvas/Particle.js');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/Animation/Canvas/ParticleAnimation.js');
        $head->addAsset(AssetType::JSLATE, $baseUri . 'Web/Backend/js/login.js');

        $pageView->setTemplate('/Web/Backend/login');
    }

    /**
     * Create default page view
     *
     * @param Request $request Request
     * @param Response $response Response
     * @param BackendView $pageView View
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function createDefaultPageView(Request $request, Response $response, BackendView $pageView)
    {
        $pageView->setOrganizations(UnitMapper::getAll());
        $pageView->setProfile(ProfileMapper::getFor($request->getHeader()->getAccount(), 'account'));
        $pageView->setData('nav', $this->getNavigation($request, $response));

        $pageView->setTemplate('/Web/Backend/index');
    }

    /**
     * Create navigation
     *
     * @param Request $request Request
     * @param Response $response Response
     *
     * @return View
     *
     * @since  1.0.0
     */
    private function getNavigation(Request $request, Response $response) : View
    {
        $navController = $this->app->moduleManager->get('Navigation');
        $navController->loadLanguage($request, $response);
        
        return $navController->getView($request, $response);
    }
}
