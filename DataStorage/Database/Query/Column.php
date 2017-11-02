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

namespace phpOMS\DataStorage\Database\Query;

/**
 * Database query builder.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Column
{

    /**
     * Column name.
     *
     * @var string
     * @since 1.0.0
     */
    private $column = '';

    /**
     * Constructor.
     *
     * @param string $column Column
     *
     * @since  1.0.0
     */
    public function __construct(string $column)
    {
        $this->column = $column;
    }

    /**
     * Get column string.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getColumn() : string
    {
        return $this->column;
    }

    public function setColumn(string $column) /* : void */
    {
        $this->column = $column;
    }

}
