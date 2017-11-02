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
use phpOMS\DataStorage\Database\Query\Builder;

/**
 * Datamapper for databases.
 *
 * DB, Cache, Session
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class DataMapperBaseAbstract
{
    /**
     * Database connection.
     *
     * @var ConnectionAbstract
     * @since 1.0.0
     */
    protected static $db = null;

    /**
     * Overwriting extended values.
     *
     * @var bool
     * @since 1.0.0
     */
    protected static $overwrite = true;

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $primaryField = '';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $createdAt = '';

    /**
     * Language
     *
     * @var string
     * @since 1.0.0
     */
    protected static $language_field = '';

    /**
     * Columns.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $columns = [];

    /**
     * Relations.
     *
     * Relation is defined in a relation table
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $hasMany = [];

    /**
     * Relations.
     *
     * Relation is defined in the model
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $hasOne = [];

    /**
     * Relations.
     *
     * Relation is defined in current mapper
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $ownsOne = [];

    /**
     * Relations.
     *
     * Relation is defined in current mapper
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $belongsTo = [];

    /**
     * Table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $table = '';

    /**
     * Fields to load.
     *
     * @var array[]
     * @since 1.0.0
     */
    protected static $fields = [];

    /**
     * Initialized objects for cross reference to reduce initialization costs
     *
     * @var array[]
     * @since 1.0.0
     */
    protected static $initObjects = [];

    /**
     * Highest mapper to know when to clear initialized objects
     *
     * @var DataMapperAbstract
     * @since 1.0.0
     */
    protected static $parentMapper = null;

    /**
     * Extended value collection.
     *
     * @var array
     * @since 1.0.0
     */
    protected static $collection = [
        'primaryField' => [],
        'createdAt'    => [],
        'columns'      => [],
        'hasMany'      => [],
        'hasOne'       => [],
        'ownsOne'      => [],
        'table'        => [],
    ];

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
     * Clone.
     * 
     * @return void
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __clone()
    {
    }

    /**
     * Set database connection.
     *
     * @param ConnectionAbstract $con Database connection
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public static function setConnection(ConnectionAbstract $con) /* : void */
    {
        self::$db = $con;
    }

    /**
     * Get primary field.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function getPrimaryField() : string
    {
        return static::$primaryField;
    }

    /**
     * Get main table.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function getTable() : string
    {
        return static::$table;
    }

    /**
     * Collect values from extension.
     *
     * @param mixed $class Current extended mapper
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function extend($class) /* : void */
    {
        /* todo: have to implement this in the queries, so far not used */
        self::$collection['primaryField'][] = $class::$primaryField;
        self::$collection['createdAt'][]    = $class::$createdAt;
        self::$collection['columns'][]      = $class::$columns;
        self::$collection['hasMany'][]      = $class::$hasMany;
        self::$collection['hasOne'][]       = $class::$hasOne;
        self::$collection['ownsOne'][]      = $class::$ownsOne;
        self::$collection['table'][]        = $class::$table;

        if (($parent = get_parent_class($class)) !== false && !$class::$overwrite) {
            self::extend($parent);
        }
    }

    /**
     * Resets all loaded mapper variables.
     *
     * This is used after one action is performed otherwise other models would use wrong settings.
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function clear() /* : void */
    {
        self::$overwrite    = true;
        self::$primaryField = '';
        self::$createdAt    = '';
        self::$columns      = [];
        self::$hasMany      = [];
        self::$hasOne       = [];
        self::$ownsOne      = [];
        self::$table        = '';
        self::$fields       = [];
        self::$collection   = [
            'primaryField' => [],
            'createdAt'    => [],
            'columns'      => [],
            'hasOne'       => [],
            'ownsMany'     => [],
            'ownsOne'      => [],
            'table'        => [],
        ];

        // clear parent and objects
        if (static::class === self::$parentMapper) {
            self::$initObjects = [];
            self::$parentMapper = null;
        }
    }

    /**
     * Get created at column
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function getCreatedAt() : string
    {
        return static::$createdAt;
    }

    /**
     * Get id of object
     *
     * @param Object           $obj             Model to create
     * @param \ReflectionClass $reflectionClass Reflection class
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function getObjectId($obj, \ReflectionClass $reflectionClass = null) 
    {
        $reflectionClass = $reflectionClass ?? new \ReflectionClass(get_class($obj));
        $reflectionProperty = $reflectionClass->getProperty(static::$columns[static::$primaryField]['internal']);

        if (!($isPublic = $reflectionProperty->isPublic())) {
            $reflectionProperty->setAccessible(true);
        }

        $objectId = $reflectionProperty->getValue($obj);

        if (!$isPublic) {
            $reflectionProperty->setAccessible(false);
        }

        return $objectId;
    }

    /**
     * Set id to model
     *
     * @param \ReflectionClass $reflectionClass Reflection class
     * @param Object           $obj             Object to create
     * @param mixed            $objId           Id to set
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function setObjectId(\ReflectionClass $reflectionClass, $obj, $objId) /* : void */
    {
        $reflectionProperty = $reflectionClass->getProperty(static::$columns[static::$primaryField]['internal']);

        if (!($isPublic = $reflectionProperty->isPublic())) {
            $reflectionProperty->setAccessible(true);
        }

        settype($objId, static::$columns[static::$primaryField]['type']);
        $reflectionProperty->setValue($obj, $objId);

        if (!$isPublic) {
            $reflectionProperty->setAccessible(false);
        }
    }

    /**
     * Parse value
     *
     * @param string $type  Value type
     * @param mixed  $value Value to parse
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function parseValue(string $type, $value)
    {
        if (is_null($value)) {
            return null;
        } elseif ($type === 'DateTime') {
            return $value->format('Y-m-d H:i:s');
        } elseif ($type === 'Json' || $type === 'jsonSerializable') {
            return json_encode($value);
        } elseif ($type === 'Serializable') {
            return $value->serialize();
        } elseif ($value instanceof \JsonSerializable) {
            return json_encode($value->jsonSerialize());
        } elseif (is_object($value) && method_exists($value, 'getId')) {
            return $value->getId();
        } elseif ($type === 'int') {
            return (int) $value;
        } elseif ($type === 'string') {
            return (string) $value;
        } elseif ($type === 'float') {
            return (float) $value;
        } elseif ($type === 'bool') {
            return (bool) $value;
        }

        return $value;
    }

    /**
     * Get mapper specific builder
     *
     * @param Builder $query Query to fill
     *
     * @return Builder
     *
     * @since  1.0.0
     */
    public static function getQuery(Builder $query = null) : Builder
    {
        $query = $query ?? new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())
            ->select('*')
            ->from(static::$table);

        return $query;
    }

    /**
     * Define the highest mapper of this request
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function setUpParentMapper() /* : void */
    {
        self::$parentMapper = static::class;
    }

    private static function getColumnByMember(string $name) : string
    {
        foreach (static::$columns as $cName => $column) {
            if ($column['internal'] === $name) {
                return $cName;
            }
        }

        throw \Exception();
    }
}
