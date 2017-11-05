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

namespace phpOMS\Math\Stochastic\Distribution;

/**
 * Geometric distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class GeometricDistribution
{
    /**
     * Get probability mass function.
     *
     * @param float $p
     * @param int   $k
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPmf(float $p, int $k) : float
    {
        return pow(1 - $p, $k - 1) * $p;
    }

    /**
     * Get cumulative distribution function.
     *
     * @param float $p
     * @param int   $k
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCdf(float $p, int $k) : float
    {
        return 1 - pow(1 - $p, $k);
    }

    /**
     * Get mode.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getMode() : int
    {
        return 1;
    }

    /**
     * Get expected value.
     *
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMean(float $p) : float
    {
        return 1 / $p;
    }

    /**
     * Get expected value.
     *
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMedian(float $p) : float
    {
        return ceil(-1 / (log(1 - $p, 2)));
    }

    /**
     * Get variance.
     *
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getVariance(float $p) : float
    {
        return (1 - $p) / $p ** 2;
    }

    /**
     * Get moment generating function.
     *
     * @param float $p
     * @param float $t
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMgf(float $p, float $t) : float
    {
        return $p * exp($t) / (1 - (1 - $p) * exp($t));
    }

    /**
     * Get skewness.
     *
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSkewness(float $lambda) : float
    {
        return (2 - $lambda) / sqrt(1 - $lambda);
    }

    /**
     * Get Ex. kurtosis.
     *
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getExKurtosis(float $lambda) : float
    {
        return 6 + $lambda ** 2 / (1 - $lambda);
    }

    public static function getRandom()
    {

    }
}
