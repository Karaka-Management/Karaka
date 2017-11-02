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

use phpOMS\DataStorage\Database\Schema\Exception\TableException;

/**
 * Database exception factory.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class DatabaseExceptionFactory
{
    /**
     * Constructor.
     *
     * @param \PDOException $e Exception
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function createException(\PDOException $e) : string
    {
        switch ($e->getCode()) {
            case '42S02':
                return '\phpOMS\DataStorage\Database\Schema\Exception\TableException';
            default:
                return '\PDOException';
        }
    }

    /**
     * Constructor.
     *
     * @param \PDOException $e Exception
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function createExceptionMessage(\PDOException $e) : string
    {
        switch ($e->getCode()) {
            case '42S02':
                return TableException::findTable($e->getMessage());
            default:
                return $e->getMessage();
        }
    }
}
