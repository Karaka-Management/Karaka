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

namespace phpOMS\DataStorage;

use phpOMS\DataStorage\Database\Query\Builder;

/**
 * Datamapper interface.
 *
 * DB, Cache, Session
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface DataMapperInterface
{

    /**
     * Create data.
     *
     * @param mixed $obj Object reference (gets filled with insert id)
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function create($obj);

    /**
     * Update data.
     *
     * @param mixed $obj Object reference (gets filled with insert id)
     *
     * @return int Status
     *
     * @since  1.0.0
     */
    public static function update($obj) : int;

    /**
     * Delete data.
     *
     * @param mixed $obj Object to delete
     *
     * @return int Status
     *
     * @since  1.0.0
     */
    public static function delete($obj);

    /**
     * Find data.
     *
     * @param string $search Search
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function find(string $search) : array;

    /**
     * List data.
     *
     * @param Builder $query Query
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function listResults(Builder $query);

    /**
     * Populate data.
     *
     * @param array $result Result set
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function populate(array $result);

    /**
     * Populate data.
     *
     * @param array $result Result set
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function populateIterable(array $result) : array;

    /**
     * Load.
     *
     * @param array $objects Objects to load
     *
     * @return $this
     *
     * @since  1.0.0
     */
    public static function with(...$objects);

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     *
     * @return self
     *
     * @since  1.0.0
     */
    public static function get($primaryKey);

}
