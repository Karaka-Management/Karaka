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

namespace phpOMS\System\File\Local;
use phpOMS\System\File\StorageAbstract;
use phpOMS\System\File\PathException;

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
class LocalStorage extends StorageAbstract
{
    private static $instance = null;

    public function __construct() {
        
    }

    public static function getInstance() : StorageAbstract
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private static function getClassType(string $path) : string
    {
        return is_dir($path) || (!is_file($path) && stripos($path, '.') === false) ? Directory::class : File::class;
    }

    /**
     * {@inheritdoc}
     */
    public static function created(string $path) : \DateTime
    {
        return self::getClassType($path)::created($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function changed(string $path) : \DateTime
    {
        return self::getClassType($path)::changed($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function owner(string $path) : int
    {
        return self::getClassType($path)::owner($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function permission(string $path) : int
    {
        return self::getClassType($path)::permission($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function parent(string $path) : string
    {
        return self::getClassType($path)::parent($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function create(string $path) : bool
    {
        return stripos($path, '.') === false ? Directory::create($path, 0644, true) : File::create($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function delete(string $path) : bool
    {
        return self::getClassType($path)::delete($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function copy(string $from, string $to, bool $overwrite = false) : bool
    {
        return self::getClassType($from)::copy($from, $to, $overwrite);
    }

    /**
     * {@inheritdoc}
     */
    public static function move(string $from, string $to, bool $overwrite = false) : bool
    {
        return self::getClassType($from)::move($from, $to, $overwrite);
    }

    /**
     * {@inheritdoc}
     */
    public static function size(string $path, bool $recursive = true) : int
    {
        return self::getClassType($path)::size($path, $recursive);
    }

    /**
     * {@inheritdoc}
     */
    public static function exists(string $path) : bool
    {
        return self::getClassType($path)::exists($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function name(string $path) : string
    {
        return self::getClassType($path)::name($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function basename(string $path) : string
    {
        return self::getClassType($path)::basename($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function dirname(string $path) : string
    {
        return self::getClassType($path)::dirname($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function dirpath(string $path) : string
    {
        return self::getClassType($path)::dirpath($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function count(string $path, bool $recursive = true, array $ignore = []) : int
    {
        return self::getClassType($path)::count($path, $recursive, $ignore);
    }

    /**
     * {@inheritdoc}
     */
    public static function put(string $path, string $content, int $mode = 0) : bool
    {
        if (is_dir($path)) {
            throw new PathException($path);
        }

        return File::put($path, $content, $mode);
    }

    /**
     * {@inheritdoc}
     */
    public static function get(string $path) : string
    {
        if (is_dir($path)) {
            throw new PathException($path);
        }

        return File::get($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function list(string $path, string $filter = '*') : array
    {
        if (is_file($path)) {
            throw new PathException($path);
        }

        return Directory::list($path, $filter);
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $path, string $replace = '') : string
    {
        return self::getClassType($path)::sanitize($path, $replace);
    }

    /**
     * {@inheritdoc}
     */
    public static function set(string $path, string $content) : bool
    {
        if (is_dir($path)) {
            throw new PathException($path);
        }

        return File::set($path, $content);
    }

    /**
     * {@inheritdoc}
     */
    public static function append(string $path, string $content) : bool
    {
        if (is_dir($path)) {
            throw new PathException($path);
        }

        return File::append($path, $content);
    }

    /**
     * {@inheritdoc}
     */
    public static function prepend(string $path, string $content) : bool
    {
        if (is_dir($path)) {
            throw new PathException($path);
        }

        return File::prepend($path, $content);
    }

    /**
     * {@inheritdoc}
     */
    public static function extension(string $path) : string
    {
        if (is_dir($path)) {
            throw new PathException($path);
        }

        return File::extension($path);
    }
}