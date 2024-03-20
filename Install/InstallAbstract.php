<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Install;

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
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\GroupStatus;
use phpOMS\Account\PermissionType;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Application\ApplicationType;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;
use phpOMS\DataStorage\Database\Schema\Builder as SchemaBuilder;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\RequestAbstract;
use phpOMS\Security\EncryptionHelper;
use phpOMS\System\File\Local\Directory;
use phpOMS\System\MimeType;
use phpOMS\Utils\IO\Zip\Zip;
use phpOMS\Utils\TestUtils;

/**
 * Application class.
 *
 * @package Install
 * @license OMS License 2.0
 * @link    https://jingga.app
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
        if ((\is_file(__DIR__ . '/../Cli/Routes.php') && !\is_writable(__DIR__ . '/../Cli/Routes.php'))
            || (\is_file(__DIR__ . '/../Cli/Hooks.php') && !\is_writable(__DIR__ . '/../Cli/Hooks.php'))
            || !\is_writable(__DIR__ . '/../Cli')
            || !\is_writable(__DIR__ . '/../Web')
        ) {
            return;
        }

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
        $db     = $request->getDataString('dbtype');
        $host   = $request->getDataString('dbhost');
        $port   = (int) $request->getData('dbport');
        $dbname = $request->getDataString('dbname');

        $admin  = ['login' => $request->getDataString('schemauser'), 'password' => $request->getDataString('schemapassword')];
        $insert = ['login' => $request->getDataString('createuser'), 'password' => $request->getDataString('createpassword')];
        $select = ['login' => $request->getDataString('selectuser'), 'password' => $request->getDataString('selectpassword')];
        $update = ['login' => $request->getDataString('updateuser'), 'password' => $request->getDataString('updatepassword')];
        $delete = ['login' => $request->getDataString('deleteuser'), 'password' => $request->getDataString('deletepassword')];
        $schema = ['login' => $request->getDataString('schemauser'), 'password' => $request->getDataString('schemapassword')];

        $subdir = $request->getDataString('websubdir');
        $tld    = $request->getDataString('domain');

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
        $fullTLD     = $request->getDataString('domain');
        $tld         = \str_replace(['.', 'http://', 'https://'], ['\.', '', ''], $request->getDataString('domain') ?? '');
        $subPath     = $request->getDataString('websubdir') ?? '/';
        $privateKeyI = EncryptionHelper::createSharedKey();

        $config = include __DIR__ . '/Templates/htaccess.tpl.php';

        $_SERVER['OMS_PRIVATE_KEY_I'] = $privateKeyI;

        \file_put_contents(__DIR__ . '/../.htaccess', $config);
    }

    /**
     * Install core functionality
     *
     * @param ApplicationAbstract $app Application
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installCore(ApplicationAbstract $app) : void
    {
        self::createBaseTables($app->dbPool->get('schema'));

        $toInstall = [
            'Admin',
            'Auditor',
        ];

        $module     = $app->moduleManager->get('Admin', 'Api');
        $auditor    = $app->moduleManager->get('Auditor', 'Api');
        $monitoring = $app->moduleManager->get('Monitoring', '');

        $auditor->active    = false;
        $monitoring->active = false;

        $response                 = new HttpResponse();
        $request                  = new HttpRequest();
        $request->header->account = 1;
        $request->setData('status', ModuleStatusUpdateType::INSTALL);

        foreach ($toInstall as $install) {
            $request->setData('module', $install, true);
            $module->apiModuleStatusUpdate($request, $response);
        }

        $auditor->active    = true;
        $monitoring->active = true;
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
        if ($definitions === false) {
            return;
        }

        /** @var array $definitions */
        foreach ($definitions as $definition) {
            SchemaBuilder::createFromSchema($definition, $db)->execute();
        }
    }

    /**
     * Install the core modules
     *
     * @param ApplicationAbstract $app Application
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installCoreModules(ApplicationAbstract $app) : void
    {
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
        $request                  = new HttpRequest();
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
        $default         = UnitMapper::get()->where('id', 1)->execute();
        $default->name   = $request->getDataString('orgname') ?? '';
        $default->status = Status::ACTIVE;

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
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installGroups() : void
    {
        self::installMainGroups();
        self::installGroupPermissions();
    }

    /**
     * Create basic groups in db
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installMainGroups() : void
    {
        $guest         = new Group('guest');
        $guest->status = GroupStatus::ACTIVE;
        GroupMapper::create()->execute($guest);

        $user         = new Group('user');
        $user->status = GroupStatus::ACTIVE;
        GroupMapper::create()->execute($user);

        $admin         = new Group('admin');
        $admin->status = GroupStatus::ACTIVE;
        GroupMapper::create()->execute($admin);
    }

    /**
     * Set permissions of basic groups
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installGroupPermissions() : void
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
     * @param RequestAbstract     $request Request
     * @param ApplicationAbstract $app     Database connection
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installLocalApplications(RequestAbstract $request, ApplicationAbstract $app) : void
    {
        $apps  = ['Cli'];
        $theme = 'Default';

        /** @var \Modules\Admin\Controller\ApiController $module */
        $module = $app->moduleManager->get('Admin');

        foreach ($apps as $app) {
            $temp                  = new HttpRequest();
            $temp->header->account = 1;
            $temp->data['name']    = $app;
            $temp->data['type']    = ApplicationType::CONSOLE;

            $module->apiApplicationCreate($temp, new HttpResponse());
        }
    }

    /**
     * Install applications
     *
     * @param RequestAbstract     $request Request
     * @param ApplicationAbstract $app     Application
     *
     * @return void
     *
     * @since 1.0.0
     */
    protected static function installWebApplications(RequestAbstract $request, ApplicationAbstract $app) : void
    {
        $apps  = $request->getDataList('apps');
        $theme = 'Default';

        /** @var \Modules\CMS\Controller\ApiController $module */
        $module = $app->moduleManager->get('CMS');

        foreach ($apps as $appName) {
            $temp                  = new HttpRequest();
            $temp->header->account = 1;
            $temp->data['name']    = \basename($appName);
            $temp->data['type']    = ApplicationType::WEB;
            $temp->data['theme']   = $theme;

            Zip::pack(__DIR__ . '/../' . $appName, __DIR__ . '/' . \basename($appName) . '.zip');

            TestUtils::setMember($temp, 'files', [
                [
                    'name'     => \basename($appName) . '.zip',
                    'type'     => MimeType::M_ZIP,
                    'tmp_name' => __DIR__ . '/' . \basename($appName) . '.zip',
                    'error'    => \UPLOAD_ERR_OK,
                    'size'     => \filesize(__DIR__ . '/' . \basename($appName) . '.zip'),
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
        $account         = new Account();
        $account->status = AccountStatus::ACTIVE;
        $account->tries  = 0;
        $account->type   = AccountType::USER;
        $account->login  = $request->getDataString('adminname') ?? '';
        $account->name1  = $request->getDataString('adminname') ?? '';
        $account->generatePassword($request->getDataString('adminpassword') ?? '');
        $account->setEmail($request->getDataString('adminemail') ?? '');

        $l11n = $account->l11n;
        $l11n->loadFromLanguage(
            $request->getDataString('defaultlang') ?? 'en',
            $request->getDataString('defaultcountry') ?? 'us'
        );

        AccountCredentialMapper::create()->execute($account);

        $sth = $db->con->prepare(
            'INSERT INTO `account_group` (`account_group_group`, `account_group_account`) VALUES
                (3, ' . $account->id . ');'
        );

        if ($sth === false) {
            return; // @codeCoverageIgnore
        }

        $sth->execute();
    }
}
