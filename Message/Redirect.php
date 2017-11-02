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

namespace Model\Message;

use phpOMS\Contract\ArrayableInterface;

/**
 * Redirect class.
 *
 * @category   Modules
 * @package    Model\Message
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Redirect implements \Serializable, ArrayableInterface, \JsonSerializable
{

    /**
     * Message type.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const TYPE = 'redirect';

    /**
     * Redirect uri.
     *
     * @var string
     * @since 1.0.0
     */
    private $uri = '';

    /**
     * Delay.
     *
     * @var int
     * @since 1.0.0
     */
    private $delay = 0;

    /**
     * Window.
     *
     * @var bool
     * @since 1.0.0
     */
    private $new = false;

    /**
     * Constructor.
     *
     * @param string $url   Url
     * @param bool   $blank New window
     *
     * @since  1.0.0
     */
    public function __construct(string $url, bool $blank = false)
    {
        $this->uri = $url;
        $this->new = $blank;
    }

    /**
     * Set delay.
     *
     * @param int $delay Delay in ms
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDelay(int $delay) /* : void */
    {
        $this->delay = $delay;
    }

    /**
     * Set uri.
     *
     * @param string $uri Uri
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setUri(string $uri) /* : void */
    {
        $this->uri = $uri;
    }

    /**
     * Render message.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function serialize() : string
    {
        return $this->__toString();
    }

    /**
     * Render message.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function unserialize($raw) 
    {
        return '';
    }

    /**
     * Stringify.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * Generate message array.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function toArray() : array
    {
        return ['type' => self::TYPE, 'time' => $this->delay, 'uri' => $this->uri, 'new' => $this->new];
    }
}
