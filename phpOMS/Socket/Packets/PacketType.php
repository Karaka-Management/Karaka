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
 * @link       http://orange-management.com
 */
declare(strict_types = 1);

namespace phpOMS\Socket\Packets;

use phpOMS\Stdlib\Base\Enum;

/**
 * Packet type enum.
 *
 * @category   Framework
 * @package    phpOMS\Socket\Packets
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class PacketType extends Enum
{
    /* public */ const CONNECT = 0; /* Client connection (server/sender) */
    /* public */ const DISCONNECT = 1; /* Client disconnection (server/sender) */
    /* public */ const KICK = 2; /* Kick (server/client/sender) */
    /* public */ const PING = 3; /* Ping (server/sender) */
    /* public */ const HELP = 4; /* Help (server/sender) */
    /* public */ const RESTART = 5; /* Restart server (server/all clients/client) */
    /* public */ const MSG = 6; /* Message (server/sender/client/all clients?) */
    /* public */ const LOGIN = 7; /* Login (server/sender) */
    /* public */ const LOGOUT = 8; /* Logout (server/sender) */
    /* public */ const ACCMODIFY = 9; /* Account modification (server/sender (admin)/user) */
    /* public */ const MODULE = 999999999; /* Module packet ??? */
}
