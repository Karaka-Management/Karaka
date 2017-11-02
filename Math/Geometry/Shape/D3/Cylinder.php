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

namespace phpOMS\Math\Geometry\Shape\D3;

/**
 * Cylinder shape.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Cylinder implements D3ShapeInterface
{

    /**
     * Volume
     *
     * @param float $r Radius
     * @param float $h Height
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getVolume(float $r, float $h) : float
    {
        return pi() * $r ** 2 * $h;
    }

    /**
     * Surface area
     *
     * @param float $r Radius
     * @param float $h Height
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSurface(float $r, float $h) : float
    {
        return 2 * pi() * ($r * $h + $r ** 2);
    }

    /**
     * Lateral surface area
     *
     * @param float $r Radius
     * @param float $h Height
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getLateralSurface(float $r, float $h) : float
    {
        return 2 * pi() * $r * $h;
    }
}
