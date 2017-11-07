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
abstract class FileAbstract implements ContainerInterface
{
    /**
     * Path.
     *
     * @var string
     * @since 1.0.0
     */
    protected $path = '';

    /**
     * Name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name = 'new_directory';

    /**
     * Directory/File count.
     *
     * @var int
     * @since 1.0.0
     */
    protected $count = 0;

    /**
     * Directory/Filesize in bytes.
     *
     * @var int
     * @since 1.0.0
     */
    protected $size = 0;

    /**
     * Created at.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $createdAt = null;

    /**
     * Last changed at.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $changedAt = null;

    /**
     * Owner.
     *
     * @var int
     * @since 1.0.0
     */
    protected $owner = 0;

    /**
     * Permission.
     *
     * @var int
     * @since 1.0.0
     */
    protected $permission = 0755;

    /**
     * Constructor.
     *
     * @param string $path Path
     *
     * @since  1.0.0
     */
    public function __construct(string $path)
    {
        $this->path = rtrim($path, '/\\');
        $this->name = basename($path);

        $this->createdAt = new \DateTime('now');
        $this->changedAt = new \DateTime('now');
    }

    /**
     * {@inheritdoc}
     */
    public function getCount(bool $recursive = true) : int
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function getSize(bool $recursive = true) : int
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function parentNode() : Directory
    {
        return new Directory(Directory::parent($this->path));
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getChangedAt() : \DateTime
    {
        return $this->changedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner() : int
    {
        return $this->owner;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermission() : int
    {
        return $this->permission;
    }

    /**
     * {@inheritdoc}
     */
    public function index() /* : void */
    {
        $this->createdAt->setTimestamp(filemtime($this->path));
        $this->changedAt->setTimestamp(filectime($this->path));
        $this->owner      = fileowner($this->path);
        $this->permission = (int) substr(sprintf('%o', fileperms($this->path)), -4);
    }
}