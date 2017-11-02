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
 * Normal distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class NormalDistribution
{

    /**
     * Get probability density function.
     *
     * @param float $x
     * @param float $mu
     * @param float $sig
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPdf(float $x, float $mu, float $sig) : float
    {
        return 1 / ($sig * sqrt(2 * pi())) * exp(-($x - $mu) ** 2 / (2 * $sig ** 2));
    }

    /**
     * Get mode.
     *
     * @param float $mu
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMode(float $mu) : float
    {
        return $mu;
    }

    /**
     * Get expected value.
     *
     * @param float $mu
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMean(float $mu) : float
    {
        return $mu;
    }

    /**
     * Get expected value.
     *
     * @param float $mu
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMedian(float $mu) : float
    {
        return $mu;
    }

    /**
     * Get variance.
     *
     * @param float $sig
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getVariance(float $sig) : float
    {
        return $sig ** 2;
    }

    /**
     * Get moment generating function.
     *
     * @param float $t
     * @param float $mu
     * @param float $sig
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMgf(float $t, float $mu, float $sig) : float
    {
        return exp($mu * $t + ($sig ** 2 * $t ** 2) / 2);
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
        return 0;
    }

    /**
     * Get Fisher information.
     *
     * @param float $sig
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFisherInformation(float $sig) : float
    {
        return [[1 / $sig ** 2, 0], [0, 1 / (2 * $sig ** 4)]];
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
        return 0;
    }

    public static function getRandom()
    {

    }
}
