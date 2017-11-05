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
use phpOMS\Socket\Client\NullClientConnection;

class ClientManager
{
    private $clients = [];

    public function add(ClientConnection $client)
    {
        $this->clients[$client->getId()] = $client;
    }

    public function get($id)
    {
        return $this->clients[$id] ?? new NullClientConnection(uniqid(), null);
    }

    public function getBySocket($socket)
    {
        foreach ($this->clients as $client) {
            if ($client->getSocket() === $socket) {
                return $client;
            }
        }

        return new NullClientConnection(uniqid(), null);
    }

    public function remove($id)
    {
        if (isset($this->clients[$id])) {
            unset($this->clients[$id]);

            return true;
        }

        return false;
    }
}
