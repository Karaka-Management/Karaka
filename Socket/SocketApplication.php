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

namespace Socket;

use Model\CoreSettings;
use phpOMS\Account\AccountManager;
use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Log\FileLogger;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Socket\Client\Client;
use phpOMS\Socket\Server\Server;
use phpOMS\Socket\SocketType;
use phpOMS\DataStorage\Database\DatabaseStatus;

/**
 * Controller class.
 *
 * @package    Socket
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class SocketApplication extends ApplicationAbstract
{

    /**
     * Socket type.
     *
     * @var   SocketType
     * @since 1.0.0
     */
    protected string $type;

    /**
     * Temp config.
     *
     * @var   array
     * @since 1.0.0
     */
    protected array $config = [];

    /**
     * Constructor.
     *
     * @param array  $config Core config
     * @param string $type   Socket type
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function __construct(array $config, string $type)
    {
        $this->setupHandlers();

        $this->appName = 'Backend';
        $this->config       = $config;

        $this->type   = $type;
        $socket       = null;
        $this->logger = FileLogger::getInstance($config['log']['file']['path'], true);

        if ($type === SocketType::TCP_SERVER) {
            $this->logger->info('Setting up TCP socket application...');

            $this->dbPool = new DatabasePool();
            $this->dbPool->create('core', $config['db']['core']['masters']['admin']);
            $this->dbPool->create('select', $config['db']['core']['masters']['select']);

            if ($this->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
                //$this->create503Response($response, $pageView);

                return;
            }

            // TODO: Create server session manager. Client account has reference to elmeent in here (&$session[$clientID])
            $this->sessionManager = new HttpSession(36000);
            $this->cachePool      = new CachePool($this->dbPool);
            $this->appSettings    = new CoreSettings($this->dbPool->get());
            $this->eventManager   = new EventManager($this->dispatcher);
            $this->accountManager = new AccountManager($this->sessionManager);

            $this->router = new WebRouter();
            $this->router->importFromFile(__DIR__ . '/Routes.php');

            $this->moduleManager  = new ModuleManager($this, __DIR__ . '/../Modules');
            $this->dispatcher     = new Dispatcher($this);
            $this->l11nManager    = new L11nManager($this->appName);

            $this->logger->info('Initializing active modules...');
            /*$modules = $this->moduleManager->getActiveModules();
            foreach ($modules as $name => $module) {
                $this->moduleManager->initModule($name);
            }*/

            $socket = new Server($this);
            $socket->create('127.0.0.1', $config['socket']['master']['port']);
            $socket->setLimit($config['socket']['master']['limit']);
        } elseif ($type === SocketType::TCP_CLIENT) {
            $socket = new Client();
            $socket->create('127.0.0.1', $config['socket']['master']['port']);
        } elseif ($type === SocketType::WEB_SOCKET) {
            $socket = new Client();
            $socket->create('127.0.0.1', $config['socket']['master']['port']);
        } else {
            throw new \InvalidArgumentException('Socket type "' . $type . '" is not supported.');
        }

        $socket->run();
    }

    /**
     * Setup general handlers for the application.
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function setupHandlers() : void
    {
//        \set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
//        \set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
//        \register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
//        \mb_internal_encoding('UTF-8');
    }
}
