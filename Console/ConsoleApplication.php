<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Console
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Console;

use Model\CoreSettings;
use phpOMS\ApplicationAbstract;
use phpOMS\Console\CommandManager;
use phpOMS\Account\AccountManager;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\ConsoleSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Log\FileLogger;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\Router;

/**
 * Application class.
 *
 * @package    Console
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class ConsoleApplication extends ApplicationAbstract
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
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function __construct(array $config, array $arg)
    {
        if (PHP_SAPI !== 'cli') {
            throw new \Exception();
        }

        $this->setupHandlers();

        $this->config = $config;
        $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);
        $this->dbPool = new DatabasePool();

        $this->dbPool->create('core', $this->config['db']['core']['masters']['admin']);
        $this->dbPool->add('insert', $this->dbPool->get('core'));
        $this->dbPool->add('select', $this->dbPool->get('core'));
        $this->dbPool->add('update', $this->dbPool->get('core'));
        $this->dbPool->add('delete', $this->dbPool->get('core'));
        $this->dbPool->add('schema', $this->dbPool->get('core'));

        $this->l11nManager = new L11nManager();
        $this->router      = new Router();
        $this->router->importFromFile(__DIR__ . '/Routes.php');

        $this->cachePool      = new CachePool();
        $this->appSettings    = new CoreSettings($this->dbPool->get());
        $this->eventManager   = new EventManager();
        $this->sessionManager = new ConsoleSession();
        $this->accountManager = new AccountManager($this->sessionManager);
        $this->moduleManager  = new ModuleManager($this, __DIR__ . '/../../Modules');
        $this->dispatcher     = new Dispatcher($this);
        $commandManager       = new CommandManager();

        $modules = $this->moduleManager->getActiveModules();
        $this->moduleManager->initModule($modules);

        $commandManager->attach('', function ($para) {
            echo 'Useage: -h for help.';
        }, null);

        $commandManager->attach('-h', function ($para) {
            echo "\n" , 
                'For a list of commands for a specific module type: ' , "\033[0;31m/help/{MODULE_NAME}\033[0m" , "\n\n";
        }, null);

        $commandManager->trigger($arg[1] ?? '', $arg);
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
}
