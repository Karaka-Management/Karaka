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

namespace phpOMS\Message;

use phpOMS\Localization\Localization;

/**
 * Response class.
 *
 * @category   Framework
 * @package    phpOMS\Response
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class HeaderAbstract
{
    /**
     * Responses.
     *
     * @var bool
     * @since 1.0.0
     */
    protected static $isLocked = false;
    
    /**
     * Localization.
     *
     * @var Localization
     * @since 1.0.0
     */
    protected $l11n = null;
    
    /**
     * Account.
     *
     * @var int
     * @since 1.0.0
     */
    protected $account = 0;
    
    /**
     * Response status.
     *
     * @var int
     * @since 1.0.0
     */
    protected $status = 0;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->l11n = new Localization();
    }
    
    /**
     * Set header locked.
     *
     * @since  1.0.0
     */
    public static function lock() /* : void */
    {
        // todo: maybe pass session as member and make lock not static
        self::$isLocked = true;
    }
    
    /**
     * Is header locked?
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isLocked() : bool
    {
        return self::$isLocked;
    }

    /**
     * Get Localization
     *
     * @return Localization
     *
     * @since  1.0.0
     */
    public function getL11n() : Localization
    {
        return $this->l11n;
    }

    /**
     * Set localization
     *
     * @param Localization $l11n Localization
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public function setL11n(Localization $l11n) /* : void */
    {
        $this->l11n = $l11n;
    }

    /**
     * Get account id
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getAccount() : int
    {
        return $this->account;
    }

    /**
     * Set account id
     *
     * @param int $account Account id
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public function setAccount(int $account) /* : void */
    {
        $this->account = $account;
    }
    
    /**
     * Set status code
     *
     * @param int $status Status code
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public function setStatusCode(int $status) /* : void */
    {
        $this->status = $status;
        $this->generate($status);
    }

    /**
     * Generate header based on status code.
     *
     * @param int $statusCode Status code
     *
     * @since  1.0.0
     */
    abstract public function generate(int $statusCode) /* : void */;

    /**
     * Get status code
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatusCode() : int
    {
        return $this->status;
    }

    /**
     * Get protocol version.
     *
     * @return string
     *
     * @since  1.0.0
     */
    abstract public function getProtocolVersion() : string;

    /**
     * Set header.
     *
     * @param string $key       Header key
     * @param string $value     Header value
     * @param bool   $overwrite Overwrite if key already exists
     *
     * @since  1.0.0
     */
    abstract public function set(string $key, string $value, bool $overwrite = false);

    /**
     * Get header by key.
     *
     * @param string $key Header key
     *
     * @return array
     *
     * @since  1.0.0
     */
    abstract public function get(string $key) : array;

    /**
     * Header has key?
     *
     * @param string $key Header key
     *
     * @return bool
     *
     * @since  1.0.0
     */
    abstract public function has(string $key) : bool;
}
