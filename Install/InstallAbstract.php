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

use Modules\Admin\Controller\ApiController;
use Modules\Admin\Models\Account;
use Modules\Admin\Models\AccountMapper;
use Modules\Admin\Models\Group;
use Modules\Admin\Models\GroupMapper;
use Modules\Admin\Models\LocalizationMapper;
use Modules\Admin\Models\NullAccount;
use Modules\Media\Models\Collection;
use Modules\Media\Models\CollectionMapper;
use Modules\Organization\Models\Status;
use Modules\Organization\Models\UnitMapper;

use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\GroupStatus;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\Schema\Builder as SchemaBuilder;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\RequestAbstract;
use phpOMS\Module\ModuleManager;
use phpOMS\System\File\Local\Directory;
use phpOMS\Uri\HttpUri;

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
     * Module manager
     *
     * @var ModuleManager
     * @since 1.0.0
     */
    protected static ModuleManager $mManager;

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
        \file_put_contents(__DIR__ . '/../Console/Routes.php', '<?php return [];');
        \file_put_contents(__DIR__ . '/../Console/Hooks.php', '<?php return [];');

        $dirs = \scandir(__DIR__ . '/../Web');

        if ($dirs === false) {
            return;
        }

        foreach ($dirs as $dir) {
            if ($dir === '.' || $dir === '..'
                || $dir === 'Exception'
                || $dir === 'WebApplication.php'
            ) {
                continue;
            }
                Directory::delete(__DIR__ . '/../Web/' . $dir);
        }
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
            'port'     => (int) $request->getData('dbport'),
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

        $admin  = ['login' => $request->getData('schemauser'), 'password' => $request->getData('schemapassword')];
        $insert = ['login' => $request->getData('createuser'), 'password' => $request->getData('createpassword')];
        $select = ['login' => $request->getData('selectuser'), 'password' => $request->getData('selectpassword')];
        $update = ['login' => $request->getData('updateuser'), 'password' => $request->getData('updatepassword')];
        $delete = ['login' => $request->getData('deleteuser'), 'password' => $request->getData('deletepassword')];
        $schema = ['login' => $request->getData('schemauser'), 'password' => $request->getData('schemapassword')];

        $subdir = $request->getData('websubdir');
        $tld    = $request->getData('domain');

        $tldOrg     = 1;
        $defaultOrg = 1;

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
        $app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };


        $app->dbPool = new DatabasePool();
        $app->dbPool->add('select', $db);
        $app->dbPool->add('insert', $db);
        $app->dbPool->add('update', $db);
        $app->dbPool->add('schema', $db);

        self::$mManager     = new ModuleManager($app, __DIR__ . '/../Modules');
        $app->moduleManager = self::$mManager;

        self::$mManager->install('Admin');
        self::$mManager->install('Auditor');
        self::$mManager->install('Organization');
        self::$mManager->install('Help');
        self::$mManager->install('Profile');
        self::$mManager->install('Navigation');
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
        $collection->setPath('/');
        $collection->setCreatedBy(new NullAccount(1));

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
        $guest = new Group('guest');
        $guest->setStatus(GroupStatus::ACTIVE);
        GroupMapper::create($guest);

        $user = new Group('user');
        $user->setStatus(GroupStatus::ACTIVE);
        GroupMapper::create($user);

        $admin = new Group('admin');
        $admin->setStatus(GroupStatus::ACTIVE);
        GroupMapper::create($admin);
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
            'INSERT INTO `' . 'group_permission` (`group_permission_group`, `group_permission_unit`, `group_permission_app`, `group_permission_module`, `group_permission_from`, `group_permission_type`, `group_permission_element`, `group_permission_component`, `group_permission_permission`) VALUES
                (3, null, null, NULL, NULL, NULL, NULL, NULL, ' . (PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION) . ');'
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
        self::installMainUser($request, $db);
    }

    /**
     * Install applications
     *
     * @param RequestAbstract    $request Request
     * @param ConnectionAbstract $db      Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installApplications(RequestAbstract $request, ConnectionAbstract $db) : void
    {
        $apps  = $request->getDataList('apps');
        $theme = 'Akebi';

        /** @var ApiController $module */
        $module = self::$mManager->get('Admin');

        foreach ($apps as $app) {
            $temp = new HttpRequest(new HttpUri(''));
            $temp->getHeader()->setAccount(1);
            $temp->setData('appSrc', $app);
            $temp->setData('appDest', 'Web/' . \basename($app));
            $temp->setData('theme', $theme);

            $module->apiInstallApplication($temp, new HttpResponse());
        }
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
        $account = new Account();
        $account->setStatus(AccountStatus::ACTIVE);
        $account->setLoginTries(3);
        $account->setType(AccountType::USER);
        $account->setName((string) $request->getData('adminname'));
        $account->setName1((string) $request->getData('adminname'));
        $account->generatePassword((string) $request->getData('adminpassword'));
        $account->setEmail((string) $request->getData('adminemail'));

        $l11n = $account->getL11n();
        $l11n->loadFromLanguage($request->getData('defaultlang') ?? 'en', $request->getData('defaultcountry') ?? 'us');

        AccountMapper::create($account);

        $db->con->prepare(
            'INSERT INTO `' . 'account_group` (`account_group_group`, `account_group_account`) VALUES
                (3, ' . $account->getId() . ');'
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
            'INSERT INTO `' . 'settings` (`settings_name`, `settings_content`) VALUES
                (' . Settings::PASSWORD_PATTERN . ', \'\'),
                (' . Settings::LOGIN_TIMEOUT . ', \'3\'),
                (' . Settings::PASSWORD_INTERVAL . ', \'90\'),
                (' . Settings::PASSWORD_HISTORY . ', \'3\'),
                (' . Settings::LOGIN_TRIES . ', \'3\'),
                (' . Settings::LOGGING_STATUS . ', \'1\'),
                (' . Settings::LOGGING_PATH . ', \'\'),
                (' . Settings::DEFAULT_ORGANIZATION . ', \'1\'),
                (1000000010, \'oms-slim\'),
                (1000000011, \'/oms-slim\'),
                (1000000012, \'1\'),
                (' . Settings::LOGIN_STATUS . ', \'1\'),
                (1000000014, \'Maintenance scheduled for tomorrow from 11:00 am to 1:00 pm.\'),
                (1000000015, \'0\'),
                (1000000016, \'0000-00-00 00:00:00\'),
                (1000000017, \'0\'),
                (1000000018, \'0\'),
                (1000000019, \'DE\'),
                (1000000020, \'en\'),
                (1000000021, \'Europe/Berlin\'),
                (1000000023, \'USD\'),
                (1000000025, \'mail@admin.com\')'
        )->execute();

        $l11n = Localization::fromLanguage($request->getData('defaultlang'), $request->getData('defaultcountry') ?? '*');
        LocalizationMapper::create($l11n);
    }
}
