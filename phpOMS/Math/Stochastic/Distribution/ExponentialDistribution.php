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
 * Exponential distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ExponentialDistribution
{
    /**
     * Get probability density function.
     *
     * @param float $x
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPdf(float $x, float $lambda) : float
    {
        return $x >= 0 ? $lambda * exp(-$lambda * $x) : 0;
    }

    /**
     * Get cumulative distribution function.
     *
     * @param float $x
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCdf(float $x, float $lambda) : float
    {
        return $x >= 0 ? 1 - exp($lambda * $x) : 0;
    }

    /**
     * Get mode.
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMode() : float
    {
        return 0;
    }

    /**
     * Get expected value.
     *
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMean(float $lambda) : float
    {
        return 1 / $lambda;
    }

    /**
     * Get expected value.
     *
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMedian(float $lambda) : float
    {
        return 1 / $lambda;
    }

    /**
     * Get variance.
     *
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getVariance(float $lambda) : float
    {
        return pow($lambda, -2);
    }

    /**
     * Get moment generating function.
     *
     * @param float $t
     * @param float $lambda
     *
     * @return float
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function getMgf(float $t, float $lambda) : float
    {
        if ($t >= $lambda) {
            throw new \Exception('Out of bounds');
        }

        return $lambda / ($lambda - $t);
    }

    /**
     * Get skewness.
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSkewness() : float
    {
        return 2;
    }

    /**
     * Get Ex. kurtosis.
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getExKurtosis() : float
    {
        return 6;
    }

    public static function getRandom()
    {

    }
}
