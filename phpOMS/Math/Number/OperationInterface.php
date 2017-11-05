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

namespace phpOMS\Math\Number;

/**
 * Basic operation interface.
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface OperationInterface
{
    /**
     * Add value.
     *
     * @param mixed $x Value
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function add($x);

    /**
     * Subtract value.
     *
     * @param mixed $x Value
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function sub($x);

    /**
     * Right multiplicate value.
     *
     * @param mixed $x Value
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function mult($x);

    /**
     * Right devision value.
     *
     * @param mixed $x Value
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function div($x);

    /**
     * Power of value.
     *
     * @param mixed $p Power
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function pow($p);

    /**
     * Abs of value.
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function abs();
}