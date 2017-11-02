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

namespace phpOMS\Pattern;

/**
 * Singleton interface (pattern).
 *
 * @category   Pattern
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface Singleton
{

    /**
     * Get instance.
     *
     * @return Singleton
     *
     * @since  1.0.0
     */
    public static function getInstance() : Singleton;

    /**
     * Overwriting clone in order to maintain singleton pattern.
     *
     * @return self
     *
     * @since  1.0.0
     */
    public function __clone();
}
