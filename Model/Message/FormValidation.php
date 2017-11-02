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
 * FormValidation class.
 *
 * @category   Modules
 * @package    Model\Message
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class FormValidation implements \Serializable, ArrayableInterface, \JsonSerializable
{

    /**
     * Message type.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const TYPE = 'validation';

    /**
     * Form validation result.
     *
     * @var array
     * @since 1.0.0
     */
    private $validation = [];

    /**
     * Constructor.
     *
     * @param array $validation Invalid data
     *
     * @since  1.0.0
     */
    public function __construct(array $validation)
    {
        $this->validation = $validation;
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
     * @return string
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
        return ['type' => self::TYPE, 'validation' => $this->validation];
    }
}
