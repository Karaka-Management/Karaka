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

namespace phpOMS\Contract;

/**
 * Defines an object arrayable.
 *
 * This stands always in combination with a jsonable instance.
 *
 * @category   Framework
 * @package    phpOMS\Contract
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface ArrayableInterface
{

    /**
     * Get the instance as an array.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function toArray() : array;

}
