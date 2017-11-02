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

namespace phpOMS\Socket;

use phpOMS\Stdlib\Base\Enum;

/**
 * Socket type enum.
 *
 * @category   Framework
 * @package    phpOMS\Socket
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class SocketType extends Enum
{
    /* public */ const TCP_SERVER = 'server';
    /* public */ const TCP_CLIENT = 'client';
    /* public */ const WEB_SOCKET = 'ws';
}
