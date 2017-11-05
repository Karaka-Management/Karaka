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

use phpOMS\Math\Functions\Functions;

/**
 * Binomial distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class BinomialDistribution
{

    /**
     * Get mode.
     *
     * @param int   $n
     * @param float $p
     *
     * @return float
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function getMode(int $n, float $p) : float
    {
        if (($temp = ($n + 1) * $p) === 0 || !is_int($temp)) {
            return floor($temp);
        } elseif ($temp >= 1 && $temp <= $n) {
            return $temp;
        } elseif ($temp === $n + 1) {
            return $n;
        } else {
            throw new \Exception('Unexpected Values');
        }
    }

    /**
     * Get moment generating function.
     *
     * @param int   $n
     * @param float $t
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMgf(int $n, float $t, float $p) : float
    {
        return pow(1 - $p + $p * exp($t), $n);
    }

    /**
     * Get skewness.
     *
     * @param int   $n
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSkewness(int $n, float $p) : float
    {
        return (1 - 2 * $p) / sqrt($n * $p * (1 - $p));
    }

    /**
     * Get Fisher information.
     *
     * @param int   $n
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFisherInformation(int $n, float $p) : float
    {
        return $n / ($p * (1 - $p));
    }

    /**
     * Get Ex. kurtosis.
     *
     * @param int   $n
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getExKurtosis(int $n, float $p) : float
    {
        return (1 - 6 * $p * (1 - $p)) / ($n * $p * (1 - $p));
    }

    /**
     * Get cumulative distribution function.
     *
     * @param int   $n
     * @param int   $x
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCdf(int $n, int $x, float $p) : float
    {
        $sum = 0.0;

        for ($i = 0; $i < $x; $i++) {
            $sum += self::getPmf($n, $i, $p);
        }

        return $sum;
    }

    /**
     * Get probability mass function.
     *
     * Formula: C(n, k) * p^k * (1-p)^(n-k)
     *
     * @param int   $n
     * @param int   $k
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPmf(int $n, int $k, float $p) : float
    {
        return Functions::binomialCoefficient($n, $k) * pow($p, $k) * pow(1 - $p, $n - $k);
    }

    /**
     * Get expected value.
     *
     * @param int   $n
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMedian(int $n, float $p) : float
    {
        return floor($n * $p);
    }

    /**
     * Get expected value.
     *
     * @param int   $n
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMean(int $n, float $p) : float
    {
        return $n * $p;
    }

    /**
     * Get variance.
     *
     * @param int   $n
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getVariance(int $n, float $p) : float
    {
        return $n * $p * (1 - $p);
    }

    public static function getRandom()
    {

    }
}
