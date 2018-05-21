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

use phpOMS\ApplicationAbstract;

use phpOMS\Autoloader;
use phpOMS\Log\FileLogger;
use phpOMS\Uri\UriFactory;
use phpOMS\Message\Console\Request;
use phpOMS\Message\Console\Response;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\Localization;
use phpOMS\Localization\L11nManager;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\Router\Router;
use phpOMS\Router\RouteVerb;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Views\View;
use phpOMS\Account\GroupStatus;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\PermissionType;
use phpOMS\Module\ModuleManager;

/**
 * Application class.
 *
 * @package    Install
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class ConsoleApplication extends ApplicationAbstract
{
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
     * @param array $config Core config
     * @param array $arg    Call argument
     *
     * @since  1.0.0
     */
    public function __construct(array $config, array $arg)
    {
        if (PHP_SAPI !== 'cli') {
            throw new \Exception();
        }

        $this->setupHandlers();

        $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);
        $this->config = $config;
        $request      = $this->initRequest($config['language'][0]);
        $response     = $this->initResponse($request);

        UriFactory::setupUriBuilder($request->getUri());

        $this->run($request, $response);

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
        set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
    }

    /**
     * Initialize current application request
     *
     * @param string $language Fallback language
     *
     * @return Request Initial client request
     *
     * @since  1.0.0
     */
    private function initRequest(string $language) : Request
    {
        $request     = Request::createFromSuperglobals();
        $subDirDepth = substr_count($rootPath, '/');

        $request->createRequestHashs($subDirDepth);
        $request->getUri()->setRootPath($rootPath);
        UriFactory::setupUriBuilder($request->getUri());

        $request->getHeader()->getL11n()->setLanguage($language);
        UriFactory::setQuery('/lang', $language);

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param Request $request Client request
     *
     * @return Response Initial client request
     *
     * @since  1.0.0
     */
    private function initResponse(Request $request) : Response
    {
        $response = new Response(new Localization());

        $response->getHeader()->getL11n()->setLanguage($request->getHeader()->getL11n()->getLanguage());

        return $response;
    }

    /**
     * Rendering install.
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
        $this->dbPool = new DatabasePool();
        $this->dispatcher = new Dispatcher($this);
        $this->router = new Router();

        $this->setupRoutes();

        $this->dbPool->create('admin', $this->config['db']['core']['masters']['admin']);
        DataMapperAbstract::setConnection($this->dbPool->get());

        $response->getHeader()->set('content-language', $response->getHeader()->getL11n()->getLanguage(), true);
        UriFactory::setQuery('/lang', $response->getHeader()->getL11n()->getLanguage());

        $this->dispatcher->dispatch($this->router->route($request), $request, $response);
    }

    public function loadSetupFile(string $path) : array
    {
        return [];
    }

    public static function installRequest(Request $request, Response $response)
    {
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
            || ($valid['iSchemaPassword'] = empty($request->getData('schemapassword')))
            || ($valid['iCreateUser'] = empty($request->getData('createuser')))
            || ($valid['iCreatePassword'] = empty($request->getData('createpassword')))
            || ($valid['iSelectUser'] = empty($request->getData('selectuser')))
            || ($valid['iSelectPassword'] = empty($request->getData('selectpassword')))
            || ($valid['iDeleteUser'] = empty($request->getData('deleteuser')))
            || ($valid['iDeletePassword'] = empty($request->getData('deletepassword')))
            || ($valid['iDbName'] = !self::testDbConnection($request))
            || ($valid['iOrgName'] = empty($request->getData('orgname')))
            || ($valid['iAdminName'] = empty($request->getData('adminname')))
            || ($valid['iAdminPassword'] = empty($request->getData('adminpassword')))
            || ($valid['iAdminEmail'] = empty($request->getData('adminemail')))
            || ($valid['iDomain'] = empty($request->getData('domain')))
            || ($valid['iWebSubdir'] = empty($request->getData('websubdir')))
            || ($valid['iDefaultLang'] = empty($request->getData('defaultlang')))
        ) {
            return $valid;
        }

        return [];
    }

    private static function clearOld() : void
    {
        file_put_contents(__DIR__ . '/../Web/Backend/Routes.php', '<?php return [];');
        file_put_contents(__DIR__ . '/../Web/Api/Routes.php', '<?php return [];');
    }

    private static function hasPhpExtensions() : bool
    {
        return extension_loaded('pdo')
            && extension_loaded('mbstring');
    }

    private static function testDbConnection(Request $request) : bool
    {
        return true;
    }

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

    private static function installConfigFile(Request $request)
    {
        self::editConfigFile($request);
        self::editHtaccessFile($request);
    }

    private static function editConfigFile(Request $request)
    {
        $config = \file_get_contents(__DIR__ . '/../config.php');
    }

    private static function editHtaccessFile(Request $request)
    {
        $ht = \file_get_contents(__DIR__ . '/../.htaccess');
    }

    private static function installCore(ConnectionAbstract $db)
    {
        self::createModuleTable($db);
        self::createModuleLoadTable($db);
        self::installAdminModule($db);
    }

    private static function createModuleTable(ConnectionAbstract $db)
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

    private static function createModuleLoadTable(ConnectionAbstract $db)
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

    private static function installAdminModule(ConnectionAbstract $db)
    {
        $app = new class extends ApplicationAbstract
        {
        };
        $app->dbPool = new DatabasePool();
        $app->dbPool->add('select', $db);
        $app->dbPool->add('schema', $db);

        $moduleManager = new ModuleManager($app, __DIR__ . '/../Modules');
        $moduleManager->install('Admin');
    }

    private static function installGroups(ConnectionAbstract $db)
    {
        self::installMainGroups($db);
        self::installGroupPermissions($db);
    }

    private static function installMainGroups(ConnectionAbstract $db)
    {
        $date = new \DateTime('NOW', new \DateTimeZone('UTC'));

        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'group` (`group_name`, `group_desc`, `group_status`, `group_created`) VALUES
                (\'guest\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                (\'user\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\'),
                (\'admin\', NULL, ' . GroupStatus::ACTIVE . ', \'' . $date->format('Y-m-d H:i:s') . '\');'
        )->execute();
    }

    private static function installGroupPermissions(ConnectionAbstract $db)
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

    private static function installUsers(Request $request, ConnectionAbstract $db)
    {
        self::installUserLocalization($db);
        self::installMainUser($request, $db);
    }

    private static function installUserLocalization(ConnectionAbstract $db)
    {
        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'l11n` (`l11n_country`, `l11n_language`, `l11n_currency`, `l11n_number_thousand`, `l11n_number_decimal`, `l11n_angle`, `l11n_temperature`, `l11n_weight_very_light`, `l11n_weight_light`, `l11n_weight_medium`, `l11n_weight_heavy`, `l11n_weight_very_heavy`, `l11n_speed_very_slow`, `l11n_speed_slow`, `l11n_speed_medium`, `l11n_speed_fast`, `l11n_speed_very_fast`, `l11n_speed_sea`, `l11n_length_very_short`, `l11n_length_short`, `l11n_length_medium`, `l11n_length_long`, `l11n_length_very_long`, `l11n_length_sea`, `l11n_area_very_small`, `l11n_area_small`, `l11n_area_medium`, `l11n_area_large`, `l11n_area_very_large`, `l11n_volume_very_small`, `l11n_volume_small`, `l11n_volume_medium`, `l11n_volume_large`, `l11n_volume_very_large`, `l11n_volume_teaspoon`, `l11n_volume_tablespoon`, `l11n_volume_glass`) VALUES
                (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\'), (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\');'
        )->execute();
    }

    private static function installMainUser(Request $request, ConnectionAbstract $db)
    {
        $date = new \DateTime('NOW', new \DateTimeZone('UTC'));

        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'account` (`account_status`, `account_type`, `account_login`, `account_name1`, `account_name2`, `account_name3`, `account_password`, `account_email`, `account_tries`, `account_lactive`, `account_localization`, `account_created_at`) VALUES
                (' . AccountStatus::ACTIVE . ', ' . AccountType::USER . ', \'' . ((string) $request->getData('adminname')) . '\', \'' . ((string) $request->getData('adminname')) . '\', \'\', \'\', \'' . password_hash((string) $request->getData('adminpassword'), PASSWORD_DEFAULT) . '\', \'' . ((string) $request->getData('adminemail')) . '\', 5, \'' . $date->format('Y-m-d H:i:s') . '\', 2, \'' . $date->format('Y-m-d H:i:s') . '\'),
                (' . AccountStatus::ACTIVE . ', ' . AccountType::USER . ', \'guest\', \'Guest\', \'\', \'\', \'' . password_hash('guest', PASSWORD_DEFAULT) . '\', \'guest@email.com\', 5, \'' . $date->format('Y-m-d H:i:s') . '\', 2, \'' . $date->format('Y-m-d H:i:s') . '\');'
        )->execute();

        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'account_group` (`account_group_group`, `account_group_account`) VALUES
                (3, 1);'
        )->execute();
    }

    private static function installSettings(Request $request, ConnectionAbstract $db)
    {
        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'settings` (`settings_id`, `settings_module`, `settings_name`, `settings_content`, `settings_group`) VALUES
                (1000000001, NULL, \'username_length_max\', \'20\', NULL),
                (1000000002, NULL, \'username_length_min\', \'5\', NULL),
                (1000000003, NULL, \'password_length_max\', \'50\', NULL),
                (1000000004, NULL, \'password_length_min\', \'5\', NULL),
                (1000000005, NULL, \'login_tries\', \'3\', NULL),
                (1000000006, NULL, \'pass_special\', \'1\', NULL),
                (1000000007, NULL, \'pass_upper\', \'0\', NULL),
                (1000000008, NULL, \'pass_numeric\', \'1\', NULL),
                (1000000009, NULL, \'oname\', \'Orange Management\', NULL),
                (1000000010, NULL, \'theme\', \'oms-slim\', NULL),
                (1000000011, NULL, \'theme_path\', \'/oms-slim\', NULL),
                (1000000012, NULL, \'changed\', \'1\', NULL),
                (1000000013, NULL, \'login_status\', \'1\', NULL),
                (1000000014, NULL, \'login_msg\', \'Maintenance scheduled for tomorrow from 11:00 am to 1:00 pm.\', NULL),
                (1000000015, NULL, \'use_cache\', \'0\', NULL),
                (1000000016, NULL, \'last_recache\', \'0000-00-00 00:00:00\', NULL),
                (1000000017, NULL, \'public_access\', \'0\', NULL),
                (1000000018, NULL, \'rewrite\', \'0\', NULL),
                (1000000019, NULL, \'country\', \'DE\', NULL),
                (1000000020, NULL, \'language\', \'en\', NULL),
                (1000000021, NULL, \'timezone\', \'Europe/Berlin\', NULL),
                (1000000022, NULL, \'timeformat\', \'DD.MM.YYYY hh:mm:ss\', NULL),
                (1000000023, NULL, \'currency\', \'USD\', NULL),
                (1000000024, NULL, \'pass_lower\', \'1\', NULL),
                (1000000025, NULL, \'mail_admin\', \'mail@admin.com\', NULL),
                (1000000026, NULL, \'login_name\', \'1\', NULL),
                (1000000027, NULL, \'decimal_point\', \'.\', NULL),
                (1000000028, NULL, \'thousands_sep\', \',\', NULL),
                (1000000029, NULL, \'server_language\', \'en\', NULL)'
        )->execute();
    }
}
