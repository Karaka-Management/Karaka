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

use phpOMS\System\File\ContainerInterface;
use phpOMS\System\File\DirectoryInterface;
use phpOMS\System\File\PathException;
use phpOMS\Utils\StringUtils;

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
class Directory extends FileAbstract implements DirectoryInterface
{
    /**
     * Directory list filter.
     *
     * @var string
     * @since 1.0.0
     */
    private $filter = '*';

    /**
     * Directory nodes (files and directories).
     *
     * @var FileAbstract[]
     * @since 1.0.0
     */
    private $nodes = [];

    /**
     * Constructor.
     *
     * @param string $path   Path
     * @param string $filter Filter
     *
     * @since  1.0.0
     */
    public function __construct(string $path, string $filter = '*')
    {
        $this->filter = ltrim($filter, '\\/');
        parent::__construct($path);

        if (file_exists($this->path)) {
            $this->index();
        }
    }

    /**
     * List all files in directory.
     *
     * @param string $path   Path
     * @param string $filter Filter
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function list(string $path, string $filter = '*') : array
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        $list = [];
        $path = rtrim($path, '\\/');

        foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            $list[] = str_replace('\\', '/', $iterator->getSubPathName());
        }

        return $list;
    }

    /**
     * List all files by extension directory.
     *
     * @param string $path   Path
     * @param string $extension Extension
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function listByExtension(string $path, string $extension) : array
    {
        $list = [];
        $path = rtrim($path, '\\/');

        foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->getExtension() === $extension) {
                $list[] = str_replace('\\', '/', $iterator->getSubPathName());
            }
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function index() /* : void */
    {
        parent::index();

        foreach (glob($this->path . DIRECTORY_SEPARATOR . $this->filter) as $filename) {
            if (!StringUtils::endsWith(trim($filename), '.')) {
                $file = is_dir($filename) ? new self($filename) : new File($filename);

                $this->addNode($file);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addNode($file) : bool
    {
        $this->count += $file->getCount();
        $this->size += $file->getSize();
        $this->nodes[$file->getName()] = $file;

        return $file->createNode();
    }

    /**
     * {@inheritdoc}
     */
    public static function size(string $dir, bool $recursive = true) : int
    {
        if (!file_exists($dir) || !is_readable($dir)) {
            throw new PathException($dir);
        }

        $countSize = 0;
        $dir_array = scandir($dir);

        foreach ($dir_array as $key => $filename) {
            if ($filename === ".." || $filename === ".") {
                continue;
            }

            $path = $dir . "/" . $filename;
            if (is_dir($path) && $recursive) {
                $countSize += self::size($path, $recursive);
            } elseif (is_file($path)) {
                $countSize += filesize($path);
            }
        }

        return (int) $countSize;
    }

    /**
     * {@inheritdoc}
     */
    public static function count(string $path, bool $recursive = true, array $ignore = []) : int
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        $size  = 0;
        $files = scandir($path);
        $ignore[] = '.';
        $ignore[] = '..';

        foreach ($files as $t) {
            if (in_array($t, $ignore)) {
                continue;
            }
            if (is_dir(rtrim($path, '/') . '/' . $t)) {
                if ($recursive) {
                    $size += self::count(rtrim($path, '/') . '/' . $t, true, $ignore);
                }
            } else {
                $size++;
            }
        }

        return $size;
    }

    /**
     * {@inheritdoc}
     */
    public static function delete(string $path) : bool
    {
        $files = scandir($path);

        /* Removing . and .. */
        unset($files[1]);
        unset($files[0]);

        foreach ($files as $file) {
            if (is_dir($path . '/' . $file)) {
                self::delete($path . '/' . $file);
            } else {
                unlink($path . '/' . $file);
            }
        }

        rmdir($path);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function parent(string $path) : string
    {
        $path = explode('/', str_replace('\\', '/', $path));
        array_pop($path);

        return implode('/', $path);
    }

    /**
     * {@inheritdoc}
     * todo: move to fileAbastract since it should be the same for file and directory?
     */
    public static function created(string $path) : \DateTime
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        $created = new \DateTime('now');
        $created->setTimestamp(filemtime($path));

        return $created;
    }

    /**
     * {@inheritdoc}
     */
    public static function changed(string $path) : \DateTime
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        $changed = new \DateTime();
        $changed->setTimestamp(filectime($path));

        return $changed;
    }

    /**
     * {@inheritdoc}
     */
    public static function owner(string $path) : int
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        return fileowner($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function permission(string $path) : int
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        return fileperms($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function copy(string $from, string $to, bool $overwrite = false) : bool
    {
        if (!is_dir($from)) {
            throw new PathException($from);
        }

        if (!file_exists($to)) {
            self::create($to, 0755, true);
        } elseif ($overwrite && file_exists($to)) {
            self::delete($to);
        } else {
            return false;
        }

        foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($from, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                mkdir($to . '/' . $iterator->getSubPathName());
            } else {
                copy($from . '/' . $iterator->getSubPathName(), $to . '/' . $iterator->getSubPathName());
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function move(string $from, string $to, bool $overwrite = false) : bool
    {
        if (!is_dir($from)) {
            throw new PathException($from);
        }

        if (!$overwrite && file_exists($to)) {
            return false;
        } elseif ($overwrite && file_exists($to)) {
            self::delete($to);
        }

        if (!self::exists(self::parent($to))) {
            self::create(self::parent($to), 0755, true);
        }

        rename($from, $to);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function exists(string $path) : bool
    {
        return file_exists($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $path, string $replace = '') : string
    {
        return preg_replace('[^\w\s\d\.\-_~,;:\[\]\(\]\/]', $replace, $path);
    }

    /**
     * {@inheritdoc}
     */
    public function getNode(string $name) : FileAbstract
    {
        return $this->nodes[$name] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function createNode() : bool
    {
        return self::create($this->path, $this->permission, true);

        // todo: add node
    }

    /**
     * {@inheritdoc}
     */
    public static function create(string $path, int $permission = 0755, bool $recursive = false) : bool
    {
        if (!file_exists($path)) {
            if (!$recursive && !file_exists(self::parent($path))) {
                return false;
            }

            mkdir($path, $permission, $recursive);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function remove(string $name) : bool
    {
        if (isset($this->nodes[$name])) {
            $this->count -= $this->nodes[$name]->getCount();
            $this->size -= $this->nodes[$name]->getSize();

            unset($this->nodes[$name]);

            // todo: unlink???

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->nodes);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->nodes);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->nodes);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return next($this->nodes);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        $key = key($this->nodes);

        return ($key !== null && $key !== false);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->addNode($value);
        } else {
            $this->nodes[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->nodes[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if (isset($this->nodes[$offset])) {
            unset($this->nodes[$offset]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function name(string $path) : string
    {
        return basename($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function dirname(string $path) : string
    {
        return basename($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function dirpath(string $path) : string
    {
        return $path;
    }

    /**
     * {@inheritdoc}
     */
    public static function basename(string $path) : string
    {
        return basename($path);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent() : ContainerInterface
    {
        return new self(self::parent($this->path));
    }

    /**
     * {@inheritdoc}
     */
    public function copyNode(string $to, bool $overwrite = false) : bool
    {
        return self::copy($this->path, $to, $overwrite);
    }

    /**
     * {@inheritdoc}
     */
    public function moveNode(string $to, bool $overwrite = false) : bool
    {
        return self::move($this->path, $to, $overwrite);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteNode() : bool
    {
        return self::delete($this->path);

        // todo: remove from node list
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }
}