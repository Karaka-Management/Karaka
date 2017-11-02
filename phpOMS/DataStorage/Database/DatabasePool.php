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

namespace phpOMS\DataStorage\Database;

use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionFactory;

/**
 * Database pool handler.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class DatabasePool
{

    /**
     * Databases.
     *
     * @var ConnectionAbstract[]
     * @since 1.0.0
     */
    private $pool = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Add database.
     *
     * @param mixed              $key Database key
     * @param ConnectionAbstract $db  Database
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function add(string $key = 'core', ConnectionAbstract $db) : bool
    {
        if (isset($this->pool[$key])) {
            return false;
        }

        $this->pool[$key] = $db;

        return true;
    }

    /**
     * Get database.
     *
     * @param mixed $key Database key
     *
     * @return ConnectionAbstract|null
     *
     * @since  1.0.0
     */
    public function get(string $key = '') /* : ?ConnectionAbstract */
    {
        if ((!empty($key) && !isset($this->pool[$key])) || empty($this->pool)) {
            return null;
        }

        if (empty($key)) {
            return reset($this->pool);
        }

        return $this->pool[$key];
    }

    /**
     * Remove database.
     *
     * @param mixed $key Database key
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function remove(string $key) : bool
    {
        if (!isset($this->pool[$key])) {
            return false;
        }

        unset($this->pool[$key]);

        return true;
    }

    /**
     * Create database.
     *
     * @param mixed $key    Database key
     * @param array $config Database config data
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function create($key, array $config) : bool
    {
        if (isset($this->pool[$key])) {
            return false;
        }

        $this->pool[$key] = ConnectionFactory::create($config);

        return true;
    }

}
