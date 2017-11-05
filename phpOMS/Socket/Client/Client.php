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

namespace phpOMS\Socket\Client;

use phpOMS\Socket\CommandManager;
use phpOMS\Socket\SocketAbstract;

/**
 * Client socket class.
 *
 * @category   Framework
 * @package    phpOMS\Socket\Client
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Client extends SocketAbstract
{
    private $commands;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->commands = new CommandManager();

        /** @noinspection PhpUnusedParameterInspection */
        $this->commands->attach('disconnect', function ($conn, $para) {
            $this->disconnect();
        }, $this);
    }

    /**
     * Disconnect from server.
     *
     * @since  1.0.0
     */
    private function disconnect()
    {
        $this->run = false;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $ip, int $port)
    {
        parent::create($ip, $port);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        socket_connect($this->sock, $this->ip, $this->port);
        $i = 0;

        while ($this->run) {
            try {
                $i++;
                $msg = 'disconnect';
                socket_write($this->sock, $msg, strlen($msg));

                $read = [$this->sock];

                //if (socket_select($read, $write = null, $except = null, 0) < 1) {
                // error
                // socket_last_error();
                // socket_strerror(socket_last_error());
                //}

                if (count($read) > 0) {
                    $data = socket_read($this->sock, 1024);

                    /* Server no data */
                    if ($data === false) {
                        continue;
                    }

                    /* Normalize */
                    $data = trim($data);

                    if (!empty($data)) {
                        $data = explode(' ', $data);
                        $this->commands->trigger($data[0], 0, $data);
                    }
                }
            } catch (\Error $e) {
                $this->run = false;
            }
        }

        $this->close();
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
}
