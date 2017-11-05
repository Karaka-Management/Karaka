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

namespace phpOMS\System\File\Ftp;

use phpOMS\System\File\ContainerInterface;
use phpOMS\System\File\ContentPutMode;
use phpOMS\System\File\FileInterface;
use phpOMS\System\File\PathException;
use phpOMS\System\File\Local\File as FileLocal;
use phpOMS\System\File\Local\FileAbstract;
use phpOMS\System\File\Local\Directory as DirectoryLocal;

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
     * {@inheritdoc}
     */
    public static function put(string $path, string $content, int $mode = ContentPutMode::REPLACE | ContentPutMode::CREATE) : bool
    {
        // todo: create all else cases, right now all getting handled the same way which is wrong
        $current = ftp_pwd($con);
        if (!ftp_chdir($con, File::dirpath($path))) {
            return false;
        }

        $exists = self::exists($path);
        $result = false;

        if (
            (($mode & ContentPutMode::APPEND) === ContentPutMode::APPEND && $exists)
            || (($mode & ContentPutMode::PREPEND) === ContentPutMode::PREPEND && $exists)
            || (($mode & ContentPutMode::REPLACE) === ContentPutMode::REPLACE && $exists)
            || (!$exists && ($mode & ContentPutMode::CREATE) === ContentPutMode::CREATE)
        ) {
            if (!Directory::exists(dirname($path))) {
                Directory::create(dirname($path), 0644, true);
            }

            $stream = fopen('data://temp,' . $content, 'r');
            ftp_fput($path, $content);
            fclose($stream);

            $result = true;
        }

        ftp_chdir($current);

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public static function get(string $path) : /* ? */string
    {
        $temp = fopen('php://temp', 'r+');

        $current = ftp_pwd($con);
        if (ftp_chdir($con, File::dirpath($path)) && ftp_fget($con, $temp, $path, FTP_BINARY, 0)) {
            rewind($temp);
            $content = stream_get_contents($temp);
        }

        fclose($temp);
        ftp_chdir($current);

        return $content ?? null;
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
        
        if (($current = ftp_pwd($con)) !== LocalFile::dirpath($path)) {
            if (!ftp_chdir($con, $path)) {
                return false;
            }
        }

        $list = ftp_nlist($con, $path);

        ftp_chdir($con, $current);

        return in_array($path, $list);
    }

    /**
     * {@inheritdoc}
     */
    public static function parent(string $path) : string
    {
        return Directory::parent($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $path, string $replace = '') : string
    {
        return LocalFile::sanitize($path, $replace);
    }

    /**
     * {@inheritdoc}
     */
    public static function created(string $path) : \DateTime
    {
        return new \DateTime('1970-01-01');
    }

    /**
     * {@inheritdoc}
     */
    public static function changed(string $path) : \DateTime
    {
        $changed = new \DateTime();
        $changed->setTimestamp(ftp_mdtm($con, $path));
        
        return $changed;
    }

    /**
     * {@inheritdoc}
     */
    public static function size(string $path, bool $recursive = true) : int
    {
        if (!self::exists($path)) {
            throw new PathException($path);
        }

        return ftp_size($con, $path);
    }

    /**
     * {@inheritdoc}
     */
    public static function owner(string $path) : int
    {
        return self::parseFtpFileData($path)['user'] ?? '';
    }

    /**
     * {@inheritdoc}
     */
    public static function permission(string $path) : int
    {
        return (int) self::parseFtpFileData($path)['permission'] ?? 0;
    }

    private static function parseFtpFileData(string $path) : array
    {
        $items = []; 

        if (is_array($files = ftp_rawlist($con, self::dirpath($path)))) { 
            foreach ($files as $fileData) { 
                if (strpos($fileData, self::name($path)) !== false) {
                    $chunks = preg_split("/\s+/", $fileData); 

                    $items['permission'] = $chungs[0];
                    $items['user'] = $chungs[2];
                    $items['group'] = $chungs[3];
                    $items['size'] = $chungs[4];
                    $items['type'] = $chunks[0][0] === 'd' ? 'directory' : 'file';

                    break;
                }
            } 
        } 

        return $items; 
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
        return FileLocal::dirname($path);
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
        return FileLocal::dirpath($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function copy(string $from, string $to, bool $overwrite = false) : bool
    {
        if (($src = self::get($from)) === false) {
            return false;
        } 

        return self::put($to, $src, $overwrite ? ContentPutMode::REPLACE : ContentPutMode::CREATE);
    }

    /**
     * {@inheritdoc}
     */
    public static function move(string $from, string $to, bool $overwrite = false) : bool
    {
         if (!self::exists($from)) {
            throw new PathException($from);
        }

        if ($overwrite || !self::exists($to)) {
            if (!Directory::exists(dirname($to))) {
                Directory::create(dirname($to), 0644, true);
            }

            return ftp_rename($con, $from, $to);
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function delete(string $path) : bool
    {
        if (!self::exists($path)) {
            return false;
        }

        ftp_delete($con, $path);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public static function create(string $path) : bool
    {
        return self::put($path, '', ContentPutMode::CREATE);
    }

    /**
     * {@inheritdoc}
     */
    public static function name(string $path) : string
    {
        return FileLocal::name($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function basename(string $path) : string
    {
        return FileLocal::basename($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function extension(string $path) : string
    {
        return FileLocal::extension($path);
    }

    /**
     * Get the parent path of the resource.
     *
     * The parent resource path is always a directory.
     *
     * @return ContainerInterface
     *
     * @since  1.0.0
     */
    public function getParent() : ContainerInterface
    {
        // TODO: Implement getParent() method.
    }

    /**
     * Create resource at destination path.
     *
     * @return bool True on success and false on failure
     *
     * @since  1.0.0
     */
    public function createNode() : bool
    {
        // TODO: Implement createNode() method.
    }

    /**
     * Copy resource to different location.
     *
     * @param string $to        Path of the resource to copy to
     * @param bool   $overwrite Overwrite/replace existing file
     *
     * @return bool True on success and false on failure
     *
     * @since  1.0.0
     */
    public function copyNode(string $to, bool $overwrite = false) : bool
    {
        // TODO: Implement copyNode() method.
    }

    /**
     * Move resource to different location.
     *
     * @param string $to        Path of the resource to move to
     * @param bool   $overwrite Overwrite/replace existing file
     *
     * @return bool True on success and false on failure
     *
     * @since  1.0.0
     */
    public function moveNode(string $to, bool $overwrite = false) : bool
    {
        // TODO: Implement moveNode() method.
    }

    /**
     * Delete resource at destination path.
     *
     * @return bool True on success and false on failure
     *
     * @since  1.0.0
     */
    public function deleteNode() : bool
    {
        // TODO: Implement deleteNode() method.
    }

    /**
     * Save content to file.
     *
     * @param string $content Content to save in file
     * @param int    $mode    Mode (overwrite, append)
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function putContent(string $content, int $mode = ContentPutMode::APPEND | ContentPutMode::CREATE) : bool
    {
        // TODO: Implement putContent() method.
    }

    /**
     * Save content to file.
     *
     * Creates new file if it doesn't exist or overwrites existing file.
     *
     * @param string $content Content to save in file
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function setContent(string $content) : bool
    {
        // TODO: Implement setContent() method.
    }

    /**
     * Save content to file.
     *
     * Creates new file if it doesn't exist or overwrites existing file.
     *
     * @param string $content Content to save in file
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function appendContent(string $content) : bool
    {
        // TODO: Implement appendContent() method.
    }

    /**
     * Save content to file.
     *
     * Creates new file if it doesn't exist or overwrites existing file.
     *
     * @param string $content Content to save in file
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function prependContent(string $content) : bool
    {
        // TODO: Implement prependContent() method.
    }

    /**
     * Get content from file.
     *
     * @return string Content of file
     *
     * @since  1.0.0
     */
    public function getContent() : string
    {
        // TODO: Implement getContent() method.
    }

    /**
     * Get file extension.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getExtension() : string
    {
        // TODO: Implement getExtension() method.
    }
}