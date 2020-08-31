<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package    Socket
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types=1);

namespace Socket\Socketserver;

use Model\CoreSettings;
use phpOMS\Account\AccountManager;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Log\FileLogger;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\SocketRouter;
use phpOMS\Socket\Server\Server;
use phpOMS\Socket\SocketType;
use Socket\SocketApplication;

/**
 * Controller class.
 *
 * @package    Socket
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 * @codeCoverageIgnore
 */
class Application
{
    /**
     * SocketApplication.
     *
     * @var SocketApplication
     * @since 1.0.0
     */
    private SocketApplication $app;

    /**
     * Socket type.
     *
     * @var SocketType
     * @since 1.0.0
     */
    protected string $type;

    /**
     * Temp array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}, socket:array{master:array}}
     *
     * @var array
     * @since 1.0.0
     */
    protected array $config;

    /**
     * Constructor.
     *
     * @param SocketApplication                                                                                                                                                                                                                                                                                                                                                                                                                                                                    $app    SocketApplication
     * @param array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}, socket:array{master:array}} $config Application config
     *
     * @since 1.0.0
     */
    public function __construct(SocketApplication $app, array $config)
    {
        $this->app     = $app;
        $this->appName = 'Socketserver';
        $this->config  = $config;

        $this->app->logger = FileLogger::getInstance($config['log']['file']['path'], true);

        $this->app->logger->info('Setting up TCP socket application...');

        $this->app->dbPool = new DatabasePool();
        $this->app->dbPool->create('core', $config['db']['core']['masters']['admin']);
        $this->app->dbPool->create('select', $config['db']['core']['masters']['select']);

        if ($this->app->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            //$this->app->create503Response($response, $pageView);

            return;
        }

        /**
         * @todo Orange-Management/phpOMS#230
         *  Create socket session
         *  Maybe use the ConsoleSocket
         */
        $this->app->sessionManager = new HttpSession(36000);
        $this->app->cachePool      = new CachePool($this->app->dbPool);
        $this->app->appSettings    = new CoreSettings($this->app->dbPool->get());
        $this->app->eventManager   = new EventManager($this->app->dispatcher);
        $this->app->accountManager = new AccountManager($this->app->sessionManager);

        $this->app->router = new SocketRouter();
        $this->app->router->importFromFile(__DIR__ . '/Routes.php');

        $this->app->moduleManager = new ModuleManager($this->app, __DIR__ . '/../../Modules');
        $this->app->dispatcher    = new Dispatcher($this->app);
        $this->app->l11nManager   = new L11nManager($this->appName);

        $this->app->logger->info('Initializing active modules...');
        /*$modules = $this->moduleManager->getActiveModules();
        foreach ($modules as $name => $module) {
            $this->moduleManager->initModule($name);
        }*/

        $this->socket = new Server($this->app);
        $this->socket->create('127.0.0.1', $config['socket']['master']['port']);
        $this->socket->setLimit($config['socket']['master']['limit']);
    }

    /**
     * Run the socket
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function run() : void
    {
        $this->socket->run();
    }
}
