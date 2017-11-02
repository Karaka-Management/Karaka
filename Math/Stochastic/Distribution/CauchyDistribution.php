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

namespace phpOMS\Math\Stochastic\Distribution;

/**
 * Cauchy distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class CauchyDistribution
{
    /**
     * Get probability density function.
     *
     * @param float $x
     * @param float $x0
     * @param float $gamma
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPdf(float $x, float $x0, float $gamma) : float
    {
        return 1 / (pi() * $gamma * (1 + (($x - $x0) / $gamma) ** 2));
    }

    /**
     * Get cumulative distribution function.
     *
     * @param float $x
     * @param float $x0
     * @param float $gamma
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCdf(float $x, float $x0, float $gamma) : float
    {
        return 1 / pi() * atan(($x - $x0) / $gamma) + 0.5;
    }

    /**
     * Get mode.
     *
     * @param float $x0
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMode($x0) : float
    {
        return $x0;
    }

    /**
     * Get expected value.
     *
     * @param float $x0
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMedian(float $x0) : float
    {
        return $x0;
    }

    public static function getRandom()
    {

    }
}
