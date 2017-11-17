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

namespace phpOMS\Utils\Git;

/**
 * Gray encoding class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Branch
{
    /**
     * Name.
     *
     * @var string
     * @since 1.0.0
     */
    private $name = '';

    /**
     * Constructor
     *
     * @param string $name Branch name
     *
     * @since  1.0.0
     */
    public function __construct(string $name = '')
    {
        $this->setName($name);
    }

    /**
     * Get name
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set branch name
     *
     * @param string $name Branch name
     *
     * @since  1.0.0
     */
    public function setName(string $name) /* : void */
    {
        $this->name = $name;
    }
}