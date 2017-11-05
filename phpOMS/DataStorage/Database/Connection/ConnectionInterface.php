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

use phpOMS\DataStorage\Database\Query\Grammar\Grammar;
use phpOMS\DataStorage\Database\Schema\Grammar\Grammar as SchemaGrammar;

/**
 * Database connection interface.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface ConnectionInterface
{

    /**
     * Connect to database.
     *
     * Overwrites current connection if existing
     *
     * @param string[] $dbdata the basic database information for establishing a connection
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function connect(array $dbdata) /* : void */;

    /**
     * Get the database type.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getType() : string;

    /**
     * Get the database status.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatus() : int;

    /**
     * Close database connection.
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function close() /* : void */;

    /**
     * Return grammar for this connection.
     *
     * @return Grammar
     *
     * @since  1.0.0
     */
    public function getGrammar() : Grammar;

    /**
     * Return grammar for this connection.
     *
     * @return SchemaGrammar
     *
     * @since  1.0.0
     */
    public function getSchemaGrammar() : SchemaGrammar;

}
