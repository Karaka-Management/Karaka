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

namespace phpOMS\Message\Mail;

/**
 * Imap mail class.
 *
 * @category   Framework
 * @package    phpOMS\Message\Mail
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Nntp extends EmailAbstract
{
    /**
     * Construct
     *
     * @param string $host Host
     * @param int $port Host port
     * @param int $timeout Timeout
     * @param bool $ssl Use ssl
     *
     * @since  1.0.0
     */
    public function __construct(string $host = 'localhost', int $port = 25, int $timeout = 30, bool $ssl = false)
    {
        parent::__construct($host, $port, $timeout, $ssl);
    }

    /**
     * Connect to server
     *
     * @param string $user Username
     * @param string $pass Password
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public function connect(string $user = '', string $pass = '') /* : void */
    {
        $this->mailbox = '{' . $this->host . ':' . $this->port . '/nntp' . '}';
        parent::connect();
    }
}
