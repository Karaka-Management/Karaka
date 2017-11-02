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
interface FileInterface extends ContainerInterface
{

    /**
     * Save content to file.
     *
     * @param string $path File path to save the content to
     * @param string $content Content to save in file
     * @param int $mode Mode (overwrite, append)
     *
     * @return bool 
     *
     * @since  1.0.0
     */
    public static function put(string $path, string $content, int $mode = ContentPutMode::APPEND | ContentPutMode::CREATE) : bool;

    /**
     * Save content to file.
     *
     * Creates new file if it doesn't exist or overwrites existing file.
     *
     * @param string $path File path to save the content to
     * @param string $content Content to save in file
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function set(string $path, string $content) : bool;

    /**
     * Save content to file.
     *
     * Creates new file if it doesn't exist or appends existing file.
     *
     * @param string $path File path to save the content to
     * @param string $content Content to save in file
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function append(string $path, string $content) : bool;

    /**
     * Save content to file.
     *
     * Creates new file if it doesn't exist or prepends existing file.
     *
     * @param string $path File path to save the content to
     * @param string $content Content to save in file
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function prepend(string $path, string $content) : bool;

    /**
     * Get content from file.
     *
     * @param string $path File path of content
     *
     * @return string Content of file
     *
     * @since  1.0.0
     */
    public static function get(string $path) : string;

    /**
     * Get file extension.
     *
     * @param string $path File path
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function extension(string $path) : string;

    /**
     * Save content to file.
     *
     * @param string $content Content to save in file
     * @param int $mode Mode (overwrite, append)
     *
     * @return bool 
     *
     * @since  1.0.0
     */
    public function putContent(string $content, int $mode = ContentPutMode::APPEND | ContentPutMode::CREATE) : bool;

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
    public function setContent(string $content) : bool;

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
    public function appendContent(string $content) : bool;

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
    public function prependContent(string $content) : bool;

    /**
     * Get content from file.
     *
     * @return string Content of file
     *
     * @since  1.0.0
     */
    public function getContent() : string;

    /**
     * Get file extension.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getExtension() : string;
}
