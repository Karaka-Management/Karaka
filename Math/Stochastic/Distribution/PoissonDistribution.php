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

use phpOMS\Math\Functions\Functions;

/**
 * Well known functions class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class PoissonDistribution
{
    /**
     * Get density.
     *
     * Formula: e^(k * ln(lambda) - lambda - log(gamma(k+1))
     *
     * @param int   $k
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPmf(int $k, float $lambda) : float
    {
        return exp($k * log($lambda) - $lambda - log(Functions::getGammaInteger($k + 1)));
    }

    /**
     * Get cumulative distribution function.
     *
     * @param int   $k
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCdf(int $k, float $lambda) : float
    {
        $sum = 0.0;

        for ($i = 0; $i < $k + 1; $i++) {
            $sum += pow($lambda, $i) / Functions::fact($i);
        }

        return exp(-$lambda) * $sum;
    }

    /**
     * Get mode.
     *
     * @param float $lambda Lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMode(float $lambda) : float
    {
        return floor($lambda);
    }

    /**
     * Get expected value.
     *
     * @param float $lambda Lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMean(float $lambda) : float
    {
        return $lambda;
    }

    /**
     * Get expected value.
     *
     * @param float $lambda Lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMedian(float $lambda) : float
    {
        return floor($lambda + 1 / 3 - 0.02 / $lambda);
    }

    /**
     * Get variance.
     *
     * @param float $lambda Lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getVariance(float $lambda) : float
    {
        return $lambda;
    }

    /**
     * Get moment generating function.
     *
     * @param float $lambda
     * @param float $t
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMgf(float $lambda, float $t) : float
    {
        return exp($lambda * (exp($t) - 1));
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
        return pow($lambda, -1 / 2);
    }

    /**
     * Get Fisher information.
     *
     * @param float $lambda
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFisherInformation(float $lambda) : float
    {
        return pow($lambda, -1);
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
        return pow($lambda, -1);
    }

    public static function getRandom()
    {

    }
}
