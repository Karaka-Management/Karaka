<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Install
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Install;

use Model\Settings;

use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\GroupStatus;
use phpOMS\Account\PermissionType;
use phpOMS\ApplicationAbstract;
use phpOMS\Autoloader;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\L11nManager;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\Http\Response;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\Router;
use phpOMS\Router\RouteVerb;
use phpOMS\System\MimeType;
use phpOMS\Uri\UriFactory;

use phpOMS\Views\View;

/**
 * Application class.
 *
 * @package    Install
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class WebApplication extends ApplicationAbstract
{
    /**
     * Constructor.
     *
     * @param array $config Core config
     *
     * @since  1.0.0
     */
    public function __construct(array $config)
    {
        $this->setupHandlers();

        $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);
        $request      = $this->initRequest($config['page']['root'], $config['language'][0]);
        $response     = $this->initResponse($request, $config['language']);

        UriFactory::setupUriBuilder($request->getUri());

        $this->run($request, $response);

        /** @var \phpOMS\Message\Http\Header $header */
        $header = $response->getHeader();
        $header->push();

        echo $response->getBody();
    }

    /**
     * Setup general handlers for the application.
     *
     * @return void
     *
     * @since  1.0.0
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
     * @param string $rootPath Web root path
     * @param string $language Fallback language
     *
     * @return Request Initial client request
     *
     * @since  1.0.0
     */
    private function initRequest(string $rootPath, string $language) : Request
    {
        $request     = Request::createFromSuperglobals();
        $subDirDepth = \substr_count($rootPath, '/');

        $request->createRequestHashs($subDirDepth);
        $request->getUri()->setRootPath($rootPath);
        UriFactory::setupUriBuilder($request->getUri());

        $langCode = \strtolower($request->getUri()->getPathElement(0));
        $request->getHeader()->getL11n()->setLanguage(
            empty($langCode) || !ISO639x1Enum::isValidValue($langCode) ? $language : $langCode
        );
        UriFactory::setQuery('/lang', $request->getHeader()->getL11n()->getLanguage());

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param Request $request   Client request
     * @param array   $languages Supported languages
     *
     * @return Response Initial client request
     *
     * @since  1.0.0
     */
    private function initResponse(Request $request, array $languages) : Response
    {
        $response = new Response(new Localization());
        $response->getHeader()->set('content-type', 'text/html; charset=utf-8');
        $response->getHeader()->set('x-xss-protection', '1; mode=block');
        $response->getHeader()->set('x-content-type-options', 'nosniff');
        $response->getHeader()->set('x-frame-options', 'SAMEORIGIN');
        $response->getHeader()->set('referrer-policy', 'same-origin');

        if ($request->isHttps()) {
            $response->getHeader()->set('strict-transport-security', 'max-age=31536000');
        }

        $response->getHeader()->getL11n()->setLanguage(
            !\in_array($request->getHeader()->getL11n()->getLanguage(), $languages) ? 'en' : $request->getHeader()->getL11n()->getLanguage()
        );

        return $response;
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
    private function run(Request $request, Response $response) : void
    {
        $this->dispatcher = new Dispatcher($this);
        $this->router     = new Router();

        $this->setupRoutes();
        $response->getHeader()->set('content-language', $response->getHeader()->getL11n()->getLanguage(), true);
        UriFactory::setQuery('/lang', $response->getHeader()->getL11n()->getLanguage());

        $dispatched = $this->dispatcher->dispatch(
            $this->router->route(
                $request->getUri()->getRoute(),
                $request->getRouteVerb()
            ),
            $request,
            $response
        );
    }

    /**
     * Setup routes for installer
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function setupRoutes() : void
    {
        $this->router->add('^.*', '\Install\WebApplication::installView', RouteVerb::GET);
        $this->router->add('^.*', '\Install\WebApplication::installRequest', RouteVerb::PUT);
    }

    /**
     * Create install view
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function installView(Request $request, Response $response) : void
    {
        $view = new View(null, $request, $response);
        $view->setTemplate('/Install/index');
        $response->set('Content', $view);
    }

    /**
     * Handle install request.
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function installRequest(Request $request, Response $response) : void
    {
        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);

        if (!empty($valid = self::validateRequest($request))) {
            return;
        }

        $db = self::setupDatabaseConnection($request);

        self::clearOld();
        self::installConfigFile($request);
        self::installCore($db);
        self::installGroups($db);
        self::installUsers($request, $db);
        self::installSettings($request, $db);
    }

    /**
     * Validate install request.
     *
     * @param Request $request Request
     *
     * @return array<string, bool>
     *
     * @since  1.0.0
     */
    private static function validateRequest(Request $request) : array
    {
        $valid = [];

        if (($valid['php_extensions'] = !self::hasPhpExtensions())
            || ($valid['iDbHost'] = empty($request->getData('dbhost')))
            || ($valid['iDbType'] = empty($request->getData('dbtype')))
            || ($valid['iDbPort'] = empty($request->getData('dbport')))
            || ($valid['iDbPrefix'] = empty($request->getData('dbprefix')))
            || ($valid['iDbName'] = empty($request->getData('dbname')))
            || ($valid['iSchemaUser'] = empty($request->getData('schemauser')))
            //|| ($valid['iSchemaPassword'] = empty($request->getData('schemapassword')))
            || ($valid['iCreateUser'] = empty($request->getData('createuser')))
            //|| ($valid['iCreatePassword'] = empty($request->getData('createpassword')))
            || ($valid['iSelectUser'] = empty($request->getData('selectuser')))
            //|| ($valid['iSelectPassword'] = empty($request->getData('selectpassword')))
            || ($valid['iDeleteUser'] = empty($request->getData('deleteuser')))
            //|| ($valid['iDeletePassword'] = empty($request->getData('deletepassword')))
            || ($valid['iDbName'] = !self::testDbConnection($request))
            || ($valid['iOrgName'] = empty($request->getData('orgname')))
            || ($valid['iAdminName'] = empty($request->getData('adminname')))
            //|| ($valid['iAdminPassword'] = empty($request->getData('adminpassword')))
            || ($valid['iAdminEmail'] = empty($request->getData('adminemail')))
            || ($valid['iDomain'] = empty($request->getData('domain')))
            || ($valid['iWebSubdir'] = empty($request->getData('websubdir')))
            || ($valid['iDefaultLang'] = empty($request->getData('defaultlang')))
        ) {
            return $valid;
        }

        return [];
    }

    /**
     * Clear old install
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function clearOld() : void
    {
        \file_put_contents(__DIR__ . '/../Web/Backend/Routes.php', '<?php return [];');
        \file_put_contents(__DIR__ . '/../Web/Api/Routes.php', '<?php return [];');
        \file_put_contents(__DIR__ . '/../Console/Routes.php', '<?php return [];');

        \file_put_contents(__DIR__ . '/../Web/Api/Hooks.php', '<?php return [];');
        \file_put_contents(__DIR__ . '/../Console/Hooks.php', '<?php return [];');
    }

    /**
     * Check if has certain php extensions enabled
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private static function hasPhpExtensions() : bool
    {
        return \extension_loaded('pdo')
            && \extension_loaded('mbstring');
    }

    /**
     * Check if database connection is correct and working
     *
     * @param Request $request Request
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private static function testDbConnection(Request $request) : bool
    {
        return true;
    }

    /**
     * Create database connection
     *
     * @param Request $request Request
     *
     * @return ConnectionAbstract
     *
     * @since  1.0.0
     */
    private static function setupDatabaseConnection(Request $request) : ConnectionAbstract
    {
        return ConnectionFactory::create([
            'db' => (string) $request->getData('dbtype'),
            'host' => (string) $request->getData('dbhost'),
            'port' => (string) $request->getData('dbport'),
            'prefix' => (string) $request->getData('dbprefix'),
            'database' => (string) $request->getData('dbname'),
            'login' => (string) $request->getData('schemauser'),
            'password' => (string) $request->getData('schemapassword'),
        ]);
    }

    /**
     * Install/setup configuration
     *
     * @param Request $request Request
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installConfigFile(Request $request) : void
    {
        self::editConfigFile($request);
        self::editHtaccessFile($request);
    }

    /**
     * Modify config file
     *
     * @param Request $request Request
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function editConfigFile(Request $request) : void
    {
        $db     = $request->getData('dbtype');
        $host   = $request->getData('dbhost');
        $port   = (int) $request->getData('dbport');
        $dbname = $request->getData('dbname');
        $prefix = $request->getData('dbprefix');

        $admin  = ['login' => $request->getData('schemauser'), 'password' => $request->getData('schemapassword')];
        $insert = ['login' => $request->getData('createuser'), 'password' => $request->getData('createpassword')];
        $select = ['login' => $request->getData('selectuser'), 'password' => $request->getData('selectpassword')];
        $update = ['login' => $request->getData('updateuser'), 'password' => $request->getData('updatepassword')];
        $delete = ['login' => $request->getData('deleteuser'), 'password' => $request->getData('deletepassword')];
        $schema = ['login' => $request->getData('schemauser'), 'password' => $request->getData('schemapassword')];

        $subdir = $request->getData('websubdir');
        $tld    = $request->getData('domain');

        $config = include __DIR__ . '/Templates/config.tpl.php';

        \file_put_contents(__DIR__ . '/../config.php', $config);
    }

    /**
     * Modify htaccess file
     *
     * @param Request $request Request
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function editHtaccessFile(Request $request) : void
    {
        $fullTLD = $request->getData('domain');
        $tld     = \str_replace(['.', 'http://', 'https://'], ['\.', '', ''], $request->getData('domain') ?? '');

        $config = include __DIR__ . '/Templates/htaccess.tpl.php';

        \file_put_contents(__DIR__ . '/../.htaccess', $config);
    }

    /**
     * Install core functionality
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installCore(ConnectionAbstract $db) : void
    {
        self::createModuleTable($db);
        self::createModuleLoadTable($db);
        self::installCoreModules($db);
    }

    /**
     * Create module table
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function createModuleTable(ConnectionAbstract $db) : void
    {
        $db->con->prepare(
            'CREATE TABLE if NOT EXISTS `' . $db->prefix . 'module` (
                `module_id` varchar(255) NOT NULL,
                `module_theme` varchar(100) DEFAULT NULL,
                `module_path` varchar(50) NOT NULL,
                `module_active` tinyint(1) NOT NULL DEFAULT 1,
                `module_version` varchar(10) DEFAULT NULL,
                PRIMARY KEY (`module_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        )->execute();
    }

    /**
     * Create modules to load table
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function createModuleLoadTable(ConnectionAbstract $db) : void
    {
        $db->con->prepare(
            'CREATE TABLE if NOT EXISTS `' . $db->prefix . 'module_load` (
                `module_load_id` int(11) NOT NULL AUTO_INCREMENT,
                `module_load_pid` varchar(40) NOT NULL,
                `module_load_type` tinyint(1) NOT NULL,
                `module_load_from` varchar(255) DEFAULT NULL,
                `module_load_for` varchar(255) DEFAULT NULL,
                `module_load_file` varchar(255) NOT NULL,
                PRIMARY KEY (`module_load_id`),
                KEY `module_load_from` (`module_load_from`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
        )->execute();
    }

    /**
     * Install the core modules
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installCoreModules(ConnectionAbstract $db) : void
    {
        $app         = new class extends ApplicationAbstract {
            protected $appName = 'Api';
        };
        $app->dbPool = new DatabasePool();

        $app->dbPool->add('select', $db);
        $app->dbPool->add('insert', $db);
        $app->dbPool->add('update', $db);
        $app->dbPool->add('schema', $db);

        $moduleManager = new ModuleManager($app, __DIR__ . '/../Modules');

        $moduleManager->install('Admin');
        $moduleManager->install('Organization');
        $moduleManager->install('Profile');
        $moduleManager->install('Navigation');
    }

    /**
     * Install basic groups
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installGroups(ConnectionAbstract $db) : void
    {
        self::installMainGroups($db);
        self::installGroupPermissions($db);
    }

    /**
     * Create basic groups in db
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installMainGroups(ConnectionAbstract $db) : void
    {
        $date = new \DateTime('NOW', new \DateTimeZone('UTC'));

        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'group` (`group_name`, `group_desc`, `group_status`, `group_created`) VALUES
                (\'guest\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                (\'user\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                (\'admin\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\');'
        )->execute();
    }

    /**
     * Set permissions of basic groups
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installGroupPermissions(ConnectionAbstract $db) : void
    {
        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'group_permission` (`group_permission_group`, `group_permission_unit`, `group_permission_app`, `group_permission_module`, `group_permission_from`, `group_permission_type`, `group_permission_element`, `group_permission_component`, `group_permission_permission`) VALUES
                (3, 1, \'backend\', NULL, NULL, NULL, NULL, NULL, ' . (PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION) . ');'
        )->execute();

        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'group_permission` (`group_permission_group`, `group_permission_unit`, `group_permission_app`, `group_permission_module`, `group_permission_from`, `group_permission_type`, `group_permission_element`, `group_permission_component`, `group_permission_permission`) VALUES
                (3, 1, \'api\', NULL, NULL, NULL, NULL, NULL, ' . (PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION) . ');'
        )->execute();
    }

    /**
     * Install users
     *
     * @param Request            $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installUsers(Request $request, ConnectionAbstract $db) : void
    {
        self::installUserLocalization($db);
        self::installMainUser($request, $db);
    }

    /**
     * Setup global localization
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installUserLocalization(ConnectionAbstract $db) : void
    {
        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'l11n` (`l11n_country`, `l11n_language`, `l11n_currency`, `l11n_number_thousand`, `l11n_number_decimal`, `l11n_angle`, `l11n_temperature`, `l11n_weight_very_light`, `l11n_weight_light`, `l11n_weight_medium`, `l11n_weight_heavy`, `l11n_weight_very_heavy`, `l11n_speed_very_slow`, `l11n_speed_slow`, `l11n_speed_medium`, `l11n_speed_fast`, `l11n_speed_very_fast`, `l11n_speed_sea`, `l11n_length_very_short`, `l11n_length_short`, `l11n_length_medium`, `l11n_length_long`, `l11n_length_very_long`, `l11n_length_sea`, `l11n_area_very_small`, `l11n_area_small`, `l11n_area_medium`, `l11n_area_large`, `l11n_area_very_large`, `l11n_volume_very_small`, `l11n_volume_small`, `l11n_volume_medium`, `l11n_volume_large`, `l11n_volume_very_large`, `l11n_volume_teaspoon`, `l11n_volume_tablespoon`, `l11n_volume_glass`) VALUES
                (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\'), (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\');'
        )->execute();
    }

    /**
     * Setup root user in database
     *
     * @param Request            $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installMainUser(Request $request, ConnectionAbstract $db) : void
    {
        $date = new \DateTime('NOW', new \DateTimeZone('UTC'));

        $stmt = $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'account` (`account_status`, `account_type`, `account_login`, `account_name1`, `account_name2`, `account_name3`, `account_password`, `account_email`, `account_tries`, `account_lactive`, `account_localization`, `account_created_at`) VALUES
                (' . AccountStatus::ACTIVE . ', ' . AccountType::USER . ', :adminlogin, :adminname, \'\', \'\', :adminpassword, :adminemail, 5, \'' . $date->format('Y-m-d H:i:s') . '\', 2, \'' . $date->format('Y-m-d H:i:s') . '\');'
        );

        $adminlogin    = (string) $request->getData('adminname');
        $adminname     = $adminlogin;
        $adminpassword = \password_hash((string) $request->getData('adminpassword'), PASSWORD_DEFAULT);
        $adminemail    = (string) $request->getData('adminemail');

        $stmt->bindParam(':adminlogin', $adminlogin);
        $stmt->bindParam(':adminname', $adminname);
        $stmt->bindParam(':adminpassword', $adminpassword);
        $stmt->bindParam(':adminemail', $adminemail);

        $stmt->execute();

        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'account_group` (`account_group_group`, `account_group_account`) VALUES
                (3, 1);'
        )->execute();
    }

    /**
     * Setup basic settings
     *
     * @param Request            $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function installSettings(Request $request, ConnectionAbstract $db) : void
    {
        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'settings` (`settings_id`, `settings_module`, `settings_name`, `settings_content`, `settings_group`) VALUES
                (' . Settings::PASSWORD_PATTERN . ', NULL, \'pass_pattern\', \'\', NULL),
                (' . Settings::LOGIN_TIMEOUT . ', NULL, \'login_timeout\', \'3\', NULL),
                (' . Settings::PASSWORD_INTERVAL . ', NULL, \'pass_interval\', \'90\', NULL),
                (' . Settings::PASSWORD_HISTORY . ', NULL, \'pass_history\', \'3\', NULL),
                (' . Settings::LOGIN_TRIES . ', NULL, \'login_tries\', \'3\', NULL),
                (' . Settings::LOGGING_STATUS . ', NULL, \'log\', \'1\', NULL),
                (' . Settings::LOGGING_PATH . ', NULL, \'log_path\', \'\', NULL),
                (1000000009, NULL, \'oname\', \'Orange Management\', NULL),
                (1000000010, NULL, \'theme\', \'oms-slim\', NULL),
                (1000000011, NULL, \'theme_path\', \'/oms-slim\', NULL),
                (1000000012, NULL, \'changed\', \'1\', NULL),
                (' . Settings::LOGIN_STATUS . ', NULL, \'login_status\', \'1\', NULL),
                (1000000014, NULL, \'login_msg\', \'Maintenance scheduled for tomorrow from 11:00 am to 1:00 pm.\', NULL),
                (1000000015, NULL, \'use_cache\', \'0\', NULL),
                (1000000016, NULL, \'last_recache\', \'0000-00-00 00:00:00\', NULL),
                (1000000017, NULL, \'public_access\', \'0\', NULL),
                (1000000018, NULL, \'rewrite\', \'0\', NULL),
                (1000000019, NULL, \'country\', \'DE\', NULL),
                (1000000020, NULL, \'language\', \'en\', NULL),
                (1000000021, NULL, \'timezone\', \'Europe/Berlin\', NULL),
                (1000000022, NULL, \'temperature\', \'celsius\', NULL),
                (1000000023, NULL, \'currency\', \'USD\', NULL),
                (1000000025, NULL, \'mail_admin\', \'mail@admin.com\', NULL),
                (1000000026, NULL, \'login_name\', \'1\', NULL),
                (1000000027, NULL, \'decimal_point\', \'.\', NULL),
                (1000000028, NULL, \'thousands_sep\', \',\', NULL),
                (1000001001, NULL, \'weight_very_light\', \',\', NULL),
                (1000001002, NULL, \'weight_light\', \',\', NULL),
                (1000001003, NULL, \'weight_medium\', \',\', NULL),
                (1000001004, NULL, \'weight_heavy\', \',\', NULL),
                (1000001005, NULL, \'weight_very_heavy\', \',\', NULL),
                (1000002001, NULL, \'speed_very_slow\', \',\', NULL),
                (1000002002, NULL, \'speed_slow\', \',\', NULL),
                (1000002003, NULL, \'speed_medium\', \',\', NULL),
                (1000002004, NULL, \'speed_fast\', \',\', NULL),
                (1000002005, NULL, \'speed_very_fast\', \',\', NULL),
                (1000002006, NULL, \'speed_sea\', \',\', NULL),
                (1000003001, NULL, \'length_very_short\', \',\', NULL),
                (1000003002, NULL, \'length_short\', \',\', NULL),
                (1000003003, NULL, \'length_medium\', \',\', NULL),
                (1000003004, NULL, \'length_fast\', \',\', NULL),
                (1000003005, NULL, \'length_very_fast\', \',\', NULL),
                (1000003006, NULL, \'length_sea\', \',\', NULL),
                (1000004001, NULL, \'area_very_small\', \',\', NULL),
                (1000004002, NULL, \'area_small\', \',\', NULL),
                (1000004003, NULL, \'area_medium\', \',\', NULL),
                (1000004004, NULL, \'area_large\', \',\', NULL),
                (1000004005, NULL, \'area_very_large\', \',\', NULL),
                (1000005001, NULL, \'volume_very_small\', \',\', NULL),
                (1000005002, NULL, \'volume_small\', \',\', NULL),
                (1000005003, NULL, \'volume_medium\', \',\', NULL),
                (1000005004, NULL, \'volume_large\', \',\', NULL),
                (1000005005, NULL, \'volume_very_large\', \',\', NULL),
                (1000005006, NULL, \'volume_teaspoon\', \',\', NULL),
                (1000005007, NULL, \'volume_tablespoon\', \',\', NULL),
                (1000005008, NULL, \'volume_glass\', \',\', NULL)'
        )->execute();
    }
}
