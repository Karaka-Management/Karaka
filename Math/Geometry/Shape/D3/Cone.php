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
 * Cone shape.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Cone implements D3ShapeInterface
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
        return pi() * $r ** 2 * $h / 3;
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
        return pi() * $r * ($r + sqrt($h ** 2 + $r ** 2));
    }

    /**
     * Slant height
     *
     * @param float $r Radius
     * @param float $h Height
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSlantHeight(float $r, float $h) : float
    {
        return sqrt($h ** 2 + $r ** 2);
    }

    /**
     * Height
     *
     * @param float $V Volume
     * @param float $r Radius
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getHeightFromVolume(float $V, float $r) : float
    {
        return 3 * $V / (pi() * $r ** 2);
    }
}
