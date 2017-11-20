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
use phpOMS\System\File\Local\FileAbstract;
use phpOMS\System\File\Local\Directory as LocalDirectory;
use phpOMS\System\File\Local\File as LocalFile;
use phpOMS\Uri\Http;

/**
 * Filesystem class.
 *
 * Performing operations on the file system.
 *
 * All static implementations require a path/uri in the following form: ftp://user:pass@domain.com/path/subpath...
 *
 * @category   Framework
 * @package    phpOMS\System\File
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 * @codeCoverageIgnore
 */
class File extends FileAbstract implements FileInterface
{
    public static function ftpConnect(Http $http)
    {
        $con = ftp_connect($http->getBase() . $http->getPath(), $http->getPort());

        ftp_login($con, $http->getUser(), $http->getPass());
        ftp_chdir($con, $http->getPath()); // todo: is this required ?

        return $con;
    }

    public static function ftpExists($con, string $path)
    {
        $list = ftp_nlist($con, LocalFile::dirpath($path));

        return in_array(LocalFile::basename($path), $list);
    }

    /**
     * {@inheritdoc}
     */
    public static function put(string $path, string $content, int $mode = ContentPutMode::REPLACE | ContentPutMode::CREATE) : bool
    {
        $http = new Http($path);
        $con = self::ftpConnect($http);

        if (ftp_pwd($con) !== $http->getPath()) {
            return false;
        }

        $exists = self::ftpExists($con, $http);

        if (
            (($mode & ContentPutMode::APPEND) === ContentPutMode::APPEND && $exists)
            || (($mode & ContentPutMode::PREPEND) === ContentPutMode::PREPEND && $exists)
            || (($mode & ContentPutMode::REPLACE) === ContentPutMode::REPLACE && $exists)
            || (!$exists && ($mode & ContentPutMode::CREATE) === ContentPutMode::CREATE)
        ) {
            if (($mode & ContentPutMode::APPEND) === ContentPutMode::APPEND && $exists) {
                file_put_contents($path, file_get_contents($path) . $content, 0, stream_context_create(['ftp' => ['overwrite' => true]]));
            } elseif (($mode & ContentPutMode::PREPEND) === ContentPutMode::PREPEND && $exists) {
                file_put_contents($path, $content . file_get_contents($path), 0, stream_context_create(['ftp' => ['overwrite' => true]]));
            } else {
                if (!Directory::ftpExists($con, dirname($path))) {
                    Directory::ftpCreate($con, dirname($path), 0755, true);
                }

                file_put_contents($path, $content, 0, stream_context_create(['ftp' => ['overwrite' => true]]));
            }

            ftp_close($con);

            return true;
        }

        ftp_close($con);

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function get(string $path) : /* ? */string
    {
        $temp = fopen('php://temp', 'r+');
        $http = new Http($path);

        $con = self::ftpConnect($http);

        if (ftp_chdir($con, File::dirpath($path)) && ftp_fget($con, $temp, $path, FTP_BINARY, 0)) {
            rewind($temp);
            $content = stream_get_contents($temp);
        }

        fclose($temp);

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
        $http = new Http($path);
        $con = self::ftpConnect($http);
        $exists = self::ftpExists($con, $http->getPath());

        fclose($con);

        return $exists;
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
        $http = new Http($path);
        $con = self::ftpConnect($http);
        $changed = new \DateTime();

        $changed->setTimestamp(ftp_mdtm($con, $http->getPath()));

        fclose($con);
        
        return $changed;
    }

    /**
     * {@inheritdoc}
     */
    public static function size(string $path, bool $recursive = true) : int
    {
        $http = new Http($path);
        $con = self::ftpConnect($http);

        if (!self::exists($http->getPath())) {
            throw new PathException($path);
        }

        $size = ftp_size($con, $http->getPath());

        fclose($con);

        return $size;
    }

    /**
     * {@inheritdoc}
     */
    public static function owner(string $path) : int
    {
        $http = new Http($path);
        $con = self::ftpConnect($http);
        $owner = self::parseFtpFileData($con, $path)['user'] ?? '';

        fclose($con);

        return $owner;
    }

    /**
     * {@inheritdoc}
     */
    public static function permission(string $path) : int
    {
        $http = new Http($path);
        $con = self::ftpConnect($http);
        $permission = (int) self::parseFtpFileData($con, $path)['permission'] ?? 0;

        fclose($con);

        return $permission;
    }

    private static function parseFtpFileData($con, string $path) : array
    {
        $items = [];

        if (is_array($files = ftp_rawlist($con, LocalFile::dirpath($path)))) {
            foreach ($files as $fileData) { 
                if (strpos($fileData, self::name($path)) !== false) {
                    $chunks = preg_split("/\s+/", $fileData);

                    $items['permission'] = $chunks[0];
                    $items['user'] = $chunks[2];
                    $items['group'] = $chunks[3];
                    $items['size'] = $chunks[4];
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
        return LocalFile::dirname($path);
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
        return LocalFile::dirpath($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function copy(string $from, string $to, bool $overwrite = false) : bool
    {
        // todo: handle different ftp connections AND local to ftp

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
        // todo: handle different ftp connections AND local to ftp
        $http = new Http($to);
        $con = self::ftpConnect($http);

         if (!self::ftpExists($con, $from)) {
            throw new PathException($from);
        }

        if ($overwrite || !self::exists($to)) {
            if (!Directory::exists(dirname($to))) {
                Directory::create(dirname($to), 0755, true);
            }

            $rename = ftp_rename($con, $from, $to);
            fclose($con);

            return $rename;
        }

        fclose($con);

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public static function delete(string $path) : bool
    {
        $http = new Http($path);
        $con = self::ftpConnect($http);

        if (!self::ftpExists($con, $path)) {
            return false;
        }

        ftp_delete($con, $path);
        fclose($con);

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
        return LocalFile::name($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function basename(string $path) : string
    {
        return LocalFile::basename($path);
    }

    /**
     * {@inheritdoc}
     */
    public static function extension(string $path) : string
    {
        return LocalFile::extension($path);
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