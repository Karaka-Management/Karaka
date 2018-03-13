<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
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
                'For a list of commands for a specific module type: -h --module_name' , "\033[0;31;47m some colored text \033[0m some white text \n\n\n" ,
                str_pad('     --installed', 25, ' '), 'list of all installed modules' , "\n" ,
                str_pad(' -i, --install', 25, ' '), 'installs the application based on predefined install settings' , "\n" ,
                str_pad('', 25, ' '), 'example: -i /path/to/install.json' , "\n" ,
                "\n";
        }, null);

        $commandManager->attach('--installed', function ($para) use($modules) {
            $sorted = $modules;
            $length = count($sorted);

            sort($sorted);

            for ($i = 0; $i < $length; $i += 4) {
                echo str_pad($sorted[$i], 30, ' ');

                if (isset($sorted[$i + 1])) {
                    echo str_pad($sorted[$i + 1], 30, ' ');
                }

                if (isset($sorted[$i + 2])) {
                    echo str_pad($sorted[$i + 2], 30, ' ');
                }

                if (isset($sorted[$i + 3])) {
                    echo str_pad($sorted[$i + 3], 30, ' ');
                }

                echo "\n";
            }

            echo "\n";
        }, null);

        $commandManager->trigger($arg[1] ?? '', $arg);
    }
}
