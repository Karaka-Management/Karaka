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

namespace phpOMS\Socket;

/**
 * Socket class.
 *
 * @category   Socket
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface SocketInterface
{

    /**
     * Create the socket.
     *
     * @param string $ip   IP address
     * @param int    $port Port
     *
     * @since    1.0.0
     */
    public function create(string $ip, int $port);

    /**
     * Close socket.
     *
     * @since    1.0.0
     */
    public function close();

    /**
     * Run socket.
     *
     * @since    1.0.0
     */
    public function run();
}
