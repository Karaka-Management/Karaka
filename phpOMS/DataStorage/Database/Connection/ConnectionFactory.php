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

namespace phpOMS\DataStorage\Database\Connection;

use phpOMS\DataStorage\Database\DatabaseType;

/**
 * Database connection factory.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ConnectionFactory
{

    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Create database connection.
     *
     * Overwrites current connection if existing
     *
     * @param string[] $dbdata the basic database information for establishing a connection
     *
     * @return ConnectionInterface
     *
     * @throws \InvalidArgumentException Throws this exception if the database is not supported.
     *
     * @since  1.0.0
     */
    public static function create(array $dbdata) : ConnectionInterface
    {
        switch ($dbdata['db']) {
            case DatabaseType::MYSQL:
                return new MysqlConnection($dbdata);
                break;
            case DatabaseType::SQLSRV:
                return new SqlServerConnection($dbdata);
                break;
            default:
                throw new \InvalidArgumentException('Database "' . $dbdata['db'] . '" is not supported.');
        }
    }
}
