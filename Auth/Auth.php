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

namespace phpOMS\Auth;

use phpOMS\DataStorage\Session\SessionInterface;

/**
 * Auth class.
 *
 * Responsible for authenticating and initializing the connection
 *
 * @category   Framework
 * @package    phpOMS\Auth
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Auth
{
    /**
     * Session instance.
     *
     * @var SessionInterface
     * @since 1.0.0
     */
    private $session = null;

    /**
     * Constructor.
     *
     * @param SessionInterface   $session    Session
     *
     * @since  1.0.0
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Authenticates user.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function authenticate() : int
    {
        $uid = $this->session->get('UID');

        return empty($uid) ? 0 : $uid;
    }

    /**
     * Logout the given user.
     *
     * @param int $uid User ID
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function logout(int $uid = null) /* : void */
    {
        // TODO: logout other users? If admin wants to kick a user for updates etc.
        $this->session->remove('UID');
    }
}
