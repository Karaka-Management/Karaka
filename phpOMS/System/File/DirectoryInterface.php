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

namespace phpOMS\System\File;

/**
 * Filesystem class.
 *
 * Performing operations on the file system
 *
 * @category   Framework
 * @package    phpOMS\System\File
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface DirectoryInterface extends ContainerInterface, \Iterator, \ArrayAccess
{
    /**
     * Get amount of sub-resources.
     *
     * A file will always return 1 as it doesn't have any sub-resources.
     *
     * @param string $path      Path of the resource
     * @param bool   $recursive Should count also sub-sub-resources
     * @param array  $ignore    Ignore files
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function count(string $path, bool $recursive = true, array $ignore = []) : int;

    /**
     * Get node by name.
     *
     * @param string $name File/direcotry name
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getNode(string $name);

    /**
     * Add file or directory.
     *
     * @param mixed $file File to add
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function addNode($file) : bool;
}
