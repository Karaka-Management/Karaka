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
use phpOMS\System\File\ContentPutMode;
use phpOMS\System\File\FileInterface;
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
class File extends FileAbstract implements FileInterface
{

    /**
     * Constructor.
     *
     * @param string $path Path
     *
     * @since  1.0.0
     */
    public function __construct(string $path)
    {
        parent::__construct($path);
        $this->count = 1;

        if (file_exists($this->path)) {
            $this->index();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function index() /* : void */
    {
        parent::index();

        $this->size = filesize($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public static function put(string $path, string $content, int $mode = ContentPutMode::REPLACE | ContentPutMode::CREATE) : bool
    {
        $exists = file_exists($path);

        if (
            (($mode & ContentPutMode::APPEND) === ContentPutMode::APPEND && $exists)
            || (($mode & ContentPutMode::PREPEND) === ContentPutMode::PREPEND && $exists)
            || (($mode & ContentPutMode::REPLACE) === ContentPutMode::REPLACE && $exists)
            || (!$exists && ($mode & ContentPutMode::CREATE) === ContentPutMode::CREATE)
        ) {
            if (($mode & ContentPutMode::APPEND) === ContentPutMode::APPEND && $exists) {
                file_put_contents($path, file_get_contents($path) . $content);
            } elseif (($mode & ContentPutMode::PREPEND) === ContentPutMode::PREPEND && $exists) {
                file_put_contents($path, $content . file_get_contents($path));
            } else {
                if (!Directory::exists(dirname($path))) {
                    Directory::create(dirname($path), 0755, true);
                }

                file_put_contents($path, $content);
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function get(string $path) : string
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        return file_get_contents($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function count(string $path, bool $recursive = true, array $ignore = []) : int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public static function set(string $path, string $content) : bool
    {
        return self::put($path, $content, ContentPutMode::REPLACE | ContentPutMode::CREATE);
    }

    /**
     * {@inheritdoc}
     */
    public static function append(string $path, string $content) : bool
    {
        return self::put($path, $content, ContentPutMode::APPEND | ContentPutMode::CREATE);
    }

    /**
     * {@inheritdoc}
     */
    public static function prepend(string $path, string $content) : bool
    {
        return self::put($path, $content, ContentPutMode::PREPEND | ContentPutMode::CREATE);
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
    public static function parent(string $path) : string
    {
        return Directory::parent(dirname($path));
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $path, string $replace = '') : string
    {
        return preg_replace('/[^\w\s\d\.\-_~,;\/\[\]\(\]]/', $replace, $path);
    }

    /**
     * {@inheritdoc}
     */
    public static function created(string $path) : \DateTime
    {
        return self::createFileTime($path, filemtime($path));
    }

    /**
     * {@inheritdoc}
     */
    public static function changed(string $path) : \DateTime
    {
        return self::createFileTime($path, filectime($path));
    }

    private static function createFileTime(string $path, int $time)
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        $fileTime = new \DateTime();
        $fileTime->setTimestamp($time);

        return $fileTime;
    }

    /**
     * {@inheritdoc}
     */
    public static function size(string $path, bool $recursive = true) : int
    {
        if (!file_exists($path)) {
            throw new PathException($path);
        }

        return filesize($path);
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
     * Gets the directory name of a file.
     * 
     * @param  string $path Path of the file to get the directory name for.
     * 
     * @return string Returns the directory name of the file.
     *
     * @since 1.0.0
     */
    public static function dirname(string $path) : string
    {
        return basename(dirname($path));
    }

    /**
     * Gets the directory path of a file.
     * 
     * @param  string $path Path of the file to get the directory name for.
     * 
     * @return string Returns the directory name of the file.
     *
     * @since 1.0.0
     */
    public static function dirpath(string $path) : string
    {
        return dirname($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function copy(string $from, string $to, bool $overwrite = false) : bool
    {
        if (!is_file($from)) {
            throw new PathException($from);
        }

        if ($overwrite || !file_exists($to)) {
            if (!Directory::exists(dirname($to))) {
                Directory::create(dirname($to), 0755, true);
            }

            if ($overwrite && file_exists($to)) {
                unlink($to);
            }

            copy($from, $to);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function move(string $from, string $to, bool $overwrite = false) : bool
    {
        $result = self::copy($from, $to, $overwrite);

        if(!$result) {
            return false;
        }

        return self::delete($from);
    }

    /**
     * {@inheritdoc}
     */
    public static function delete(string $path) : bool
    {
        if (!file_exists($path)) {
            return false;
        }

        unlink($path);

        return true;
    }

    /**
     * Gets the directory name of a file.
     * 
     * @return string Returns the directory name of the file.
     *
     * @since 1.0.0
     */
    public function getDirName() : string
    {
        return basename(dirname($this->path));
    }

    /**
     * Gets the directory path of a file.
     * 
     * @return string Returns the directory path of the file.
     *
     * @since 1.0.0
     */
    public function getDirPath() : string
    {
        return dirname($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public function createNode() : bool
    {
        return self::create($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public static function create(string $path) : bool
    {
        if (!file_exists($path)) {
            if (!Directory::exists(dirname($path))) {
                Directory::create(dirname($path), 0755, true);
            }

            if (!is_writable(dirname($path))) {
                return false;
            }
            
            touch($path);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getContent() : string
    {
        return file_get_contents($this->path);
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(string $content) : bool
    {
        return $this->putContent($content, ContentPutMode::REPLACE | ContentPutMode::CREATE);
    }

    /**
     * {@inheritdoc}
     */
    public function appendContent(string $content) : bool
    {
        return $this->putContent($content, ContentPutMode::APPEND | ContentPutMode::CREATE);
    }

    /**
     * {@inheritdoc}
     */
    public function prependContent(string $content) : bool
    {
        return $this->putContent($content, ContentPutMode::PREPEND | ContentPutMode::CREATE);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return explode('.', $this->name)[0];
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension() : string
    {
        $extension = explode('.', $this->name);

        return $extension[1] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public function getParent() : ContainerInterface
    {
        // TODO: Implement getParent() method.
    }

    /**
     * {@inheritdoc}
     */
    public function copyNode(string $to, bool $overwrite = false) : bool
    {
        // TODO: Implement copyNode() method.
    }

    /**
     * {@inheritdoc}
     */
    public function moveNode(string $to, bool $overwrite = false) : bool
    {
        // TODO: Implement moveNode() method.
    }

    /**
     * {@inheritdoc}
     */
    public function deleteNode() : bool
    {
        // TODO: Implement deleteNode() method.
    }

    /**
     * {@inheritdoc}
     */
    public function putContent(string $content, int $mode = ContentPutMode::APPEND | ContentPutMode::CREATE) : bool
    {
        // TODO: Implement putContent() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function name(string $path) : string
    {
        return explode('.', basename($path))[0];
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
    public static function extension(string $path) : string
    {
        $extension = explode('.', basename($path));

        return $extension[1] ?? '';
    }
}