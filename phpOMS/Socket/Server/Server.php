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
declare(strict_types = 1);

namespace phpOMS\Socket\Server;

use phpOMS\Socket\Client\ClientConnection;
use phpOMS\Socket\CommandManager;
use phpOMS\Socket\Packets\PacketManager;
use phpOMS\Socket\SocketAbstract;

/**
 * Server class.
 *
 * @category   Framework
 * @package    phpOMS\Socket\Server
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Server extends SocketAbstract
{

    /**
     * Socket connection limit.
     *
     * @var int
     * @since 1.0.0
     */
    private $limit = 10;

    /**
     * Client connections.
     *
     * @var array
     * @since 1.0.0
     */
    private $conn = [];

    /**
     * Packet manager.
     *
     * @var PacketManager
     * @since 1.0.0
     */
    private $packetManager = null;

    private $clientManager = null;

    private $verbose = true;

    /**
     * Socket application.
     *
     * @var \Socket\SocketApplication
     * @since 1.0.0
     */
    private $app = null;

    /**
     * Constructor.
     *
     * @param \Socket\SocketApplication $app socketApplication
     *
     * @since  1.0.0
     */
    public function __construct($app)
    {
        $this->app           = $app;
        $this->clientManager = new ClientManager();
        $this->packetManager = new PacketManager(new CommandManager(), new ClientManager());
    }

    /**
     * Has internet connection.
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function hasInternet() : bool
    {
        $connected = @fsockopen("www.google.com", 80);

        if ($connected) {
            fclose($connected);

            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $ip, int $port)
    {
        $this->app->logger->info('Creating socket...');
        parent::create($ip, $port);
        $this->app->logger->info('Binding socket...');
        socket_bind($this->sock, $this->ip, $this->port);
    }

    /**
     * Set connection limit.
     *
     * @param int $limit Connection limit
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setLimit(int $limit) /* : void */
    {
        $this->limit = $limit;
    }

    public function handshake($client, $headers)
    {
        // todo: different handshake for normal tcp connection
        return true;

        if (preg_match("/Sec-WebSocket-Version: (.*)\r\n/", $headers, $match)) {
            $version = $match[1];
        } else {
            return false;
        }

        if ($version == 13) {
            if (preg_match("/GET (.*) HTTP/", $headers, $match)) {
                $root = $match[1];
            }

            if (preg_match("/Host: (.*)\r\n/", $headers, $match)) {
                $host = $match[1];
            }

            if (preg_match("/Origin: (.*)\r\n/", $headers, $match)) {
                $origin = $match[1];
            }

            $key = '';
            if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $headers, $match)) {
                $key = $match[1];
            }

            $acceptKey = $key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
            $acceptKey = base64_encode(sha1($acceptKey, true));
            $upgrade   = "HTTP/1.1 101 Switching Protocols\r\n" .
                "Upgrade: websocket\r\n" .
                "Connection: Upgrade\r\n" .
                "Sec-WebSocket-Accept: $acceptKey" .
                "\r\n\r\n";
            socket_write($client->getSocket(), $upgrade);
            $client->setHandshake(true);

            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->app->logger->info('Start listening...');
        socket_listen($this->sock);
        socket_set_nonblock($this->sock);
        $this->conn[] = $this->sock;

        $this->app->logger->info('Start running...');
        while ($this->run) {
            $read = $this->conn;

            $write  = null;
            $except = null;

            if (socket_select($read, $write, $except, 0) < 1) {
                // error
                // socket_last_error();
                // socket_strerror(socket_last_error());
                // socket_clear_error();
            }

            foreach ($read as $key => $socket) {
                if ($this->sock === $socket) {
                    $newc = socket_accept($this->sock);
                    $this->connectClient($newc);
                } else {
                    $client = $this->clientManager->getBySocket($socket);
                    $data   = socket_read($socket, 1024);

                    if (!$client->getHandshake()) {
                        $this->app->logger->debug('Doing handshake...');
                        if ($this->handshake($client, $data)) {
                            $this->app->logger->debug('Handshake succeeded.');
                        } else {
                            $this->app->logger->debug('Handshake failed.');
                            $this->disconnectClient($client);
                        }
                    } else {
                        $this->packetManager->handle($this->unmask($data), $client);
                    }
                }
            }
        }

        $this->close();
    }

    public function connectClient($socket)
    {
        $this->app->logger->debug('Connecting client...');
        $this->clientManager->add($client = new ClientConnection(uniqid(), $socket));
        $this->conn[$client->getId()] = $socket;
        $this->app->logger->debug('Connected client.');
    }

    public function disconnectClient($client)
    {
        $this->app->logger->debug('Disconnecting client...');
        $client->setConnected(false);
        $client->setHandshake(false);
        socket_shutdown($client->getSocket(), 2);
        socket_close($client->getSocket());

        if (isset($this->conn[$client->getId()])) {
            unset($this->conn[$client->getId()]);
        }

        $this->clientManager->remove($client->getId());
        $this->app->logger->debug('Disconnected client.');
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        parent::close();
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    private function unmask($payload)
    {
        $length = ord($payload[1]) & 127;
        if ($length == 126) {
            $masks = substr($payload, 4, 4);
            $data  = substr($payload, 8);
        } elseif ($length == 127) {
            $masks = substr($payload, 10, 4);
            $data  = substr($payload, 14);
        } else {
            $masks = substr($payload, 2, 4);
            $data  = substr($payload, 6);
        }
        $text = '';
        for ($i = 0; $i < strlen($data); ++$i) {
            $text .= $data[$i] ^ $masks[$i % 4];
        }

        return $text;
    }
}
