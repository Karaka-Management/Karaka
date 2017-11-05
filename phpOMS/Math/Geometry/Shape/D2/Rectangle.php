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

namespace phpOMS\Math\Geometry\Shape\D2;

/**
 * Rectangle shape.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Rectangle implements D2ShapeInterface
{

    /**
     * Area
     *
     * @param float $a Edge
     * @param float $b Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSurface(float $a, float $b) : float
    {
        return $a * $b;
    }

    /**
     * Perimeter
     *
     * @param float $a Edge
     * @param float $b Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPerimeter(float $a, float $b) : float
    {
        return 2 * ($a + $b);
    }

    /**
     * Diagonal
     *
     * @param float $a Edge
     * @param float $b Edge
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDiagonal(float $a, float $b) : float
    {
        return sqrt($a * $a + $b * $b);
    }
}
