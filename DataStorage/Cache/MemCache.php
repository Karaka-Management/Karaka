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

namespace phpOMS\DataStorage\Cache;

/**
 * Memcache class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Cache
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class MemCache implements CacheInterface
{

    /**
     * Memcache instance.
     *
     * @var \Memcache
     * @since 1.0.0
     */
    private $memc = null;

    /**
     * Only cache if data is larger than threshold (0-100).
     *
     * @var int
     * @since 1.0.0
     */
    private $threshold = 10;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->memc = null;
    }

    /**
     * Adding server to server pool.
     *
     * @param mixed $data Server data array
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addServer($data)
    {
        $this->memc->addServer($data['host'], $data['port'], $data['timeout']);
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value, int $expire = -1) /* : void */
    {
        $this->memc->set($key, $value, false, $expire);
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $value, int $expire = -1) : bool
    {
        return $this->memc->add($key, $value, false, $expire);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, int $expire = -1)
    {
        return $this->memc->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($key, int $expire = -1) : bool
    {
        $this->memc->delete($key);
    }

    /**
     * {@inheritdoc}
     */
    public function flush(int $expire = 0) : bool
    {
        $this->memc->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function flushAll() : bool
    {
        $this->memc->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function replace($key, $value, int $expire = -1) : bool
    {
        $this->memc->replace($key, $value, false, $expire);
    }

    /**
     * {@inheritdoc}
     */
    public function stats() : array
    {
        /** @noinspection PhpMethodOrClassCallIsNotCaseSensitiveInspection */
        return $this->memc->getExtendedStats();
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
    public function setStatus(int $status)  /* : void */
    {
        $this->status = $status;
    }

    /**
     * Destructor.
     *
     * @since  1.0.0
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Closing cache.
     *
     * @since  1.0.0
     */
    public function close()
    {
        if ($this->memc !== null) {
            $this->memc->close();
            $this->memc = null;
        }
    }

}
