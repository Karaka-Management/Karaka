<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Install;

use Model\Settings;

use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\GroupStatus;
use phpOMS\Account\PermissionType;
use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\Schema\Builder as SchemaBuilder;
use phpOMS\Message\RequestAbstract;
use phpOMS\Module\ModuleManager;

use Modules\Media\Models\Collection;
use Modules\Media\Models\CollectionMapper;

use Modules\Organization\Models\UnitMapper;
use Modules\Organization\Models\Status;

/**
 * Application class.
 *
 * @package Install
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
abstract class InstallAbstract extends ApplicationAbstract
{
    /**
     * Setup general handlers for the application.
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected function setupHandlers() : void
    {
        \set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        \set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        \register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
        \mb_internal_encoding('UTF-8');
    }

    /**
     * Clear old install
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function clearOld() : void
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
     * @since 1.0.0
     */
    protected static function hasPhpExtensions() : bool
    {
        return \extension_loaded('pdo')
            && \extension_loaded('mbstring');
    }

    /**
     * Check if database connection is correct and working
     *
     * @param RequestAbstract $request Request
     *
     * @return bool
     *
     * @since 1.0.0
     */
    protected static function testDbConnection(RequestAbstract $request) : bool
    {
        return true;
    }

    /**
     * Create database connection
     *
     * @param RequestAbstract $request Request
     *
     * @return ConnectionAbstract
     *
     * @since 1.0.0
     */
    protected static function setupDatabaseConnection(RequestAbstract $request) : ConnectionAbstract
    {
        return ConnectionFactory::create([
            'db'       => (string) $request->getData('dbtype'),
            'host'     => (string) $request->getData('dbhost'),
            'port'     => (string) $request->getData('dbport'),
            'prefix'   => (string) $request->getData('dbprefix'),
            'database' => (string) $request->getData('dbname'),
            'login'    => (string) $request->getData('schemauser'),
            'password' => (string) $request->getData('schemapassword'),
        ]);
    }

    /**
     * Install/setup configuration
     *
     * @param RequestAbstract $request Request
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installConfigFile(RequestAbstract $request) : void
    {
        self::editConfigFile($request);
        self::editHtaccessFile($request);
    }

    /**
     * Modify config file
     *
     * @param RequestAbstract $request Request
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function editConfigFile(RequestAbstract $request) : void
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
     * @param RequestAbstract $request Request
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function editHtaccessFile(RequestAbstract $request) : void
    {
        $fullTLD = $request->getData('domain');
        $tld     = \str_replace(['.', 'http://', 'https://'], ['\.', '', ''], $request->getData('domain') ?? '');
        $subPath = $request->getData('websubdir') ?? '/';

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
     * @since 1.0.0
     */
    protected static function installCore(ConnectionAbstract $db) : void
    {
        self::createBaseTables($db);
        self::installCoreModules($db);
    }

    /**
     * Create module table
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function createBaseTables(ConnectionAbstract $db) : void
    {
        $path = __DIR__ . '/db.json';

        if (!\file_exists($path)) {
            return;
        }

        $content = \file_get_contents($path);
        if ($content === false) {
            return;
        }

        $definitions = \json_decode($content, true);
        foreach ($definitions as $definition) {
            SchemaBuilder::createFromSchema($definition, $db)->execute();
        }
    }

    /**
     * Install the core modules
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installCoreModules(ConnectionAbstract $db) : void
    {
        $app = new class extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $app->dbPool = new DatabasePool();

        $app->dbPool->add('select', $db);
        $app->dbPool->add('insert', $db);
        $app->dbPool->add('update', $db);
        $app->dbPool->add('schema', $db);

        $moduleManager = new ModuleManager($app, __DIR__ . '/../Modules');

        $moduleManager->install('Admin');
        $moduleManager->install('Auditor');
        $moduleManager->install('Organization');
        $moduleManager->install('Help');
        $moduleManager->install('Profile');
        $moduleManager->install('Navigation');
    }

    /**
     * Configure the core modules
     *
     * @param RequestAbstract    $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function configureCoreModules(RequestAbstract $request, ConnectionAbstract $db) : void
    {
        // setup basic units
        $default = UnitMapper::get(1);
        $default->setName((string) ($request->getData('orgname') ?? ''));
        $default->setStatus(Status::ACTIVE);

        UnitMapper::update($default);

        // setup basic collections
        $collection = new Collection();
        $collection->setName('Modules');
        $collection->setVirtualPath('/');
        $collection->setCreatedBy(1);

        CollectionMapper::create($collection);
    }

    /**
     * Install basic groups
     *
     * @param ConnectionAbstract $db Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installGroups(ConnectionAbstract $db) : void
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
     * @since 1.0.0
     */
    protected static function installMainGroups(ConnectionAbstract $db) : void
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
     * @since 1.0.0
     */
    protected static function installGroupPermissions(ConnectionAbstract $db) : void
    {
        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'group_permission` (`group_permission_group`, `group_permission_unit`, `group_permission_app`, `group_permission_module`, `group_permission_from`, `group_permission_type`, `group_permission_element`, `group_permission_component`, `group_permission_permission`) VALUES
                (3, null, \'backend\', NULL, NULL, NULL, NULL, NULL, ' . (PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION) . ');'
        )->execute();

        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'group_permission` (`group_permission_group`, `group_permission_unit`, `group_permission_app`, `group_permission_module`, `group_permission_from`, `group_permission_type`, `group_permission_element`, `group_permission_component`, `group_permission_permission`) VALUES
                (3, null, \'api\', NULL, NULL, NULL, NULL, NULL, ' . (PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION) . ');'
        )->execute();
    }

    /**
     * Install users
     *
     * @param RequestAbstract    $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installUsers(RequestAbstract $request, ConnectionAbstract $db) : void
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
     * @since 1.0.0
     */
    protected static function installUserLocalization(ConnectionAbstract $db) : void
    {
        /**
         * @todo: load settings defined by install script
         */
        $db->con->prepare(
            'INSERT INTO `' . $db->prefix . 'l11n` (`l11n_country`, `l11n_language`, `l11n_currency`, `l11n_number_thousand`, `l11n_number_decimal`, `l11n_angle`, `l11n_temperature`, `l11n_weight_very_light`, `l11n_weight_light`, `l11n_weight_medium`, `l11n_weight_heavy`, `l11n_weight_very_heavy`, `l11n_speed_very_slow`, `l11n_speed_slow`, `l11n_speed_medium`, `l11n_speed_fast`, `l11n_speed_very_fast`, `l11n_speed_sea`, `l11n_length_very_short`, `l11n_length_short`, `l11n_length_medium`, `l11n_length_long`, `l11n_length_very_long`, `l11n_length_sea`, `l11n_area_very_small`, `l11n_area_small`, `l11n_area_medium`, `l11n_area_large`, `l11n_area_very_large`, `l11n_volume_very_small`, `l11n_volume_small`, `l11n_volume_medium`, `l11n_volume_large`, `l11n_volume_very_large`, `l11n_volume_teaspoon`, `l11n_volume_tablespoon`, `l11n_volume_glass`) VALUES
                (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\'), (\'DE\', \'EN\', \'EUR\', \',\', \'.\', \'degree\', \'celsius\', \'mg\', \'g\', \'kg\', \'t\', \'t\', \'ms\', \'ms\', \'kph\', \'kph\', \'kph\', \'knot\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'mile\', \'mm\', \'cm\', \'m\', \'km\', \'km\', \'ml\', \'cl\', \'l\', \'l\', \'l\', \'metric teaspoon\', \'metric tablespoon\', \'metric glass\');'
        )->execute();
    }

    /**
     * Setup root user in database
     *
     * @param RequestAbstract    $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installMainUser(RequestAbstract $request, ConnectionAbstract $db) : void
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
     * @param RequestAbstract    $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installSettings(RequestAbstract $request, ConnectionAbstract $db) : void
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
                (' . Settings::DEFAULT_ORGANIZATION . ', NULL, \'oname\', \'1\', NULL),
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
