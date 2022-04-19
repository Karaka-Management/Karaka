<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Install;

use Model\CoreSettings;
use Modules\Admin\Models\Account;
use Modules\Admin\Models\AccountCredentialMapper;
use Modules\Admin\Models\Group;
use Modules\Admin\Models\GroupMapper;
use Modules\Admin\Models\GroupPermission;
use Modules\Admin\Models\GroupPermissionMapper;
use Modules\Admin\Models\ModuleStatusUpdateType;
use Modules\Admin\Models\NullAccount;
use Modules\Media\Models\Collection;
use Modules\Media\Models\CollectionMapper;
use Modules\Organization\Models\Status;
use Modules\Organization\Models\UnitMapper;
use phpOMS\Account\AccountManager;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\GroupStatus;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\Schema\Builder as SchemaBuilder;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\RequestAbstract;
use phpOMS\Module\ModuleManager;
use phpOMS\System\File\Local\Directory;
use phpOMS\System\MimeType;
use phpOMS\Uri\HttpUri;
use phpOMS\Utils\IO\Zip\Zip;
use phpOMS\Utils\TestUtils;

/**
 * Application class.
 *
 * @package Install
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
abstract class InstallAbstract extends ApplicationAbstract
{
    /**
     * Module manager
     *
     * @var null|ModuleManager
     * @since 1.0.0
     */
    protected static ?ModuleManager $mManager = null;

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
        \file_put_contents(__DIR__ . '/../Cli/Routes.php', '<?php return [];');
        \file_put_contents(__DIR__ . '/../Cli/Hooks.php', '<?php return [];');

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

        self::$mManager      = self::$mManager ?? new ModuleManager($app, __DIR__ . '/../Modules/');
        $app->moduleManager  = self::$mManager;
        $app->appSettings    = new CoreSettings();
        $app->orgId          = 1;
        $app->accountManager = new AccountManager(new HttpSession());
        $app->l11nServer     = new Localization();
        $app->dispatcher     = new Dispatcher($app);
        $app->eventManager   = new EventManager($app->dispatcher);

        $toInstall = [
            'Admin',
            'Auditor',
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
            return; // @codeCoverageIgnore
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

        self::$mManager      = self::$mManager ?? new ModuleManager($app, __DIR__ . '/../Modules/');
        $app->moduleManager  = self::$mManager;
        $app->appSettings    = new CoreSettings();
        $app->orgId          = 1;
        $app->accountManager = new AccountManager(new HttpSession());
        $app->l11nServer     = new Localization();
        $app->dispatcher     = new Dispatcher($app);
        $app->eventManager   = new EventManager($app->dispatcher);
        $app->eventManager->importFromFile(__DIR__ . '/../Web/Api/Hooks.php');

        $toInstall = [
            'Workflow',
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
        /** @var \Modules\Organization\Models\Unit $default */
        $default       = UnitMapper::get()->where('id', 1)->execute();
        $default->name = (string) ($request->getData('orgname') ?? '');
        $default->setStatus(Status::ACTIVE);

        UnitMapper::update()->execute($default);

        // setup basic collections
        $collection       = new Collection();
        $collection->name = 'Modules';
        $collection->setVirtualPath('/');
        $collection->setPath('/Modules/Media/Files/Modules');
        $collection->createdBy = new NullAccount(1);

        CollectionMapper::create()->execute($collection);

        $collection       = new Collection();
        $collection->name = 'Accounts';
        $collection->setVirtualPath('/');
        $collection->setPath('/Modules/Media/Files/Accounts');
        $collection->createdBy = new NullAccount(1);

        CollectionMapper::create()->execute($collection);
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
        GroupMapper::create()->execute($guest);

        $user = new Group('user');
        $user->setStatus(GroupStatus::ACTIVE);
        GroupMapper::create()->execute($user);

        $admin = new Group('admin');
        $admin->setStatus(GroupStatus::ACTIVE);
        GroupMapper::create()->execute($admin);
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
        $searchPermission = new GroupPermission(
            group: 2,
            category: \Modules\Admin\Models\PermissionCategory::SEARCH,
            permission: PermissionType::READ
        );

        $adminPermission = new GroupPermission(
            group: 3,
            permission: PermissionType::READ | PermissionType::CREATE | PermissionType::MODIFY | PermissionType::DELETE | PermissionType::PERMISSION
        );

        GroupPermissionMapper::create()->execute($searchPermission);
        GroupPermissionMapper::create()->execute($adminPermission);
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

        /** @var \Modules\CMS\Controller\ApiController $module */
        $module = self::$mManager->get('CMS');

        foreach ($apps as $app) {
            $temp                  = new HttpRequest(new HttpUri(''));
            $temp->header->account = 1;
            $temp->setData('name', \basename($app));
            $temp->setData('theme', $theme);

            Zip::pack(__DIR__ . '/../' . $app, __DIR__ . '/' . \basename($app) . '.zip');

            TestUtils::setMember($temp, 'files', [
                [
                    'name'     => \basename($app) . '.zip',
                    'type'     => MimeType::M_ZIP,
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

        AccountCredentialMapper::create()->execute($account);

        $sth = $db->con->prepare(
            'INSERT INTO `account_group` (`account_group_group`, `account_group_account`) VALUES
                (3, ' . $account->getId() . ');'
        );

        if ($sth === false) {
            return; // @codeCoverageIgnore
        }

        $sth->execute();
    }
}
