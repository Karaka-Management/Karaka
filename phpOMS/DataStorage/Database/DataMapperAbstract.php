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
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\DataMapperInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\DataStorage\Database\Exception\InvalidMapperException;

/**
 * Datamapper for databases.
 *
 * DB, Cache, Session
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class DataMapperAbstract implements DataMapperInterface
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
     * @var string
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
     * Load.
     *
     * @param array $objects Objects to load
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function with(...$objects) /* : void */
    {
        // todo: how to handle with of parent objects/extends/relations

        self::$fields = $objects;
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
     * Find data.
     *
     * @param string $search Search for
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function find(string $search) : array
    {
        self::extend(__CLASS__);

        $query = static::getQuery();

        foreach (static::$columns as $col) {
            if (isset($col['autocomplete']) && $col['autocomplete']) {
                $query->where(static::$table . '.' . $col['name'], 'LIKE', '%' . $search . '%', 'OR');
            }
        }
        
        return static::getAllByQuery($query);
    }

    /**
     * Create object in db.
     *
     * @param mixed $obj       Object reference (gets filled with insert id)
     * @param int   $relations Create all relations as well
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function create($obj, int $relations = RelationType::ALL)
    {
        self::extend(__CLASS__);

        if ($obj === null ||
            (strpos($className = get_class($obj), '\Null') !== false && is_object($obj))
        ) {
            return null;
        }

        $reflectionClass = new \ReflectionClass($className);
        $objId           = self::createModel($obj, $reflectionClass);
        self::setObjectId($reflectionClass, $obj, $objId);

        if ($relations === RelationType::ALL) {
            self::createHasMany($reflectionClass, $obj, $objId);
        }

        return $objId;
    }

    /**
     * Create object in db.
     *
     * @param array $obj       Object reference (gets filled with insert id)
     * @param int   $relations Create all relations as well
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function createArray(array &$obj, int $relations = RelationType::ALL)
    {
        self::extend(__CLASS__);

        $objId = self::createModelArray($obj);
        settype($objId, static::$columns[static::$primaryField]['type']);
        $obj[static::$columns[static::$primaryField]['internal']] = $objId;

        if ($relations === RelationType::ALL) {
            self::createHasManyArray($obj, $objId);
        }

        return $objId;
    }

    /**
     * Create base model.
     *
     * @param Object           $obj             Model to create
     * @param \ReflectionClass $reflectionClass Reflection class
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function createModel($obj, \ReflectionClass $reflectionClass)
    {
        $query = new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())->into(static::$table);

        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            if (isset(static::$hasMany[$propertyName]) || isset(static::$hasOne[$propertyName])) {
                continue;
            }

            if (!($isPublic = $property->isPublic())) {
                $property->setAccessible(true);
            }

            foreach (static::$columns as $key => $column) {
                if (isset(static::$ownsOne[$propertyName]) && $column['internal'] === $propertyName) {
                    $id    = self::createOwnsOne($propertyName, $property->getValue($obj));
                    $value = self::parseValue($column['type'], $id);

                    $query->insert($column['name'])->value($value, $column['type']);
                    break;
                } elseif (isset(static::$belongsTo[$propertyName]) && $column['internal'] === $propertyName) {
                    $id    = self::createBelongsTo($propertyName, $property->getValue($obj));
                    $value = self::parseValue($column['type'], $id);

                    $query->insert($column['name'])->value($value, $column['type']);
                    break;
                } elseif ($column['internal'] === $propertyName && $column['type'] !== static::$primaryField) {
                    $value = self::parseValue($column['type'], $property->getValue($obj));

                    $query->insert($column['name'])->value($value, $column['type']);
                    break;
                }
            }

            if (!($isPublic)) {
                $property->setAccessible(false);
            }
        }

        self::$db->con->prepare($query->toSql())->execute();

        return self::$db->con->lastInsertId();
    }

    /**
     * Create base model.
     *
     * @param array $obj Model to create
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function createModelArray($obj)
    {
        $query = new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())->into(static::$table);

        foreach ($obj as $propertyName => &$property) {
            if (isset(static::$hasMany[$propertyName]) || isset(static::$hasOne[$propertyName])) {
                continue;
            }

            foreach (static::$columns as $key => $column) {
                if (isset(static::$ownsOne[$propertyName]) && $column['internal'] === $propertyName) {
                    $id    = self::createOwnsOneArray($propertyName, $property);
                    $value = self::parseValue($column['type'], $id);

                    $query->insert($column['name'])->value($value, $column['type']);
                    break;
                } elseif (isset(static::$belongsTo[$propertyName]) && $column['internal'] === $propertyName) {
                    $id    = self::createBelongsToArray($propertyName, $property);
                    $value = self::parseValue($column['type'], $id);

                    $query->insert($column['name'])->value($value, $column['type']);
                    break;
                } elseif ($column['internal'] === $propertyName && $column['type'] !== static::$primaryField) {
                    $value = self::parseValue($column['type'], $property);

                    $query->insert($column['name'])->value($value, $column['type']);
                    break;
                }
            }
        }

        self::$db->con->prepare($query->toSql())->execute();

        return self::$db->con->lastInsertId();
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
        $reflectionClass    = $reflectionClass ?? new \ReflectionClass($obj);
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
     * Create has many
     *
     * @param \ReflectionClass $reflectionClass Reflection class
     * @param Object           $obj             Object to create
     * @param mixed            $objId           Id to set
     *
     * @return void
     *
     * @throws InvalidMapperException
     *
     * @since  1.0.0
     */
    private static function createHasMany(\ReflectionClass $reflectionClass, $obj, $objId) /* : void */
    {
        foreach (static::$hasMany as $propertyName => $rel) {
            $property = $reflectionClass->getProperty($propertyName);

            if (!($isPublic = $property->isPublic())) {
                $property->setAccessible(true);
            }

            $values = $property->getValue($obj);

            if (!($isPublic)) {
                $property->setAccessible(false);
            }

            if (!isset(static::$hasMany[$propertyName]['mapper'])) {
                throw new InvalidMapperException();
            }

            /** @var string $mapper */
            $mapper             = static::$hasMany[$propertyName]['mapper'];
            $objsIds            = [];
            $relReflectionClass = null;

            foreach ($values as $key => &$value) {
                if (!is_object($value)) {
                    // Is scalar => already in database
                    $objsIds[$key] = $value;

                    continue;
                }

                if (!isset($relReflectionClass)) {
                    $relReflectionClass = new \ReflectionClass($value);
                }

                $primaryKey = $mapper::getObjectId($value, $relReflectionClass);

                // already in db
                if (!empty($primaryKey)) {
                    $objsIds[$key] = $value;

                    continue;
                }

                // Setting relation value (id) for relation (since the relation is not stored in an extra relation table)
                /** @var string $table */
                /** @var array $columns */
                if (static::$hasMany[$propertyName]['table'] === static::$hasMany[$propertyName]['mapper']::$table) {
                    $relProperty = $relReflectionClass->getProperty($mapper::$columns[static::$hasMany[$propertyName]['dst']]['internal']);

                    if (!$isPublic) {
                        $relProperty->setAccessible(true);
                    }

                    $relProperty->setValue($value, $objId);

                    if (!($isPublic)) {
                        $relProperty->setAccessible(false);
                    }
                }

                $objsIds[$key] = $mapper::create($value);
            }

            self::createRelationTable($propertyName, $objsIds, $objId);
        }
    }

    /**
     * Create has many
     *
     * @param array           $obj             Object to create
     * @param mixed            $objId           Id to set
     *
     * @return void
     *
     * @throws InvalidMapperException
     *
     * @since  1.0.0
     */
    private static function createHasManyArray(array &$obj, $objId) /* : void */
    {
        foreach (static::$hasMany as $propertyName => $rel) {
            $values = $obj[$propertyName];

            if (!isset(static::$hasMany[$propertyName]['mapper'])) {
                throw new InvalidMapperException();
            }

            /** @var string $mapper */
            $mapper             = static::$hasMany[$propertyName]['mapper'];
            $objsIds            = [];

            foreach ($values as $key => &$value) {
                if (!is_object($value)) {
                    // Is scalar => already in database
                    $objsIds[$key] = $value;

                    continue;
                }

                $primaryKey = $obj[static::$columns[static::$primaryField]['internal']];

                // already in db
                if (!empty($primaryKey)) {
                    $objsIds[$key] = $value;

                    continue;
                }

                // Setting relation value (id) for relation (since the relation is not stored in an extra relation table)
                /** @var string $table */
                /** @var array $columns */
                if (static::$hasMany[$propertyName]['table'] === static::$hasMany[$propertyName]['mapper']::$table) {
                    $value[$mapper::$columns[static::$hasMany[$propertyName]['dst']]['internal']] = $objId;
                }

                $objsIds[$key] = $mapper::createArray($value);
            }

            self::createRelationTable($propertyName, $objsIds, $objId);
        }
    }

    private static function createHasOne(\ReflectionClass $reflectionClass, $obj)
    {
        throw new \Exception();

        foreach (static::$hasOne as $propertyName => $rel) {

        }
    }

    /**
     * Create owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param Object $obj          Object to create
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function createOwnsOne(string $propertyName, $obj)
    {
        if (is_object($obj)) {
            $mapper     = static::$ownsOne[$propertyName]['mapper'];
            $primaryKey = $mapper::getObjectId($obj);

            if (empty($primaryKey)) {
                return $mapper::create($obj);
            }

            return $primaryKey;
        }

        return $obj;
    }

    /**
     * Create owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param array $obj          Object to create
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function createOwnsOneArray(string $propertyName, array &$obj)
    {
        if (is_array($obj)) {
            $mapper     = static::$ownsOne[$propertyName]['mapper'];
            $primaryKey = $obj[static::$columns[static::$primaryField]['internal']];

            if (empty($primaryKey)) {
                return $mapper::createArray($obj);
            }

            return $primaryKey;
        }

        return $obj;
    }

    /**
     * Create owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param Object $obj          Object to create
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function createBelongsTo(string $propertyName, $obj)
    {
        if (is_object($obj)) {
            /** @var string $mapper */
            $mapper     = static::$belongsTo[$propertyName]['mapper'];
            $primaryKey = $mapper::getObjectId($obj);

            if (empty($primaryKey)) {
                return $mapper::create($obj);
            }

            return $primaryKey;
        }

        return $obj;
    }

    /**
     * Create owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param array $obj          Object to create
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function createBelongsToArray(string $propertyName, array $obj)
    {
        if (is_array($obj)) {
            /** @var string $mapper */
            $mapper     = static::$belongsTo[$propertyName]['mapper'];
            $primaryKey = $obj[static::$columns[static::$primaryField]['internal']];

            if (empty($primaryKey)) {
                return $mapper::createArray($obj);
            }

            return $primaryKey;
        }

        return $obj;
    }

    /**
     * Create relation table entry
     *
     * In case of a many to many relation the relation has to be stored in a relation table
     *
     * @param string $propertyName Property name to initialize
     * @param array  $objsIds      Object ids to insert
     * @param mixed  $objId        Model to reference
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function createRelationTable(string $propertyName, array $objsIds, $objId)
    {
        /** @var string $table */
        if (
            !empty($objsIds)
            && static::$hasMany[$propertyName]['table'] !== static::$table
            && static::$hasMany[$propertyName]['table'] !== static::$hasMany[$propertyName]['mapper']::$table
        ) {
            $relQuery = new Builder(self::$db);
            $relQuery->prefix(self::$db->getPrefix())
                ->into(static::$hasMany[$propertyName]['table'])
                ->insert(static::$hasMany[$propertyName]['src'], static::$hasMany[$propertyName]['dst']);

            foreach ($objsIds as $key => $src) {
                $relQuery->values($src, $objId);
            }

            self::$db->con->prepare($relQuery->toSql())->execute();
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
        // todo: checking for string === string and is_* is slow. maybe only check type or only string
        if (is_null($value)) {
            return null;
        } elseif ($type === 'DateTime' || $value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        } elseif ($type === 'Json' || $type === 'jsonSerializable' || is_array($value)) {
            return json_encode($value);
        } elseif ($type === 'Serializable') {
            return $value->serialize();
        } elseif ($value instanceof \JsonSerializable) {
            return json_encode($value->jsonSerialize());
        } elseif (is_object($value) && method_exists($value, 'getId')) {
            return $value->getId();
        } elseif ($type === 'int' || is_int($value)) {
            return (int) $value;
        } elseif ($type === 'string' || is_string($value)) {
            return (string) $value;
        } elseif ($type === 'float' || is_float($value)) {
            return (float) $value;
        } elseif ($type === 'bool' || is_bool($value)) {
            return (bool) $value;
        }

        return $value;
    }

    /**
     * Update has many
     *
     * @param \ReflectionClass $reflectionClass Reflection class
     * @param Object           $obj             Object to create
     * @param mixed            $objId           Id to set
     *
     * @return void
     *
     * @throws InvalidMapperException
     *
     * @since  1.0.0
     */
    private static function updateHasMany(\ReflectionClass $reflectionClass, $obj, $objId) /* : void */
    {
        $objsIds = [];

        foreach (static::$hasMany as $propertyName => $rel) {
            $property = $reflectionClass->getProperty($propertyName);

            if (!($isPublic = $property->isPublic())) {
                $property->setAccessible(true);
            }

            $values = $property->getValue($obj);

            if (!($isPublic)) {
                $property->setAccessible(false);
            }

            if (!isset(static::$hasMany[$propertyName]['mapper'])) {
                throw new InvalidMapperException();
            }

            /** @var string $mapper */
            $mapper             = static::$hasMany[$propertyName]['mapper'];
            $relReflectionClass = null;
            $objsIds[$propertyName] = [];

            foreach ($values as $key => &$value) {
                if (!is_object($value)) {
                    // Is scalar => already in database
                    $objsIds[$propertyName][$key] = $value;

                    continue;
                } 
                
                if (!isset($relReflectionClass)) {
                    $relReflectionClass = new \ReflectionClass($value);
                }

                $primaryKey = $mapper::getObjectId($value, $relReflectionClass);

                // already in db
                if (!empty($primaryKey)) {
                    $mapper::update($value);

                    $objsIds[$propertyName][$key] = $value;

                    continue;
                }

                // create if not existing
                /** @var string $table */
                /** @var array $columns */
                if (static::$hasMany[$propertyName]['table'] === static::$hasMany[$propertyName]['mapper']::$table) {
                    $relProperty = $relReflectionClass->getProperty($mapper::$columns[static::$hasMany[$propertyName]['dst']]['internal']);

                    if (!$isPublic) {
                        $relProperty->setAccessible(true);
                    }

                    $relProperty->setValue($value, $objId);

                    if (!($isPublic)) {
                        $relProperty->setAccessible(false);
                    }
                }

                $objsIds[$propertyName][$key] = $mapper::create($value);
            }
        }

        self::updateRelationTable($objsIds, $objId);
    }

    /**
     * Update relation table entry
     *
     * Deletes old entries and creates new ones
     *
     * @param string $propertyName Property name to initialize
     * @param array  $objsIds      Object ids to insert
     * @param mixed  $objId        Model to reference
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    private static function updateRelationTable(array $objsIds, $objId)
    {
        $many = self::getHasManyRaw($objId);

        foreach (static::$hasMany as $propertyName => $rel) {
            $removes = array_diff($many[$propertyName], array_keys($objsIds[$propertyName] ?? []));
            $adds    = array_diff(array_keys($objsIds[$propertyName] ?? []), $many[$propertyName]);

            if (!empty($removes)) {
                self::deleteRelationTable($propertyName, $removes, $objId);
            }

            if (!empty($adds)) {
                self::createRelationTable($propertyName, $adds, $objId);
            }
        }
    }

    /**
     * Delete relation table entry
     *
     * @param string $propertyName Property name to initialize
     * @param array  $objsIds      Object ids to insert
     * @param mixed  $objId        Model to reference
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function deleteRelationTable(string $propertyName, array $objsIds, $objId)
    {
        /** @var string $table */
        if (
            !empty($objsIds)
            && static::$hasMany[$propertyName]['table'] !== static::$table
            && static::$hasMany[$propertyName]['table'] !== static::$hasMany[$propertyName]['mapper']::$table
        ) {
            foreach ($objsIds as $key => $src) {
                $relQuery = new Builder(self::$db);
                $relQuery->prefix(self::$db->getPrefix())
                    ->delete()
                    ->from(static::$hasMany[$propertyName]['table'])
                    ->where(static::$hasMany[$propertyName]['table'] . '.' . static::$hasMany[$propertyName]['src'], '=', $src)
                    ->where(static::$hasMany[$propertyName]['table'] . '.' . static::$hasMany[$propertyName]['dst'], '=', $objId, 'and');

                self::$db->con->prepare($relQuery->toSql())->execute();
            }
        }
    }

    /**
     * Update owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param Object $obj          Object to update
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function updateOwnsOne(string $propertyName, $obj)
    {
        if (is_object($obj)) {
            /** @var string $mapper */
            $mapper = static::$ownsOne[$propertyName]['mapper'];

            // todo: delete owned one object is not recommended since it can be owned by by something else? or does owns one mean that nothing else can have a relation to this one?

            return $mapper::update($obj);
        }

        return $obj;
    }

    /**
     * Update owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param Object $obj          Object to update
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function updateBelongsTo(string $propertyName, $obj)
    {
        if (is_object($obj)) {
            /** @var string $mapper */
            $mapper = static::$belongsTo[$propertyName]['mapper'];

            return $mapper::update($obj);
        }

        return $obj;
    }

    /**
     * Update object in db.
     *
     * @param Object           $obj             Model to update
     * @param mixed           $objId             Model id
     * @param \ReflectionClass $reflectionClass Reflection class
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function updateModel($obj, $objId, \ReflectionClass $reflectionClass = null) /* : void */
    {
        $query = new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())
            ->update(static::$table)
            ->where(static::$table . '.' . static::$primaryField, '=', $objId);

        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            if (isset(static::$hasMany[$propertyName]) || isset(static::$hasOne[$propertyName])) {
                continue;
            }

            if (!($isPublic = $property->isPublic())) {
                $property->setAccessible(true);
            }

            // todo: the order of updating could be a problem. maybe looping through ownsOne and belongsTo first is better.

            foreach (static::$columns as $key => $column) {
                if (isset(static::$ownsOne[$propertyName]) && $column['internal'] === $propertyName) {
                    $id    = self::updateOwnsOne($propertyName, $property->getValue($obj));
                    $value = self::parseValue($column['type'], $id);

                    // todo: should not be done if the id didn't change. but for now don't know if id changed
                    $query->set([static::$table . '.' . $column['name'] => $value], $column['type']);
                    break;
                } elseif (isset(static::$belongsTo[$propertyName]) && $column['internal'] === $propertyName) {
                    $id    = self::updateBelongsTo($propertyName, $property->getValue($obj));
                    $value = self::parseValue($column['type'], $id);

                    // todo: should not be done if the id didn't change. but for now don't know if id changed
                    $query->set([static::$table . '.' . $column['name'] => $value], $column['type']);
                    break;
                } elseif ($column['internal'] === $propertyName && $column['type'] !== static::$primaryField) {
                     $value = self::parseValue($column['type'], $property->getValue($obj));

                    $query->set([static::$table . '.' . $column['name'] => $value], $column['type']);
                    break;
                }
            }

            if (!($isPublic)) {
                $property->setAccessible(false);
            }
        }

        self::$db->con->prepare($query->toSql())->execute();
    }

    /**
     * Update object in db.
     *
     * @param mixed $obj Object reference (gets filled with insert id)
     * @param int   $relations Create all relations as well
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function update($obj, int $relations = RelationType::ALL) : int
    {
        self::extend(__CLASS__);

        $reflectionClass = new \ReflectionClass($obj);
        $objId           = self::getObjectId($obj, $reflectionClass);
        $update          = true;

        if (empty($objId)) {
            $update = false;
            self::create($obj, $relations);
        }

        if ($relations === RelationType::ALL) {
            self::updateHasMany($reflectionClass, $obj, $objId);
        }
        
        if ($update) {
            self::updateModel($obj, $objId, $reflectionClass);
        }

        return $objId;
    }

    /**
     * Delete has many
     *
     * @param \ReflectionClass $reflectionClass Reflection class
     * @param Object           $obj             Object to create
     * @param mixed            $objId           Id to set
     * @param int   $relations Delete all relations as well
     *
     * @return void
     *
     * @throws InvalidMapperException
     *
     * @since  1.0.0
     */
    private static function deleteHasMany(\ReflectionClass $reflectionClass, $obj, $objId, int $relations) /* : void */
    {
        foreach (static::$hasMany as $propertyName => $rel) {
            $property = $reflectionClass->getProperty($propertyName);

            if (!($isPublic = $property->isPublic())) {
                $property->setAccessible(true);
            }

            $values = $property->getValue($obj);

            if (!($isPublic)) {
                $property->setAccessible(false);
            }

            if (!isset(static::$hasMany[$propertyName]['mapper'])) {
                throw new InvalidMapperException();
            }

            /** @var string $mapper */
            $mapper             = static::$hasMany[$propertyName]['mapper'];
            $objsIds            = [];
            $relReflectionClass = null;

            foreach ($values as $key => &$value) {
                if (!is_object($value)) {
                    // Is scalar => already in database
                    $objsIds[$key] = $value;

                    continue;
                } 
                
                if (!isset($relReflectionClass)) {
                    $relReflectionClass = new \ReflectionClass($value);
                }

                $primaryKey = $mapper::getObjectId($value, $relReflectionClass);

                // already in db
                if (!empty($primaryKey)) {
                    if ($relations === RelationType::ALL) {
                        $objsIds[$key] = $mapper::delete($value);
                    } else {
                        $objsIds[$key] = $primaryKey;
                    }

                    continue;
                }

                // todo: could be a problem, relation needs to be removed first?!
                
            }

            self::deleteRelationTable($propertyName, $objsIds, $objId);
        }
    }

    /**
     * Delete owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param Object $obj          Object to delete
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function deleteOwnsOne(string $propertyName, $obj)
    {
        if (is_object($obj)) {
            /** @var string $mapper */
            $mapper = static::$ownsOne[$propertyName]['mapper'];

            // todo: delete owned one object is not recommended since it can be owned by by something else? or does owns one mean that nothing else can have a relation to this one?
            return $mapper::delete($obj);
        }

        return $obj;
    }

    /**
     * Delete owns one
     *
     * The reference is stored in the main model
     *
     * @param string $propertyName Property name to initialize
     * @param Object $obj          Object to delete
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function deleteBelongsTo(string $propertyName, $obj)
    {
        if (is_object($obj)) {
            /** @var string $mapper */
            $mapper = static::$belongsTo[$propertyName]['mapper'];

            return $mapper::delete($obj);
        }

        return $obj;
    }

    /**
     * Delete object in db.
     *
     * @param Object           $obj             Model to delete
     * @param mixed           $objId             Model id
     * @param int   $relations Delete all relations as well
     * @param \ReflectionClass $reflectionClass Reflection class
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    private static function deleteModel($obj, $objId, int $relations = RelationType::REFERENCE, \ReflectionClass $reflectionClass = null) /* : void */
    {
        $query = new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())
            ->delete()
            ->from(static::$table)
            ->where(static::$table . '.' . static::$primaryField, '=', $objId);

        $properties = $reflectionClass->getProperties();

        if ($relations === RelationType::ALL) {
            foreach ($properties as $property) {
                $propertyName = $property->getName();

                if (isset(static::$hasMany[$propertyName]) || isset(static::$hasOne[$propertyName])) {
                    continue;
                }

                if (!($isPublic = $property->isPublic())) {
                    $property->setAccessible(true);
                }

                // todo: the order of deletion could be a problem. maybe looping through ownsOne and belongsTo first is better.
                // todo: support other relation types as well (belongsto, ownsone) = for better control
                
                foreach (static::$columns as $key => $column) {
                    if ($relations === RelationType::ALL && isset(static::$ownsOne[$propertyName]) && $column['internal'] === $propertyName) {
                        self::deleteOwnsOne($propertyName, $property->getValue($obj));
                        break;
                    } elseif ($relations === RelationType::ALL && isset(static::$belongsTo[$propertyName]) && $column['internal'] === $propertyName) {
                        self::deleteBelongsTo($propertyName, $property->getValue($obj));
                        break;
                    }
                }

                if (!($isPublic)) {
                    $property->setAccessible(false);
                }
            }
        }

        self::$db->con->prepare($query->toSql())->execute();
    }

    /**
     * Delete object in db.
     *
     * @param mixed $obj Object reference (gets filled with insert id)
     * @param int   $relations Create all relations as well
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function delete($obj, int $relations = RelationType::REFERENCE)
    {
        self::extend(__CLASS__);

        $reflectionClass = new \ReflectionClass($obj);
        $objId           = self::getObjectId($obj, $reflectionClass);

        if (empty($objId)) {
            return null;
        }

        if ($relations !== RelationType::NONE) {
            self::deleteHasMany($reflectionClass, $obj, $objId, $relations);
        }
        
        self::deleteModel($obj, $objId, $relations, $reflectionClass);

        return $objId;
    }

    /**
     * Populate data.
     *
     * @param array $result Result set
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function populateIterable(array $result) : array
    {
        $row = [];

        foreach ($result as $element) {
            if (isset($element[static::$primaryField])) {
                $row[$element[static::$primaryField]] = self::populate($element);
            } else {
                $row[] = self::populate($element);
            }
        }

        return $row;
    }

    /**
     * Populate data.
     *
     * @param array $result Result set
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function populateIterableArray(array $result) : array
    {
        $row = [];

        foreach ($result as $element) {
            if (isset($element[static::$primaryField])) {
                $row[$element[static::$primaryField]] = self::populateAbstractArray($element);
            } else {
                $row[] = self::populateAbstractArray($element);
            }
        }

        return $row;
    }

    /**
     * Populate data.
     *
     * @param array $result Result set
     * @param mixed $obj    Object to populate
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function populate(array $result, $obj = null)
    {
        $class = static::class;
        $class = str_replace('Mapper', '', $class);

        if (empty($result)) {
            $parts     = explode('\\', $class);
            $name      = $parts[$c = (count($parts) - 1)];
            $parts[$c] = 'Null' . $name;
            $class     = implode('\\', $parts);
        }

        if (!isset($obj)) {
            $obj = new $class();
        }

        return self::populateAbstract($result, $obj);
    }

    /**
     * Populate data.
     *
     * @param array[] $result Result set
     * @param mixed   $obj    Object to add the relations to
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function populateManyToMany(array $result, &$obj) /* : void */
    {
        // todo: maybe pass reflectionClass as optional parameter for performance increase
        $reflectionClass = new \ReflectionClass($obj);

        foreach ($result as $member => $values) {
            if (!empty($values) && $reflectionClass->hasProperty($member)) {
                /** @var string $mapper */
                $mapper             = static::$hasMany[$member]['mapper'];
                $reflectionProperty = $reflectionClass->getProperty($member);

                $values = array_diff($values, array_keys(self::$initObjects[$mapper] ?? []));
                if (empty($values)) {
                    continue;
                }

                if (!($accessible = $reflectionProperty->isPublic())) {
                    $reflectionProperty->setAccessible(true);
                }

                $objects = $mapper::get($values);
                $reflectionProperty->setValue($obj, !is_array($objects) ? [$objects->getId() => $objects] : $objects);

                if (!$accessible) {
                    $reflectionProperty->setAccessible(false);
                }
            }
        }
    }

    /**
     * Populate data.
     *
     * @param array[] $result Result set
     * @param array   $obj    Object to add the relations to
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function populateManyToManyArray(array $result, array &$obj) /* : void */
    {
        foreach ($result as $member => $values) {
            if (!empty($values)) {
                /** @var string $mapper */
                $mapper = static::$hasMany[$member]['mapper'];
                $values = array_diff($values, array_keys(self::$initObjects[$mapper] ?? []));

                if (empty($values)) {
                    continue;
                }

                $objects = $mapper::getArray($values);
                $obj[$member] = $objects;
            }
        }
    }

    /**
     * Populate data.
     *
     * @param mixed $obj Object to add the relations to
     *
     * @return void
     *
     * @todo   accept reflection class as parameter
     *
     * @since  1.0.0
     */
    public static function populateHasOne(&$obj) /* : void */
    {
        $reflectionClass = new \ReflectionClass($obj);

        foreach (static::$hasOne as $member => $one) {
            // todo: is that if necessary? performance is suffering for sure!
            if ($reflectionClass->hasProperty($member)) {
                $reflectionProperty = $reflectionClass->getProperty($member);

                if (!($accessible = $reflectionProperty->isPublic())) {
                    $reflectionProperty->setAccessible(true);
                }

                /** @var string $mapper */
                $mapper = static::$hasOne[$member]['mapper'];

                if (self::isInitialized($mapper, ($id = $reflectionProperty->getValue($obj)))) {
                    $value = self::$initObjects[$mapper][$id];
                } else {
                    $value = $mapper::get($reflectionProperty->getValue($obj));
                }
               
                $reflectionProperty->setValue($obj, $value);

                if (!$accessible) {
                    $reflectionProperty->setAccessible(false);
                }
            }
        }
    }

    /**
     * Populate data.
     *
     * @param array $obj Object to add the relations to
     *
     * @return void
     *
     * @todo   accept reflection class as parameter
     *
     * @since  1.0.0
     */
    public static function populateHasOneArray(array &$obj) /* : void */
    {
        foreach (static::$hasOne as $member => $one) {
            /** @var string $mapper */
            $mapper = static::$hasOne[$member]['mapper'];

            if (self::isInitialized($mapper, $obj['member'])) {
                $value = self::$initObjects[$mapper][$obj['member']];
            } else {
                $value = $mapper::getArray($obj[$member]);
            }

            $obj[$member] = $value;
        }
    }

    /**
     * Populate data.
     *
     * @param mixed $obj Object to add the relations to
     *
     * @return void
     *
     * @todo   accept reflection class as parameter
     *
     * @since  1.0.0
     */
    public static function populateOwnsOne(&$obj) /* : void */
    {
        $reflectionClass = new \ReflectionClass($obj);

        foreach (static::$ownsOne as $member => $one) {
            // todo: is that if necessary? performance is suffering for sure!
            if ($reflectionClass->hasProperty($member)) {
                $reflectionProperty = $reflectionClass->getProperty($member);

                if (!($accessible = $reflectionProperty->isPublic())) {
                    $reflectionProperty->setAccessible(true);
                }

                /** @var string $mapper */
                $mapper = static::$ownsOne[$member]['mapper'];

                if (self::isInitialized($mapper, ($id = $reflectionProperty->getValue($obj)))) {
                    $value = self::$initObjects[$mapper][$id];
                } else {
                    $value = $mapper::get($reflectionProperty->getValue($obj));
                }

                $reflectionProperty->setValue($obj, $value);

                if (!$accessible) {
                    $reflectionProperty->setAccessible(false);
                }
            }
        }
    }

    /**
     * Populate data.
     *
     * @param array $obj Object to add the relations to
     *
     * @return void
     *
     * @todo   accept reflection class as parameter
     *
     * @since  1.0.0
     */
    public static function populateOwnsOneArray(array &$obj) /* : void */
    {
        foreach (static::$ownsOne as $member => $one) {
            /** @var string $mapper */
            $mapper = static::$ownsOne[$member]['mapper'];

            if (self::isInitialized($mapper, $obj[$member])) {
                $value = self::$initObjects[$mapper][$obj[$member]];
            } else {
                $value = $mapper::getArray($obj[$member]);
            }

            $obj[$member] = $value;
        }
    }

    /**
     * Populate data.
     *
     * @param mixed $obj Object to add the relations to
     *
     * @return void
     *
     * @todo   accept reflection class as parameter
     *
     * @since  1.0.0
     */
    public static function populateBelongsTo(&$obj) /* : void */
    {
        $reflectionClass = new \ReflectionClass($obj);

        foreach (static::$belongsTo as $member => $one) {
            // todo: is that if necessary? performance is suffering for sure!
            if ($reflectionClass->hasProperty($member)) {
                $reflectionProperty = $reflectionClass->getProperty($member);

                if (!($accessible = $reflectionProperty->isPublic())) {
                    $reflectionProperty->setAccessible(true);
                }

                /** @var string $mapper */
                $mapper = static::$belongsTo[$member]['mapper'];

                if (self::isInitialized($mapper, ($id = $reflectionProperty->getValue($obj)))) {
                    $value = self::$initObjects[$mapper][$id];
                } else {
                    $value = $mapper::get($reflectionProperty->getValue($obj));
                }

                $reflectionProperty->setValue($obj, $value);

                if (!$accessible) {
                    $reflectionProperty->setAccessible(false);
                }
            }
        }
    }

    /**
     * Populate data.
     *
     * @param array $obj Object to add the relations to
     *
     * @return void
     *
     * @todo   accept reflection class as parameter
     *
     * @since  1.0.0
     */
    public static function populateBelongsToArray(array &$obj) /* : void */
    {
        foreach (static::$belongsTo as $member => $one) {
            /** @var string $mapper */
            $mapper = static::$belongsTo[$member]['mapper'];

            if (self::isInitialized($mapper, $obj[$member])) {
                $value = self::$initObjects[$mapper][$obj[$member]];
            } else {
                $value = $mapper::get($obj[$member]);
            }
            
            $obj[$member] = $value;
        }
    }

    /**
     * Populate data.
     *
     * @param array $result Query result set
     * @param mixed $obj    Object to populate
     *
     * @return mixed
     *
     * @throws \UnexpectedValueException
     *
     * @since  1.0.0
     */
    public static function populateAbstract(array $result, $obj)
    {
        $reflectionClass = new \ReflectionClass($obj);

        foreach ($result as $column => $value) {
            if (isset(static::$columns[$column]['internal']) /* && $reflectionClass->hasProperty(static::$columns[$column]['internal']) */) {
                $reflectionProperty = $reflectionClass->getProperty(static::$columns[$column]['internal']);

                if (!($accessible = $reflectionProperty->isPublic())) {
                    $reflectionProperty->setAccessible(true);
                }

                if (in_array(static::$columns[$column]['type'], ['string', 'int', 'float', 'bool'])) {
                    if ($value !== null || $reflectionProperty->getValue($obj) !== null) {
                        settype($value, static::$columns[$column]['type']);
                    }

                    $reflectionProperty->setValue($obj, $value);
                } elseif (static::$columns[$column]['type'] === 'DateTime') {
                    $reflectionProperty->setValue($obj, new \DateTime($value ?? ''));
                } elseif (static::$columns[$column]['type'] === 'Json') {
                    $reflectionProperty->setValue($obj, json_decode($value, true));
                } elseif (static::$columns[$column]['type'] === 'Serializable') {
                    $member = $reflectionProperty->getValue($obj);
                    $member->unserialize($value);
                } else {
                    throw new \UnexpectedValueException('Value "' . static::$columns[$column]['type'] . '" is not supported.');
                }

                if (!$accessible) {
                    $reflectionProperty->setAccessible(false);
                }
            }
        }

        return $obj;
    }

    /**
     * Populate data.
     *
     * @param array $result Query result set
     *
     * @return array
     *
     * @throws \UnexpectedValueException
     *
     * @since  1.0.0
     */
    public static function populateAbstractArray(array $result) : array
    {
        $obj = [];

        foreach ($result as $column => $value) {
            if (isset(static::$columns[$column]['internal'])) {
                if (in_array(static::$columns[$column]['type'], ['string', 'int', 'float', 'bool'])) {
                    settype($value, static::$columns[$column]['type']);
                    $obj[static::$columns[$column]['internal']] = $value;
                } elseif (static::$columns[$column]['type'] === 'DateTime') {
                    $obj[static::$columns[$column]['internal']] = new \DateTime($value ?? '');
                } elseif (static::$columns[$column]['type'] === 'Json') {
                    $obj[static::$columns[$column]['internal']] = json_decode($value, true);
                } elseif (static::$columns[$column]['type'] === 'Serializable') {
                    $obj[static::$columns[$column]['internal']] = $value;
                } else {
                    throw new \UnexpectedValueException('Value "' . static::$columns[$column]['type'] . '" is not supported.');
                }
            }
        }

        return $obj;
    }

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     * @param int   $relations  Load relations
     * @param mixed $fill       Object to fill
     *
     * @return mixed
     * 
     * @todo: implement language
     * @todo: implement depth filter for relations
     *
     * @since  1.0.0
     */
    public static function get($primaryKey, int $relations = RelationType::ALL, $fill = null)
    {
        if (!isset(self::$parentMapper)) {
            self::setUpParentMapper();
        }

        self::extend(__CLASS__);

        $primaryKey = (array) $primaryKey;
        $fill       = (array) $fill;
        $obj        = [];
        $fCount     = count($fill);
        $toFill     = null;

        foreach ($primaryKey as $key => $value) {
            if (self::isInitialized(static::class, $value)) {
                continue;
            }

            if ($fCount > 0) {
                $toFill = current($fill);
                next($fill);
            }

            $obj[$value] = self::populate(self::getRaw($value), $toFill);

            if (method_exists($obj[$value], 'initialize')) {
                $obj[$value]->initialize();
            }

            self::addInitialized(static::class, $value);
        }

        self::fillRelations($obj, $relations);
        self::clear();

        $countResulsts = count($obj);

        if ($countResulsts === 0) {
            return self::getNullModelObj();
        } elseif ($countResulsts === 1) {
            return reset($obj);
        }

        return $obj;
    }

    private static function getNullModelObj()
    {
        $class     = static::class;
        $class     = str_replace('Mapper', '', $class);
        $parts     = explode('\\', $class);
        $name      = $parts[$c = (count($parts) - 1)];
        $parts[$c] = 'Null' . $name;
        $class     = implode('\\', $parts);

        return new $class();
    }

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     * @param int   $relations  Load relations
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getArray($primaryKey, int $relations = RelationType::ALL) : array
    {
        if (!isset(self::$parentMapper)) {
            self::setUpParentMapper();
        }

        self::extend(__CLASS__);

        $primaryKey = (array) $primaryKey;
        $obj        = [];

        foreach ($primaryKey as $key => $value) {
            if (self::isInitialized(static::class, $value)) {
                continue;
            }

            $obj[$value] = self::populateAbstractArray(self::getRaw($value));

            self::addInitialized(static::class, $value);
        }

        self::fillRelationsArray($obj, $relations);
        self::clear();

        return count($obj) === 1 ? reset($obj) : $obj;
    }

    /**
     * Get object.
     *
     * @param mixed $refKey Key
     * @param string $ref  The field that defines the for
     * @param int   $relations  Load relations
     * @param mixed $fill       Object to fill
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getFor($refKey, string $ref, int $relations = RelationType::ALL, $fill = null)
    {
        if (!isset(self::$parentMapper)) {
            self::setUpParentMapper();
        }

        self::extend(__CLASS__);

        $refKey = (array) $refKey;
        $obj    = [];

        foreach ($refKey as $key => $value) {
            $toLoad = [];

            if (isset(static::$hasMany[$ref]) && static::$hasMany[$ref]['src'] !== null) {
                $toLoad = self::getHasManyPrimaryKeys($value, $ref);
            } else {
                $toLoad = self::getPrimaryKeysBy($value, self::getColumnByMember($ref));
            }

            $obj[$value] = self::get($toLoad, $relations, $fill);
        }

        $countResulsts = count($obj);

        if ($countResulsts === 0) {
            return self::getNullModelObj();
        } elseif ($countResulsts === 1) {
            return reset($obj);
        }

        return $obj;
    }

    /**
     * Get object.
     *
     * @param mixed $refKey Key
     * @param string $ref  The field that defines the for
     * @param int   $relations  Load relations
     * @param mixed $fill       Object to fill
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getForArray($refKey, string $ref, int $relations = RelationType::ALL, $fill = null)
    {
        if (!isset(self::$parentMapper)) {
            self::setUpParentMapper();
        }

        self::extend(__CLASS__);

        $refKey = (array) $refKey;
        $obj    = [];

        foreach ($refKey as $key => $value) {
            $toLoad = [];

            if (isset(static::$hasMany[$ref]) && static::$hasMany[$ref]['src'] !== null) {
                $toLoad = self::getHasManyPrimaryKeys($value, $ref);
            } else {
                $toLoad = self::getPrimaryKeysBy($value, self::getColumnByMember($ref));
            }

            $obj[$value] = self::get($toLoad, $relations, $fill);
        }

        return count($obj) === 1 ? reset($obj) : $obj;
    }

    /**
     * Get object.
     *
     * @param int $relations Load relations
     * @param string $lang Language
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getAll(int $relations = RelationType::ALL, string $lang = '') : array
    {
        if (!isset(self::$parentMapper)) {
            self::setUpParentMapper();
        }

        $obj = self::populateIterable(self::getAllRaw($lang));
        self::fillRelations($obj, $relations);
        self::clear();

        return $obj;
    }

    /**
     * Get object.
     *
     * @param int $relations Load relations
     * @param string $lang Language
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getAllArray(int $relations = RelationType::ALL, string $lang = '') : array
    {
        if (!isset(self::$parentMapper)) {
            self::setUpParentMapper();
        }

        $obj = self::populateIterableArray(self::getAllRaw($lang));
        self::fillRelationsArray($obj, $relations);
        self::clear();

        return $obj;
    }

    /**
     * Find data.
     *
     * @param Builder $query Query
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function listResults(Builder $query) : array
    {
        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        return self::populateIterable($sth->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * Get newest.
     *
     * This will fall back to the insert id if no datetime column is present.
     *
     * @param int     $limit     Newest limit
     * @param Builder $query     Pre-defined query
     * @param int     $relations Load relations
     * @param string $lang Language
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getNewest(int $limit = 1, Builder $query = null, int $relations = RelationType::ALL, string $lang = '') : array
    {
        self::extend(__CLASS__);

        $query = $query ?? new Builder(self::$db);
        $query = self::getQuery($query);
        $query->limit($limit); /* todo: limit is not working, setting this to 2 doesn't have any effect!!! */

        if (!empty(static::$createdAt)) {
            $query->orderBy(static::$table . '.' . static::$columns[static::$createdAt]['name'], 'DESC');
        } else {
            $query->orderBy(static::$table . '.' . static::$columns[static::$primaryField]['name'], 'DESC');
        }

        if (!empty(self::$language_field) && !empty($lang)) {
            $query->where(static::$table . '.' . static::$language_field, '=', $lang, 'AND');
        }

        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        $results = $sth->fetchAll(\PDO::FETCH_ASSOC);
        $obj     = self::populateIterable(is_bool($results) ? [] : $results);

        self::fillRelations($obj, $relations);
        self::clear();

        return $obj;

    }

    /**
     * Get all by custom query.
     *
     * @param Builder $query     Query
     * @param int     $relations Relations
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getAllByQuery(Builder $query, int $relations = RelationType::ALL) : array
    {
        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        $results = $sth->fetchAll(\PDO::FETCH_ASSOC);
        $results = is_bool($results) ? [] : $results;

        $obj = self::populateIterable($results);
        self::fillRelations($obj, $relations);
        self::clear();

        return $obj;
    }

    /**
     * Get random object
     *
     * @param int $amount    Amount of random models
     * @param int $relations Relations type
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getRandom(int $amount = 1, int $relations = RelationType::ALL)
    {
        $query = new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())
            ->random(static::$primaryField)
            ->from(static::$table)
            ->limit($amount);

        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        return self::get($sth->fetchAll(), $relations);
    }

    /**
     * Fill object with relations
     *
     * @param mixed $obj       Objects to fill
     * @param int   $relations Relations type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function fillRelations(array &$obj, int $relations = RelationType::ALL) /* : void */
    {
        $hasMany   = !empty(static::$hasMany);
        $hasOne    = !empty(static::$hasOne);
        $ownsOne   = !empty(static::$ownsOne);
        $belongsTo = !empty(static::$belongsTo);

        if ($relations !== RelationType::NONE && ($hasMany || $hasOne || $ownsOne || $belongsTo)) {
            foreach ($obj as $key => $value) {
                /* loading relations from relations table and populating them and then adding them to the object */
                if ($hasMany) {
                    self::populateManyToMany(self::getHasManyRaw($key, $relations), $obj[$key]);
                }

                if ($hasOne) {
                    self::populateHasOne($obj[$key]);
                }

                if ($ownsOne) {
                    self::populateOwnsOne($obj[$key]);
                }

                if ($belongsTo) {
                    self::populateBelongsTo($obj[$key]);
                }
            }
        }
    }

    /**
     * Fill object with relations
     *
     * @param mixed $obj       Objects to fill
     * @param int   $relations Relations type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function fillRelationsArray(array &$obj, int $relations = RelationType::ALL) /* : void */
    {
        $hasMany   = !empty(static::$hasMany);
        $hasOne    = !empty(static::$hasOne);
        $ownsOne   = !empty(static::$ownsOne);
        $belongsTo = !empty(static::$belongsTo);

        if ($relations !== RelationType::NONE && ($hasMany || $hasOne || $ownsOne || $belongsTo)) {
            foreach ($obj as $key => $value) {
                /* loading relations from relations table and populating them and then adding them to the object */
                if ($hasMany) {
                    self::populateManyToManyArray(self::getHasManyRaw($key, $relations), $obj[$key]);
                }

                if ($hasOne) {
                    self::populateHasOneArray($obj[$key]);
                }

                if ($ownsOne) {
                    self::populateOwnsOneArray($obj[$key]);
                }

                if ($belongsTo) {
                    self::populateBelongsToArray($obj[$key]);
                }
            }
        }
    }

    /**
     * Get object.
     *
     * @param mixed $primaryKey Key
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getRaw($primaryKey) : array
    {
        $query = self::getQuery();
        $query->where(static::$table . '.' . static::$primaryField, '=', $primaryKey);

        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        $results = $sth->fetch(\PDO::FETCH_ASSOC);

        return is_bool($results) ? [] : $results;
    }

    /**
     * Get object.
     *
     * @param mixed $refKey Key
     * @param string $ref Ref
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getPrimaryKeysBy($refKey, string $ref) : array
    {
        $query = new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())
            ->select(static::$table . '.' . static::$primaryField)
            ->from(static::$table)
            ->where(static::$table . '.' . $ref, '=', $refKey);

        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        $results = array_column($sth->fetchAll(\PDO::FETCH_NUM) ?? [], 0);

        return $results;
    }

    /**
     * Get object.
     *
     * @param mixed $refKey Key
     * @param string $ref Ref
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getHasManyPrimaryKeys($refKey, string $ref) : array
    {
        $query = new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())
            ->select(static::$hasMany[$ref]['table'] . '.' . static::$hasMany[$ref]['dst'])
            ->from(static::$hasMany[$ref]['table'])
            ->where(static::$hasMany[$ref]['table'] . '.' . static::$hasMany[$ref]['src'], '=', $refKey);

        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        $results = array_column($sth->fetchAll(\PDO::FETCH_NUM) ?? [], 0);

        return $results;
    }

    /**
     * Get all in raw output.
     *
     * @param string $lang Language
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getAllRaw(string $lang = '') : array
    {
        $query = self::getQuery();

        if (!empty(self::$language_field) && !empty($lang)) {
            $query->where(static::$table . '.' . static::$language_field, '=', $lang, 'AND');
        }

        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();

        $results = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return is_bool($results) ? [] : $results;
    }

    /**
     * Get raw by primary key
     *
     * @param mixed $primaryKey Primary key
     * @param int   $relations  Load relations
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getHasManyRaw($primaryKey, int $relations = RelationType::ALL) : array
    {
        $result = [];

        foreach (static::$hasMany as $member => $value) {
            $query = new Builder(self::$db);
            $query->prefix(self::$db->getPrefix());

            if ($relations === RelationType::ALL) {
                /** @var string $primaryField */
                $src = $value['src'] ?? $value['mapper']::$primaryField;

                $query->select($value['table'] . '.' . $src)
                    ->from($value['table'])
                    ->where($value['table'] . '.' . $value['dst'], '=', $primaryKey);
            } elseif ($relations === RelationType::NEWEST) {
                /*
                SELECT c.*, p1.*
                FROM customer c
                JOIN purchase p1 ON (c.id = p1.customer_id)
                LEFT OUTER JOIN purchase p2 ON (c.id = p2.customer_id AND
                    (p1.date < p2.date OR p1.date = p2.date AND p1.id < p2.id))
                WHERE p2.id IS NULL;
                */
                /*
                                    $query->select(static::$table . '.' . static::$primaryField, $value['table'] . '.' . $value['src'])
                                          ->from(static::$table)
                                          ->join($value['table'])
                                          ->on(static::$table . '.' . static::$primaryField, '=', $value['table'] . '.' . $value['dst'])
                                          ->leftOuterJoin($value['table'])
                                          ->on(new And('1', new And(new Or('d1', 'd2'), 'id')))
                                          ->where($value['table'] . '.' . $value['dst'], '=', 'NULL');
                                          */
            }

            $sth = self::$db->con->prepare($query->toSql());
            $sth->execute();
            $result[$member] = $sth->fetchAll(\PDO::FETCH_COLUMN);
        }

        return $result;
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
     * Get model based on request object
     *
     * @todo: change to graphql
     *
     * @param RequestAbstract $request Request object
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getByRequest(RequestAbstract $request)
    {
        if (!is_null($request->getData('id'))) {
            $result = static::get((int) $request->getData('id'));
        } elseif (!is_null($filter = ((string) $request->getData('filter')))) {
            $filter = strtolower($filter);

            if ($filter === 'all') {
                $result = static::getAll();
            } elseif ($filter === 'list') {
                $list   = $request->getData('list');
                $result = static::get(json_decode($list, true));
            } else {
                $limit = (int) ($request->getData('limit') ?? 1);
                $from  = !is_null($request->getData('from')) ? new \DateTime((string) $request->getData('from')) : null;
                $to    = !is_null($request->getData('to')) ? new \DateTime((string) $request->getData('to')) : null;

                $query = static::getQuery();
                $query->limit($limit);

                if (isset($from, $to) && !empty(static::getCreatedAt())) {
                    $query->where(static::getCreatedAt(), '>=', $from);
                    $query->where(static::getCreatedAt(), '<=', $to);
                }

                $result = static::getAllByQuery($query);
            }
        } else {
            return self::getNullModelObj();
        }

        return $result;
    }

    /**
     * Add initialized object to local cache
     *
     * @param string $mapper Mapper name
     * @param mixed $id Object id
     * @param object $obj Model to cache locally
     *
     * @return void
     *
     * @since  1.0.0
     */
    private static function addInitialized(string $mapper, $id, $obj = null) /* : void */
    {
        if (!isset(self::$initObjects[$mapper])) {
            self::$initObjects[$mapper] = [];
        }

        self::$initObjects[$mapper][$id] = $obj;
    }

    /**
     * Check if a object is initialized
     *
     * @param string $mapper Mapper name
     * @param mixed $id Object id
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private static function isInitialized($mapper, $id) : bool
    {
        return isset(self::$initObjects[$mapper]) && isset(self::$initObjects[$mapper][$id]);
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

    /**
     * Check if model exists in database
     *
     * @param mixed $id Object id
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function exists($id) : bool
    {
        $query = $query ?? new Builder(self::$db);
        $query->prefix(self::$db->getPrefix())
            ->select(static::$primaryField)
            ->from(static::$table)
            ->where(static::$primaryField, '=', $id);

        $sth = self::$db->con->prepare($query->toSql());
        $sth->execute();
    
        $results = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return count($results) === 0;
    }

    /**
     * Find database column name by member name
     *
     * @param string $name member name
     *
     * @return string
     * 
     * @throws \Exception Throws this exception if the member couldn't be found
     *
     * @since  1.0.0
     */
    private static function getColumnByMember(string $name) : string
    {
        foreach (static::$columns as $cName => $column) {
            if ($column['internal'] === $name) {
                return $cName;
            }
        }

        throw new \Exception('Invalid member name');
    }
}
