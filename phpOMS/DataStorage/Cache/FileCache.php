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

use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;
use phpOMS\System\File\Local\Directory;
use phpOMS\System\File\Local\File;

/**
 * MemCache class.
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Cache
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class FileCache implements CacheInterface
{

    /**
     * Delimiter for cache meta data
     *
     * @var string
     * @since 1.0.0
     */
    /* private */ const DELIM = '$';

    /**
     * File path sanitizer
     *
     * @var string
     * @since 1.0.0
     */
    /* private */ const SANITIZE = '~';

    /**
     * Cache path.
     *
     * @var string
     * @since 1.0.0
     */
    private $cachePath = __DIR__ . '/../../../Cache';

    /**
     * Only cache if data is larger than threshold (0-100).
     *
     * @var int
     * @since 1.0.0
     */
    private $threshold = 50;

    /**
     * Cache status.
     *
     * @var int
     * @since 1.0.0
     */
    private $status = CacheStatus::ACTIVE;

    /**
     * Constructor
     *
     * @param string $path Cache path
     *
     * @since  1.0.0
     */
    public function __construct(string $path)
    {
        if (!Directory::exists(File::parent($path))) {
            Directory::create($path, 0664, true);
        }

        $this->cachePath = realpath($path);
    }

    /**
     * {@inheritdoc}
     */
    public function flushAll() : bool
    {
        if ($this->status !== CacheStatus::ACTIVE) {
            return false;
        }

        array_map('unlink', glob($this->cachePath . '/*'));

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatus(int $status) /* : void */
    {
        if (!CacheStatus::isValidValue($status)) {
            throw new InvalidEnumValue($status);
        }

        $this->status = $status;
    }

    /**
     * {@inheritdoc}
     */
    public function stats() : array
    {
        $stats            = [];
        $stats['status']  = $this->status;
        $stats['count']   = Directory::count($this->cachePath);
        $stats['size']    = Directory::size($this->cachePath);
        $stats['changed'] = Directory::changed($this->cachePath);

        return $stats;
    }

    /**
     * {@inheritdoc}
     */
    public function getThreshold() : int
    {
        return $this->threshold;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, int $expire = -1) /* : void */
    {
        if ($this->status !== CacheStatus::ACTIVE) {
            return false;
        }

        // todo: allow $key to contain / as char and create subdirectory if necessary. This is important for cleaner caching.
        $path = File::sanitize($key, self::SANITIZE);

        File::put($this->cachePath . '/' . trim($path, '/') . '.cache', $this->build($value, $expire));

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value, int $expire = -1) : bool
    {
        if ($this->status !== CacheStatus::ACTIVE) {
            return false;
        }

        $path = $this->getPath($key);

        if (!File::exists($path)) {
            File::put($path, $this->build($value, $expire));

            return true;
        }

        return false;
    }

    /**
     * Removing all cache elements larger or equal to the expiration date. Call flushAll for removing persistent cache elements (expiration is negative) as well.
     *
     * @param mixed $value  Data to cache
     * @param int   $expire Expire date of the cached data
     *
     * @return string
     *
     * @since  1.0.0
     */
    private function build($value, int $expire) : string
    {
        $type = $this->dataType($value);
        $raw  = $this->stringify($value, $type);

        return $type . self::DELIM . $expire . self::DELIM . $raw;
    }

    /**
     * Analyze caching data type.
     *
     * @param mixed $value Data to cache
     *
     * @return int
     *
     * @since  1.0.0
     */
    private function dataType($value) : int
    {
        if (is_int($value)) {
            return CacheType::_INT;
        } elseif (is_float($value)) {
            return CacheType::_FLOAT;
        } elseif (is_string($value)) {
            return CacheType::_STRING;
        } elseif (is_bool($value)) {
            return CacheType::_BOOL;
        } elseif (is_array($value)) {
            return CacheType::_ARRAY;
        } elseif ($value instanceof \Serializable) {
            return CacheType::_SERIALIZABLE;
        } elseif ($value instanceof \JsonSerializable) {
            return CacheType::_JSONSERIALIZABLE;
        }

        throw new \InvalidArgumentException('Invalid value');
    }

    /**
     * Create string representation of data for storage
     *
     * @param mixed $value Value of the data
     * @param int   $type  Type of the cache data
     *
     * @return string
     *
     * @throws InvalidEnumValue
     *
     * @since  1.0.0
     */
    private function stringify($value, int $type) : string
    {
        if ($type === CacheType::_INT || $type === CacheType::_FLOAT || $type === CacheType::_STRING || $type === CacheType::_BOOL) {
            return (string) $value;
        } elseif ($type === CacheType::_ARRAY) {
            return json_encode($value);
        } elseif ($type === CacheType::_SERIALIZABLE) {
            return get_class($value) . self::DELIM . $value->serialize();
        } elseif ($type === CacheType::_JSONSERIALIZABLE) {
            return get_class($value) . self::DELIM . $value->jsonSerialize();
        }

        throw new InvalidEnumValue($type);
    }

    /**
     * Get expire offset
     *
     * @param string $raw Raw data
     *
     * @return int
     *
     * @since  1.0.0
     */
    private function getExpire(string $raw) : int
    {
        $expireStart = strpos($raw, self::DELIM);
        $expireEnd   = strpos($raw, self::DELIM, $expireStart + 1);

        return (int) substr($raw, $expireStart + 1, $expireEnd - ($expireStart + 1));
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, int $expire = -1)
    {
        if ($this->status !== CacheStatus::ACTIVE) {
            return null;
        }

        $path = $this->getPath($key);

        if (!File::exists($path)) {
            return null;
        }
        
        $created = Directory::created($path)->getTimestamp();
        $now     = time();

        if ($expire >= 0 && $created + $expire < $now) {
            return null;
        }

        $raw  = File::get($path);
        $type = (int) $raw[0];

        $expireStart = strpos($raw, self::DELIM);
        $expireEnd   = strpos($raw, self::DELIM, $expireStart + 1);
        $cacheExpire = substr($raw, $expireStart + 1, $expireEnd - ($expireStart + 1));

        if ($cacheExpire >= 0 && $created + $cacheExpire < $now) {
            $this->delete($key);

            return null;
        }

        return $this->parseValue($type, $raw, $expireEnd);
    }

    private function parseValue(int $type, string $raw, int $expireEnd) 
    {
        $value = null;

        switch ($type) {
            case CacheType::_INT:
                $value = (int) substr($raw, $expireEnd + 1);
                break;
            case CacheType::_FLOAT:
                $value = (float) substr($raw, $expireEnd + 1);
                break;
            case CacheType::_BOOL:
                $value = (bool) substr($raw, $expireEnd + 1);
                break;
            case CacheType::_STRING:
                $value = substr($raw, $expireEnd + 1);
                break;
            case CacheType::_ARRAY:
                $value = json_decode(substr($raw, $expireEnd + 1));
                break;
            case CacheType::_SERIALIZABLE:
            case CacheType::_JSONSERIALIZABLE:
                $namespaceStart = strpos($raw, self::DELIM, $expireEnd);
                $namespaceEnd   = strpos($raw, self::DELIM, $namespaceStart + 1);
                $namespace      = substr($raw, $namespaceStart, $namespaceEnd);

                $value = $namespace::unserialize(substr($raw, $namespaceEnd + 1));
                break;
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key, int $expire = -1) : bool
    {
        if ($this->status !== CacheStatus::ACTIVE) {
            return false;
        }

        $path = $this->getPath($key);

        if ($expire < 0 && File::exists($path)) {
            File::delete($path);

            return true;
        }

        if ($expire >= 0) {
            $created     = Directory::created(File::sanitize($key, self::SANITIZE))->getTimestamp();
            $now         = time();
            $raw         = file_get_contents($path);
            $expireStart = strpos($raw, self::DELIM);
            $expireEnd   = strpos($raw, self::DELIM, $expireStart + 1);
            $cacheExpire = substr($raw, $expireStart + 1, $expireEnd - ($expireStart + 1));

            if ($cacheExpire >= 0 && $created + $cacheExpire > $now) {
                File::delete($path);

                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(int $expire = 0) : bool
    {
        if ($this->status !== CacheStatus::ACTIVE) {
            return false;
        }

        $dir = new Directory($this->cachePath);
        $now = time();

        foreach ($dir as $file) {
            if ($file instanceof File) {
                $created = $file->getCreatedAt()->getTimestamp();
                if (
                    ($expire >= 0 && $created + $expire < $now)
                    || ($expire < 0 && $created + $this->getExpire($file->getContent()) < $now)
                ) {
                    File::delete($file->getPath());
                }
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function replace($key, $value, int $expire = -1) : bool
    {
        if ($this->status !== CacheStatus::ACTIVE) {
            return false;
        }

        $path = $this->getPath($key);

        if (File::exists($path)) {
            File::put($path, $this->build($value, $expire));

            return true;
        }

        return false;
    }

    private function getPath($key) : string
    {
        $path = File::sanitize($key, self::SANITIZE);
        return $this->cachePath . '/' . trim($path, '/') . '.cache';
    }
}
