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

namespace phpOMS\Utils\Git;

/**
 * Gray encoding class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Tag
{
    /**
     * Name.
     *
     * @var string
     * @since 1.0.0
     */
    private $name = '';

    /**
     * Message.
     *
     * @var string
     * @since 1.0.0
     */
    private $message = '';

    /**
     * Constructor
     *
     * @param string $name Tag name/version
     *
     * @since  1.0.0
     */
    public function __construct(string $name = '')
    {
        $this->name = escapeshellarg($name);
    }

    /**
     * Get tag message
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getMessage() : string
    {
        return $this->message;
    }

    /**
     * Set tag name
     *
     * @param string $message Tag message
     *
     * @since  1.0.0
     */
    public function setMessage(string $message) /* : void */
    {
        $this->message = escapeshellarg($message);
    }

    /**
     * Get tag name
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        return $this->name;
    }

}