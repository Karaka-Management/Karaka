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
 * @link       http://website.orange-management.de
 */
namespace Console;

use Model\CoreSettings;
use phpOMS\ApplicationAbstract;
use phpOMS\Console\CommandManager;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Log\FileLogger;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\Router;

/**
 * Controller class.
 *
 * @category   Framework
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ConsoleApplication extends ApplicationAbstract
{

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

        $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);

        $this->dbPool = new DatabasePool();
        $this->dbPool->create('core', $config['db']['core']['masters'][0]);

        $this->cachePool      = new CachePool($this->dbPool);
        $this->appSettings    = new CoreSettings($this->dbPool->get());
        $this->eventManager   = new EventManager();
        $this->router         = new Router();
        $this->sessionManager = new HttpSession(36000);
        $this->moduleManager  = new ModuleManager($this);
        $this->l11nManager    = new L11nManager($this->logger);
        $this->dispatcher     = new Dispatcher($this);
        $commandManager       = new CommandManager();

        $modules = $this->moduleManager->getActiveModules();
        $this->moduleManager->initModule($modules);

        $commandManager->attach('', function ($para) {
            echo 'Use -h for help.';
        }, null);

        $commandManager->trigger($arg[1] ?? '', $arg);
    }
}
