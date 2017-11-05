<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Asset;

/**
 * Asset manager class.
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class AssetManager implements \Countable
{

    /**
     * Assets.
     *
     * @var array
     * @since 1.0.0
     */
    private $assets = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Add asset.
     *
     * @param string $id        Asset id
     * @param string $asset     Asset
     * @param bool   $overwrite Overwrite
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function set(string $id, string $asset, bool $overwrite = true) : bool
    {
        if ($overwrite || !isset($this->assets[$id])) {
            $this->assets[$id] = $asset;

            return true;
        }

        return false;
    }

    /**
     * Remove asset.
     *
     * @param string $id Asset id
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function remove(string $id) : bool
    {
        if (isset($this->assets[$id])) {
            unset($this->assets[$id]);

            return true;
        }

        return false;
    }

    /**
     * Get asset.
     *
     * @param string $id Asset id
     *
     * @return mixed Asset
     *
     * @since  1.0.0
     */
    public function get(string $id) /* : ?string */
    {
        if (isset($this->assets[$id])) {
            return $this->assets[$id];
        }

        return null;
    }

    /**
     * Get asset count.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function count() : int
    {
        return count($this->assets);
    }

}
