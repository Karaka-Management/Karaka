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
use phpOMS\System\File\StorageAbstract;

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
class FtpStorage extends StorageAbstract
{
    private $con = null;

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

    public function connect(string $uri, int $port = 21, bool $mode = true, string $login = null, string $pass = null, bool $ssl = false) : bool
    {
        if ($ssl) {
            $this->con = ftp_connect($uri, $port);
        } else {
            $this->con = ftp_ssl_connect($uri, $port);
        }

        ftp_pasv($this->con, $mode);

        if (isset($login, $pass)) {
            ftp_login($this->con, $login, $pass);
        }
    }

    public function __destruct()
    {
        if (isset($this->con)) {
            ftp_close($this->con);
            $this->con = null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function created(string $path) : \DateTime
    {
        // TODO: Implement created() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function changed(string $path) : \DateTime
    {
        // TODO: Implement changed() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function owner(string $path) : int
    {
        // TODO: Implement owner() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function permission(string $path) : int
    {
        // TODO: Implement permission() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function parent(string $path) : string
    {
        // TODO: Implement parent() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function create(string $path) : bool
    {
        // TODO: Implement create() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function delete(string $path) : bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function copy(string $from, string $to, bool $overwrite = false) : bool
    {
        // TODO: Implement copy() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function move(string $from, string $to, bool $overwrite = false) : bool
    {
        // TODO: Implement move() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function size(string $path, bool $recursive = true) : int
    {
        // TODO: Implement size() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function exists(string $path) : bool
    {
        // TODO: Implement exists() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function name(string $path) : string
    {
        // TODO: Implement name() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function basename(string $path) : string
    {
        // TODO: Implement basename() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function dirname(string $path) : string
    {
        // TODO: Implement basename() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function dirpath(string $path) : string
    {
        // TODO: Implement basename() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function list(string $path, string $filter = '*') : array
    {
        // TODO: Implement basename() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function count(string $path, bool $recursive = true, array $ignore = []) : int
    {
        // TODO: Implement count() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getCount(bool $recursive = false) : int
    {
        // TODO: Implement getCount() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getSize(bool $recursive = false) : int
    {
        // TODO: Implement getSize() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        // TODO: Implement getName() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getPath() : string
    {
        // TODO: Implement getPath() method.
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
    public function createNode() : bool
    {
        // TODO: Implement createNode() method.
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
    public function getCreatedAt() : \DateTime
    {
        // TODO: Implement getCreatedAt() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getChangedAt() : \DateTime
    {
        // TODO: Implement getChangedAt() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner() : int
    {
        // TODO: Implement getOwner() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getPermission() : string
    {
        // TODO: Implement getPermission() method.
    }

    /**
     * {@inheritdoc}
     */
    public function index()
    {
        // TODO: Implement index() method.
    }

    /**
     * Return the current element
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        // TODO: Implement current() method.
    }

    /**
     * Move forward to next element
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        // TODO: Implement next() method.
    }

    /**
     * Return the key of the current element
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        // TODO: Implement key() method.
    }

    /**
     * Checks if current position is valid
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        // TODO: Implement valid() method.
    }

    /**
     * Rewind the Iterator to the first element
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        // TODO: Implement rewind() method.
    }

    /**
     * Whether a offset exists
     * @link  http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     * @return boolean true on success or false on failure.
     *                      </p>
     *                      <p>
     *                      The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        // TODO: Implement offsetExists() method.
    }

    /**
     * Offset to retrieve
     * @link  http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        // TODO: Implement offsetGet() method.
    }

    /**
     * Offset to set
     * @link  http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        // TODO: Implement offsetSet() method.
    }

    /**
     * Offset to unset
     * @link  http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        // TODO: Implement offsetUnset() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function put(string $path, string $content, int $mode = 0) : bool
    {
        // TODO: Implement put() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function get(string $path) : string
    {
        // TODO: Implement get() method.
    }

    /**
     * {@inheritdoc}
     */
    public function putContent(string $content, int $mode = 0) : bool
    {
        // TODO: Implement putContent() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getContent() : string
    {
        // TODO: Implement getContent() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function sanitize(string $path, string $replace = '') : string
    {
        // TODO: Implement sanitize() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getNode(string $name)
    {
        // TODO: Implement getNode() method.
    }

    /**
     * {@inheritdoc}
     */
    public function addNode($file) : bool
    {
        // TODO: Implement addNode() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function set(string $path, string $content) : bool
    {
        // TODO: Implement set() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function append(string $path, string $content) : bool
    {
        // TODO: Implement append() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function prepend(string $path, string $content) : bool
    {
        // TODO: Implement prepend() method.
    }

    /**
     * {@inheritdoc}
     */
    public static function extension(string $path) : string
    {
        // TODO: Implement extension() method.
    }

    /**
     * {@inheritdoc}
     */
    public function setContent(string $content) : bool
    {
        // TODO: Implement setContent() method.
    }

    /**
     * {@inheritdoc}
     */
    public function appendContent(string $content) : bool
    {
        // TODO: Implement appendContent() method.
    }

    /**
     * {@inheritdoc}
     */
    public function prependContent(string $content) : bool
    {
        // TODO: Implement prependContent() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension() : string
    {
        // TODO: Implement getExtension() method.
    }
}