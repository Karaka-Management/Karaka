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
 * Reload class.
 *
 * @category   Modules
 * @package    Model\Message
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Reload implements \Serializable, ArrayableInterface, \JsonSerializable
{

    /**
     * Message type.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const TYPE = 'reload';

    /**
     * Delay in ms.
     *
     * @var int
     * @since 1.0.0
     */
    private $delay = 0;

    /**
     * Constructor.
     *
     * @param int $delay Delay in ms
     *
     * @since  1.0.0
     */
    public function __construct(int $delay = 0)
    {
        $this->delay = $delay;
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
        return ['type' => self::TYPE, 'time' => $this->delay];
    }

    /**
     * Generate message json.
     *
     * @param int $option
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function jsonSerialize(int $option = 0)
    {
        return $this->toArray();
    }
}
