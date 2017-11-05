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

use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\Query\Grammar\Grammar;
use phpOMS\DataStorage\Database\Schema\Grammar\Grammar as SchemaGrammar;

/**
 * Database handler.
 *
 * Handles the database connection.
 * Implementing wrapper functions for multiple databases is planned (far away).
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class ConnectionAbstract implements ConnectionInterface
{

    /**
     * Connection object.
     *
     * This can be used externally to define queries and execute them.
     *
     * @var \PDO
     * @since 1.0.0
     */
    public $con = null;

    /**
     * Database prefix.
     *
     * The database prefix name for unique table names
     *
     * @var string
     * @since 1.0.0
     */
    public $prefix = '';

    /**
     * Database data.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $dbdata = null;

    /**
     * Database type.
     *
     * @var string
     * @since 1.0.0
     */
    protected $type = 'undefined';

    /**
     * Database status.
     *
     * @var int
     * @since 1.0.0
     */
    protected $status = DatabaseStatus::CLOSED;

    /**
     * Database grammar.
     *
     * @var Grammar
     * @since 1.0.0
     */
    protected $grammar = null;

    /**
     * Database grammar.
     *
     * @var SchemaGrammar
     * @since 1.0.0
     */
    protected $schemaGrammar = null;

    /**
     * {@inheritdoc}
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * Get database name.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getDatabase() : string
    {
        return $this->dbdata['database'] ?? '';
    }

    /**
     * Get database host.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getHost() : string
    {
        return $this->dbdata['host'] ?? '';
    }

    /**
     * Get database port.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getPort() : int
    {
        return (int) $this->dbdata['port'] ?? 0;
    }

    /**
     * Get table prefix.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getPrefix() : string
    {
        return $this->prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function getGrammar() : Grammar
    {
        if (!isset($this->grammar)) {
            $this->grammar = new Grammar();
        }

        return $this->grammar;
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaGrammar() : SchemaGrammar
    {
        if (!isset($this->schemaGrammar)) {
            $this->schemaGrammar = new SchemaGrammar();
        }

        return $this->schemaGrammar;
    }

    /**
     * Object destructor.
     *
     * Sets the database connection to null
     *
     * @since  1.0.0
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * {@inheritdoc}
     */
    public function close() /* : void */
    {
        $this->con    = null;
        $this->status = DatabaseStatus::CLOSED;
    }

}
