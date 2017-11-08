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
namespace Modules\Admin\Models;

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
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class PackageInfoManager
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
    public function __construct($path)
    {
        $this->path = realpath($path);
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
     * @since  1.0.0
     */
    public function load() /* : void */
    {
        if ($this->path === false || !file_exists($this->path)) {
            throw new PathException((string) $this->path);
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
        if ($this->path === false || !file_exists($this->path)) {
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
    public function getSystem() : string
    {
        return $this->info['system'] ?? '';
    }
    
    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getSubSystem() : string
    {
        return $this->info['subsystem'] ?? '';
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
     * @return string
     *
     * @since  1.0.0
     */
    public function getChangelog() : string
    {
        return $this->info['changelog'] ?? '';
    }
    
    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getType() : string
    {
        return $this->info['type'] ?? '';
    }
    
    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getSubType() : string
    {
        return $this->info['subtype'] ?? '';
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
     * @return string
     *
     * @since  1.0.0
     */
    public function getVersionOld() : string
    {
        return $this->info['version']['old'] ?? '';
    }
    
    /**
     * Get info data.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getVersionNew() : string
    {
        return $this->info['version']['new'] ?? '';
    }
    
    /**
     * Get info data.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getChanges() : array
    {
        return $this->info['changes'] ?? [];
    }
}
