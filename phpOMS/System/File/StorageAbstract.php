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

namespace phpOMS\System\File;

/**
 * Filesystem class.
 *
 * Performing operations on the file system
 *
 * @category   Framework
 * @package    phpOMS\System\File
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class StorageAbstract
{
    /**
     * Storage type.
     *
     * @var int
     * @since 1.0.0
     */
    protected $type = 0;

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
     * Get instance.
     *
     * @return mixed Storage instance.
     *
     * @since  1.0.0
     */
    public static function getInstance() : StorageAbstract
    {
        return null;
    }
    /**
     * Get storage type.
     *
     * @return int Storage type.
     *
     * @since  1.0.0
     */
    public function getType() : int
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public static function created(string $path) : \DateTime
    {
        return static::getClassType($path)::created($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function changed(string $path) : \DateTime
    {
        return static::getClassType($path)::changed($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function owner(string $path) : int
    {
        return static::getClassType($path)::owner($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function permission(string $path) : int
    {
        return static::getClassType($path)::permission($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function parent(string $path) : string
    {
        return static::getClassType($path)::parent($path);
    }

    /**
     * {@inheritdoc}
     */
    abstract public static function create(string $path) : bool;

    /**
     * {@inheritdoc}
     */
    public static function delete(string $path) : bool
    {
        return static::getClassType($path)::delete($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function copy(string $from, string $to, bool $overwrite = false) : bool
    {
        return static::getClassType($from)::copy($from, $to, $overwrite);
    }

    /**
     * {@inheritdoc}
     */
    public static function move(string $from, string $to, bool $overwrite = false) : bool
    {
        return static::getClassType($from)::move($from, $to, $overwrite);
    }

    /**
     * {@inheritdoc}
     */
    public static function size(string $path, bool $recursive = true) : int
    {
        return static::getClassType($path)::size($path, $recursive);
    }

    /**
     * {@inheritdoc}
     */
    public static function exists(string $path) : bool
    {
        return static::getClassType($path)::exists($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function name(string $path) : string
    {
        return static::getClassType($path)::name($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function basename(string $path) : string
    {
        return static::getClassType($path)::basename($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function dirname(string $path) : string
    {
        return static::getClassType($path)::dirname($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function dirpath(string $path) : string
    {
        return static::getClassType($path)::dirpath($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function count(string $path, bool $recursive = true, array $ignore = []) : int
    {
        return static::getClassType($path)::count($path, $recursive, $ignore);
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $path, string $replace = '') : string
    {
        return static::getClassType($path)::sanitize($path, $replace);
    }

    /**
     * {@inheritdoc}
     */
    abstract public static function list(string $path, string $filter = '*') : array;

    /**
     * {@inheritdoc}
     */
    abstract public static function put(string $path, string $content, int $mode = 0) : bool;

    /**
     * {@inheritdoc}
     */
    abstract public static function get(string $path) : string;

    /**
     * {@inheritdoc}
     */
    abstract public static function set(string $path, string $content) : bool;

    /**
     * {@inheritdoc}
     */
    abstract public static function append(string $path, string $content) : bool;

    /**
     * {@inheritdoc}
     */
    abstract public static function prepend(string $path, string $content) : bool;

    /**
     * {@inheritdoc}
     */
    abstract public static function extension(string $path) : string;
}
