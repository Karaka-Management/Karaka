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

namespace phpOMS\DataStorage\Database;

use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;

/**
 * Database query builder.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class BuilderAbstract
{
    /**
     * Grammar.
     *
     * @var GrammarAbstract
     * @since 1.0.0
     */
    protected $grammar = null;

    /**
     * Database connection.
     *
     * @var ConnectionAbstract
     * @since 1.0.0
     */
    protected $connection = null;

    /**
     * Query type.
     *
     * @var int
     * @since 1.0.0
     */
    protected $type = null;

    /**
     * Prefix.
     *
     * @var string
     * @since 1.0.0
     */
    protected $prefix = '';

    /**
     * Set prefix.
     *
     * @param string $prefix Prefix
     *
     * @return BuilderAbstract
     *
     * @since  1.0.0
     */
    public function prefix(string $prefix) : BuilderAbstract
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix.
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
     * Get query type.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getType() : int
    {
        return $this->type;
    }
}
