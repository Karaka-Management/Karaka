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
namespace Socket;

use Model\CoreSettings;
use phpOMS\Account\AccountManager;
use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Cache\Pool as CachePool;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\L11nManager;
use phpOMS\Log\FileLogger;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\Router;
use phpOMS\Socket\Client\Client;
use phpOMS\Socket\Server\Server;
use phpOMS\Socket\SocketType;

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
     * @var SocketType
     * @since 1.0.0
     */
    private $type;

    /**
     * Constructor.
     *
     * @param array  $config Core config
     * @param string $type   Socket type
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function __construct(array $config, string $type)
    {
        set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
        mb_internal_encoding('UTF-8');

        $this->type   = $type;
        $socket       = null;
        $this->logger = FileLogger::getInstance(ROOT_PATH . '/Logs', true);

        if ($type === SocketType::TCP_SERVER) {
            $this->dbPool = new DatabasePool();
            $this->dbPool->create('core', $config['db']['core']['masters'][0]);

            // TODO: Create server session manager. Client account has reference to elmeent in here (&$session[$clientID])
            $this->cachePool      = new CachePool($this->dbPool);
            $this->appSettings    = new CoreSettings($this->dbPool->get());
            $this->eventManager   = new EventManager();
            $this->router         = new Router();
            $this->sessionManager = new HttpSession(36000);
            $this->moduleManager  = new ModuleManager($this);
            $this->l11nManager    = new L11nManager($this->logger);
            $this->accountManager = new AccountManager();
            $this->dispatcher     = new Dispatcher($this);

            $modules = $this->moduleManager->getActiveModules();
            $this->moduleManager->initModule($modules);

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
}
