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

namespace phpOMS\DataStorage\Database\Schema;

use phpOMS\DataStorage\Database\BuilderAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Query;

/**
 * Database query builder.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Builder extends BuilderAbstract
{
    public $table = [];

    public $drop = [];

    /**
     * Constructor.
     *
     * @param ConnectionAbstract $connection Database connection
     *
     * @since  1.0.0
     */
    public function __construct(ConnectionAbstract $connection)
    {
        $this->connection = $connection;
        $this->grammar    = $connection->getSchemaGrammar();
    }

    public function select(...$table) /* : void */
    {
        $this->type = QueryType::SELECT;
        $this->table += $table;
        $this->table = array_unique($this->table);
    }

    public function drop(...$table)
    {
        $this->type = QueryType::DROP;
        $this->drop += $table;
        $this->drop = array_unique($this->drop);
    }

    public function create(string $table)
    {

    }

    public function alter(array $column)
    {

    }

    /**
     * Parsing to string.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function toSql() : string
    {
        return $this->grammar->compileQuery($this);
    }
}
