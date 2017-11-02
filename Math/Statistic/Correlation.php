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

namespace phpOMS\Math\Statistic;

/**
 * Correlation.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Correlation
{

    /**
     * Calculage bravais person correlation coefficient.
     *
     * Example: ([4, 5, 9, 1, 3], [4, 5, 9, 1, 3])
     *
     * @param array $x Values
     * @param array $y Values
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function bravaisPersonCorrelationCoefficient(array $x, array $y) : float
    {
        return MeasureOfDispersion::empiricalCovariance($x, $y) / (MeasureOfDispersion::standardDeviation($x) * MeasureOfDispersion::standardDeviation($y));
    }

    /**
     * Get the autocorrelation coefficient (ACF).
     *
     * @param array $x Dataset
     * @param int   $k k-th coefficient
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function autocorrelationCoefficient(array $x, int $k = 0) : float
    {
        $squaredMeanDeviation = MeasureOfDispersion::squaredMeanDeviation($x);
        $mean                 = Average::arithmeticMean($x);
        $count                = count($x);
        $sum                  = 0.0;

        for ($i = $k + 1; $i < $count; $i++) {
            $sum += ($x[$i] - $mean) * ($x[$i - $k] - $mean);
        }

        return $sum / ($squaredMeanDeviation * count($x));
    }

    /**
     * Box Pierce test (portmanteau test).
     *
     * @param array $autocorrelations Autocorrelations
     * @param int   $h                Maximum leg considered
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function boxPierceTest(array $autocorrelations, int $h) : float
    {
        $sum = 0;
        for ($i = 0; $i < $h; $i++) {
            $sum += $autocorrelations[$i] ** 2;
        }

        return count($autocorrelations) * $sum;
    }

    /**
     * Box Pierce test (portmanteau test).
     *
     * @param array $autocorrelations Autocorrelations
     * @param int   $h                Maximum leg considered
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function ljungBoxTest(array $autocorrelations, int $h) : float
    {
        $count = count($autocorrelations);
        $sum   = 0;

        for ($i = 0; $i < $h; $i++) {
            $sum += 1 / ($count - $i) * $autocorrelations[$i] ** 2;
        }

        return $count * ($count + 2) * $sum;
    }
}
