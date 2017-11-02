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

namespace phpOMS\Module;

use phpOMS\System\File\PathException;
use phpOMS\Utils\ArrayUtils;

/**
 * InfoManager class.
 *
 * Handling the info files for modules
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class InfoManager
{

    /**
     * File path.
     *
     * @var string
     * @since 1.0.0
     */
    private $path = '';

    /**
     * Info data.
     *
     * @var array
     * @since 1.0.0
     */
    private $info = [];

    /**
     * Object constructor.
     *
     * @param string $path Info file path
     *
     * @since  1.0.0
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Get info path
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * Load info data from path.
     *
     * @return void
     *
     * @throws PathException This exception is thrown in case the info file path doesn't exist.
     *
     * @since  1.0.0
     */
    public function load() /* : void */
    {
        if (!file_exists($this->path)) {
            throw new PathException($this->path);
        }

        $this->info = json_decode(file_get_contents($this->path), true);
    }

    /**
     * Update info file
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function update() /* : void */
    {
        if (!file_exists($this->path)) {
            throw new PathException((string) $this->path);
        }

        file_put_contents($this->path, json_encode($this->info, JSON_PRETTY_PRINT));
    }

    /**
     * Set data
     *
     * @param string $path  Value path
     * @param mixed  $data  Scalar or array of data to set
     * @param string $delim Delimiter of path
     *
     * @since  1.0.0
     */
    public function set(string $path, $data, string $delim = '/') /* : void */
    {
        if (!is_scalar($data) && !is_array($data) && !($data instanceof \JsonSerializable)) {
            throw new \InvalidArgumentException('Type of $data "' . gettype($data) . '" is not supported.');
        }

        ArrayUtils::setArray($path, $this->info, $data, $delim, true);
    }

    /**
     * Get info data.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function get() : array
    {
        return $this->info;
    }

    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getInternalName() : string
    {
        return $this->info['name']['internal'] ?? '';
    }

    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getExternalName() : string
    {
        return $this->info['name']['external'] ?? '';
    }

    /**
     * Get info data.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getDependencies() : array
    {
        return $this->info['dependencies'] ?? [];
    }

    /**
     * Get info data.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getProviding() : array
    {
        return $this->info['providing'] ?? [];
    }

    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getDirectory() : string
    {
        return $this->info['directory'] ?? '';
    }

    /**
     * Get info category.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getCategory() : string
    {
        return $this->info['category'] ?? '';
    }

    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getVersion() : string
    {
        return $this->info['version'] ?? '';
    }

    /**
     * Get info data.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getLoad() : array
    {
        return $this->info['load'] ?? [];
    }
}
