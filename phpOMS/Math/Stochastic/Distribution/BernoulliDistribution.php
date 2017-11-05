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
 * Bernulli distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class BernoulliDistribution
{
    /**
     * Get probability mass function.
     *
     * @param float $p
     * @param int   $k
     *
     * @return float
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function getPmf(float $p, int $k) : float
    {
        if ($k === 0) {
            return 1 - $p;
        } elseif ($k === 1) {
            return $p;
        } else {
            throw new \Exception('wrong parameter');
        }
    }

    /**
     * Get mode.
     *
     * @param float $p
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getMode(float $p) : int
    {
        if ($p === 0.5) {
            return 0;
        } elseif ($p > 0.5) {
            return 1;
        } else {
            return 0;
        }
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
        return $p;
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
        if ($p === 0.5) {
            return 0.5;
        } elseif ($p > 0.5) {
            return 1;
        } else {
            return 0;
        }
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
        return $p * (1 - $p);
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
        return (1 - $p) + $p * exp($t);
    }

    /**
     * Get skewness.
     *
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSkewness(float $p) : float
    {
        return (1 - 2 * $p) / sqrt($p * (1 - $p));
    }

    /**
     * Get Fisher information.
     *
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFisherInformation(float $p) : float
    {
        return 1 / ($p * (1 - $p));
    }

    /**
     * Get Ex. kurtosis.
     *
     * @param float $p
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getExKurtosis(float $p) : float
    {
        return (1 - 6 * $p * (1 - $p)) / ($p * (1 - $p));
    }

    public static function getRandom()
    {

    }
}
