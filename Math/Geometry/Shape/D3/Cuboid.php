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
 * Cuboid shape.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Cuboid implements D3ShapeInterface
{

    /**
     * Volume
     *
     * @param float $a Edge
     * @param float $b Edge
     * @param float $h Height
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getVolume(float $a, float $b, float $h) : float
    {
        return $a * $b * $h;
    }

    /**
     * Surface area
     *
     * @param float $a Edge
     * @param float $b Edge
     * @param float $h Height
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSurface(float $a, float $b, float $h) : float
    {
        return 2 * ($a * $b + $a * $h + $b * $h);
    }
}
