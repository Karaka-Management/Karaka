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

namespace Socket\Socketclient;

use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\L11nManager;
use phpOMS\Log\FileLogger;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\SocketRouter;
use phpOMS\Socket\Client\Client;
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
     * Temp config.
     *
     * @var array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}, socket:array{master:array}}
     * @since 1.0.0
     */
    protected array $config;

    /**
     * Socket.
     *
     * @var Client
     * @since 1.0.0
     */
    protected Client $socket;

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
        $this->app          = $app;
        $this->app->appName = 'Socketclient';
        $this->config       = $config;

        $this->app->logger = FileLogger::getInstance($config['log']['file']['path'], true);

        $this->app->router = new SocketRouter();
        $this->app->router->importFromFile(__DIR__ . '/Routes.php');

        $this->app->moduleManager = new ModuleManager($this->app, __DIR__ . '/../../Modules');
        $this->app->dispatcher    = new Dispatcher($this->app);
        $this->app->l11nManager   = new L11nManager($this->app->appName);

        $this->socket = new Client($this->app);
        $this->socket->create('127.0.0.1', $config['socket']['master']['port']);
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
