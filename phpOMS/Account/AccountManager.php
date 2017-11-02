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

namespace phpOMS\Account;

use phpOMS\Auth\Auth;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Session\SessionInterface;

/**
 * Account manager class.
 * 
 * The account manager is used to manage multiple accounts. 
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class AccountManager implements \Countable
{

    /**
     * Accounts.
     *
     * @var Account[]
     * @since 1.0.0
     */
    private $accounts = [];

    /**
     * Session.
     *
     * @var SessionInterface
     * @since 1.0.0
     */
    private $session = null;

    /**
     * Authenticator.
     *
     * @var Auth
     * @since 1.0.0
     */
    private $auth = null;

    /**
     * Constructor.
     *
     * @param SessionInterface   $session    Session
     *
     * @since  1.0.0
     */
    public function __construct(SessionInterface $session)
    {
        $this->session    = $session;
        $this->auth       = new Auth($this->session);
    }

    /**
     * Get account.
     *
     * @param int $id Account id
     *
     * @return Account
     *
     * @since  1.0.0
     */
    public function get(int $id = 0) : Account
    {
        if ($id === 0) {
            $account = new Account($this->auth->authenticate());

            if (!isset($this->accounts[$account->getId()])) {
                $this->accounts[$account->getId()] = $account;
            }

            return $account;
        }

        return $this->accounts[$id] ?? new NullAccount();
    }

    /**
     * Returns the authentication manager
     *
     * @return Auth
     *
     * @since  1.0.0
     */
    public function getAuth() : Auth
    {
        return $this->auth;
    }

    /**
     * Add account.
     *
     * @param Account $account Account
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function add(Account $account) : bool
    {
        if (!isset($this->accounts[$account->getId()])) {
            $this->accounts[$account->getId()] = $account;

            return true;
        }

        return false;
    }

    /**
     * Remove account.
     *
     * @param int $id Account id
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function remove(int $id) : bool
    {
        if (isset($this->accounts[$id])) {
            unset($this->accounts[$id]);

            return true;
        }

        return false;
    }

    /**
     * Get accounts count.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function count() : int
    {
        return count($this->accounts);
    }

}
