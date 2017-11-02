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

namespace phpOMS\Math\Geometry\Shape\D2;

/**
 * Trapezoid shape.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Trapezoid implements D2ShapeInterface
{

    /**
     * Area
     *
     *       --- a ----
     *     /  |        \
     *    c   h         d
     *  /     |          \
     * -------- b ---------
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
        return ($a + $b) / 2 * $h;
    }

    /**
     * Perimeter
     *
     *       --- a ----
     *     /  |        \
     *    c   h         d
     *  /     |          \
     * -------- b ---------
     *
     * @param float $a Edge
     * @param float $b Edge
     * @param float $c Edge
     * @param float $d Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPerimeter(float $a, float $b, float $c, float $d) : float
    {
        return $a + $b + $c + $d;
    }

    /**
     * Height
     *
     *       --- a ----
     *     /  |        \
     *    c   h         d
     *  /     |          \
     * -------- b ---------
     *
     * @param float $area Area
     * @param float $a    Edge
     * @param float $b    Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getHeight(float $area, float $a, float $b) : float
    {
        return 2 * $area / ($a + $b);
    }

    /**
     * A
     *
     *       --- a ----
     *     /  |        \
     *    c   h         d
     *  /     |          \
     * -------- b ---------
     *
     * @param float $area Area
     * @param float $h    Height
     * @param float $b    Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getA(float $area, float $h, float $b) : float
    {
        return 2 * $area / $h - $b;
    }

    /**
     * B
     *
     *       --- a ----
     *     /  |        \
     *    c   h         d
     *  /     |          \
     * -------- b ---------
     *
     * @param float $area Area
     * @param float $h    Height
     * @param float $a    Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getB(float $area, float $h, float $a) : float
    {
        return 2 * $area / $h - $a;
    }

    /**
     * C
     *
     *       --- a ----
     *     /  |        \
     *    c   h         d
     *  /     |          \
     * -------- b ---------
     *
     * @param float $perimeter Perimeter
     * @param float $a         Edge
     * @param float $b         Edge
     * @param float $d         Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getC(float $perimeter, float $a, float $b, float $d) : float
    {
        return $perimeter - $a - $b - $d;
    }

    /**
     * D
     *
     *       --- a ----
     *     /  |        \
     *    c   h         d
     *  /     |          \
     * -------- b ---------
     *
     * @param float $perimeter Perimeter
     * @param float $a         Edge
     * @param float $b         Edge
     * @param float $c         Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getD(float $perimeter, float $a, float $b, float $c) : float
    {
        return $perimeter - $a - $b - $c;
    }
}
