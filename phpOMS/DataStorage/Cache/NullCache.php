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

namespace phpOMS\DataStorage\Cache;

/**
 * Null cache class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Cache
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class NullCache implements CacheInterface
{

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, int $expire = -1) /* : void */
    {
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value, int $expire = -1) : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, int $expire = -1)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key, int $expire = -1) : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(int $expire = 0) : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function flushAll() : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function replace($key, $value, int $expire = -1) : bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function stats() : array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getThreshold() : int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(int $status) /* : void */
    {
    }
}
