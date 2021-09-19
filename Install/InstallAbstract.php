<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Install;

use Model\CoreSettings;
use Model\Setting;
use Model\SettingMapper;
use Model\SettingsEnum;
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
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use Modules\Admin\Models\ModuleStatusUpdateType;

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
     * @codeCoverageIgnore
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
            return; // @codeCoverageIgnore
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

        $app = new class() extends ApplicationAbstract
        {
            protected string $appName = 'Api';
        };

        $app->dbPool = new DatabasePool();
        $app->dbPool->add('select', $db);
        $app->dbPool->add('insert', $db);
        $app->dbPool->add('update', $db);
        $app->dbPool->add('schema', $db);

        self::$mManager     = new ModuleManager($app, __DIR__ . '/../Modules/');
        $app->moduleManager = self::$mManager;
        $app->appSettings   = new CoreSettings($db);

        self::$mManager->install('Admin');
        self::$mManager->install('Auditor');
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

        if (!\is_file($path)) {
            return;
        }

        $content = \file_get_contents($path);
        if ($content === false) {
            return; // @codeCoverageIgnore
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

        $app->dispatcher   = new Dispatcher($app);
        $app->eventManager = new EventManager($app->dispatcher);
        $app->eventManager->importFromFile(__DIR__ . '/../Web/Api/Hooks.php');

        $app->appSettings   = new CoreSettings($db);
        self::$mManager     = new ModuleManager($app, __DIR__ . '/../Modules/');
        $app->moduleManager = self::$mManager;

        $toInstall = [
            'Organization',
            'Help',
            'Profile',
            'Navigation',
            'Dashboard',
            'CMS',
        ];

        $module = $app->moduleManager->get('Admin');

        $response                 = new HttpResponse();
        $request                  = new HttpRequest(new HttpUri(''));
        $request->header->account = 1;
        $request->setData('status', ModuleStatusUpdateType::INSTALL);

        foreach ($toInstall as $install) {
            $request->setData('module', $install, true);
            $module->apiModuleStatusUpdate($request, $response);
        }
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
        $default       = UnitMapper::get(1);
        $default->name = (string) ($request->getData('orgname') ?? '');
        $default->setStatus(Status::ACTIVE);

        UnitMapper::update($default);

        // setup basic collections
        $collection       = new Collection();
        $collection->name = 'Modules';
        $collection->setVirtualPath('/');
        $collection->setPath('/Modules/Media/Files/Modules');
        $collection->createdBy = new NullAccount(1);

        CollectionMapper::create($collection);

        $collection       = new Collection();
        $collection->name = 'Accounts';
        $collection->setVirtualPath('/');
        $collection->setPath('/Modules/Media/Files/Accounts');
        $collection->createdBy = new NullAccount(1);

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
        $sth = $db->con->prepare(
            'INSERT INTO `group_permission` (`group_permission_group`, `group_permission_unit`, `group_permission_app`, `group_permission_module`, `group_permission_from`, `group_permission_type`, `group_permission_element`, `group_permission_component`, `group_permission_permission`) VALUES
                (2, null, null, NULL, NULL, ' . \Modules\Admin\Models\PermissionState::SEARCH . ', NULL, NULL, ' . (PermissionType::READ) . '),
                (3, null, null, NULL, NULL, NULL, NULL, NULL, ' . (PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION) . ');'
        );

        if ($sth === false) {
            return;
        }

        $sth->execute();
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
        $theme = 'Default';

        /** @var ApiController $module */
        $module = self::$mManager->get('CMS');

        foreach ($apps as $app) {
            $temp                  = new HttpRequest(new HttpUri(''));
            $temp->header->account = 1;
            $temp->setData('name', \basename($app));
            $temp->setData('theme', $theme);

            Zip::pack(__DIR__ . '/../' . $app, __DIR__ . '/' . \basename($app) . '.zip');

            TestUtils::setMember($temp, 'files', [
                [
                    'name'     => \basename($app),
                    'type'     => 'zip',
                    'tmp_name' => __DIR__ . '/' . \basename($app) . '.zip',
                    'error'    => \UPLOAD_ERR_OK,
                    'size'     => \filesize(__DIR__ . '/' . \basename($app) . '.zip'),
                ],
            ]);

            $module->apiApplicationInstall($temp, new HttpResponse());
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
        $account->tries = 0;
        $account->setType(AccountType::USER);
        $account->login = (string) $request->getData('adminname');
        $account->name1 = (string) $request->getData('adminname');
        $account->generatePassword((string) $request->getData('adminpassword'));
        $account->setEmail((string) $request->getData('adminemail'));

        $l11n = $account->l11n;
        $l11n->loadFromLanguage($request->getData('defaultlang') ?? 'en', $request->getData('defaultcountry') ?? 'us');

        AccountMapper::create($account);

        $sth = $db->con->prepare(
            'INSERT INTO `account_group` (`account_group_group`, `account_group_account`) VALUES
                (3, ' . $account->getId() . ');'
        );

        if ($sth === false) {
            return;
        }

        $sth->execute();
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
        $setting = new Setting();
        SettingMapper::create($setting->with(0, SettingsEnum::PASSWORD_PATTERN, ''));
        SettingMapper::create($setting->with(0, SettingsEnum::LOGIN_TRIES, '3', '\\d+'));
        SettingMapper::create($setting->with(0, SettingsEnum::LOGIN_TIMEOUT, '3', '\\d+'));
        SettingMapper::create($setting->with(0, SettingsEnum::PASSWORD_INTERVAL, '90', '\\d+'));
        SettingMapper::create($setting->with(0, SettingsEnum::PASSWORD_HISTORY, '3', '\\d+'));
        SettingMapper::create($setting->with(0, SettingsEnum::LOGGING_STATUS, '1', '[0-3]'));
        SettingMapper::create($setting->with(0, SettingsEnum::LOGGING_PATH, ''));
        SettingMapper::create($setting->with(0, SettingsEnum::DEFAULT_ORGANIZATION, '1', '\\d+'));
        SettingMapper::create($setting->with(0, SettingsEnum::LOGIN_STATUS, '1', '[0-3]'));
        SettingMapper::create($setting->with(0, SettingsEnum::DEFAULT_LOCALIZATION, '1', '\\d+'));
        SettingMapper::create($setting->with(0, SettingsEnum::ADMIN_MAIL, 'admin@orange-management.org', "(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])"));

        $l11n = Localization::fromLanguage($request->getData('defaultlang'), $request->getData('defaultcountry') ?? '*');
        LocalizationMapper::create($l11n);
    }
}
