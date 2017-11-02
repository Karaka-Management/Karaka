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
namespace phpOMS\Math\Statistic\Forecast\Regression;

use phpOMS\Math\Statistic\Average;
use phpOMS\Math\Statistic\Forecast\ForecastIntervalMultiplier;
use phpOMS\Math\Statistic\MeasureOfDispersion;
use phpOMS\Math\Matrix\Exception\InvalidDimensionException;

/**
 * Regression abstract class.
 *
 * @category   Framework
 * @package    phpOMS\Math\Statistic
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class RegressionAbstract
{
    /**
     * Get linear regression based on scatter plot.
     *
     * @latex y = b_{0} + b_{1} \cdot x
     *
     * @param array $x Obersved x values
     * @param array $y Observed y values
     *
     * @return array [b0 => ?, b1 => ?]
     *
     * @throws InvalidDimensionException Throws this exception if the dimension of both arrays is not equal.
     *
     * @since  1.0.0
     */
    public static function getRegression(array $x, array $y) : array
    {
        if (count($x) !== count($y)) {
            throw new InvalidDimensionException(count($x) . 'x' . count($y));
        }

        $b1 = self::getBeta1($x, $y);

        return ['b0' => self::getBeta0($x, $y, $b1), 'b1' => $b1];
    }

    /**
     * Standard error of the regression.
     *
     * Used in order to evaluate the performance of the linear regression
     *
     * @latex s_{e} = \sqrt{\frac{1}{N - 2}\sum_{i = 1}^{N} e_{i}^{2}}
     *
     * @param array $errors Errors (e = y - y_forecasted)
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getStandardErrorOfRegression(array $errors) : float
    {
        $count = count($errors);
        $sum   = 0.0;

        for ($i = 0; $i < $count; $i++) {
            $sum += $errors[$i] ** 2;
        }

        // todo: could this be - 1 depending on the different definitions?!
        return sqrt(1 / ($count - 2) * $sum);
    }

    /**
     * Get predictional interval for linear regression.
     *
     * @param float $forecasted Forecasted y value
     * @param array $x          observex x values
     * @param array $errors     Errors for y values (y - y_forecasted)
     * @param float $multiplier Multiplier for interval
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getPredictionInterval(float $forecasted, array $x, array $errors, float $multiplier = ForecastIntervalMultiplier::P_95) : array
    {
        $count = count($x);
        $meanX = Average::arithmeticMean($x);
        $sum   = 0.0;

        for ($i = 0; $i < $count; $i++) {
            $sum += ($x[$i] - $meanX) ** 2;
        }

        $interval = $multiplier * self::getStandardErrorOfRegression($errors) * sqrt(1 + 1 / $count + $sum / (($count - 1) * MeasureOfDispersion::standardDeviation($x) ** 2));

        return [$forecasted - $interval, $forecasted + $interval];
    }

    /**
     * Get linear regression parameter beta 1.
     *
     * @latex \beta_{1} = \frac{\sum_{i=1}^{N} \left(y_{i} - \bar{y}\right)\left(x_{i} - \bar{x}\right)}{\sum_{i=1}^{N} \left(x_{i} - \bar{x}\right)^{2}}
     *
     * @param array $x Obersved x values
     * @param array $y Observed y values
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function getBeta1(array $x, array $y) : float
    {
        $count = count($x);
        $meanX = Average::arithmeticMean($x);
        $meanY = Average::arithmeticMean($y);

        $sum1 = 0;
        $sum2 = 0;

        for ($i = 0; $i < $count; $i++) {
            $sum1 += ($y[$i] - $meanY) * ($x[$i] - $meanX);
            $sum2 += ($x[$i] - $meanX) ** 2;
        }

        return $sum1 / $sum2;
    }

    /**
     * Get linear regression parameter beta 0.
     *
     * @latex \beta_{0} = \bar{x} - b_{1} \cdot \bar{x}
     *
     * @param array $x  Obersved x values
     * @param array $y  Observed y values
     * @param float $b1 Beta 1
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function getBeta0(array $x, array $y, float $b1) : float
    {
        return Average::arithmeticMean($y) - $b1 * Average::arithmeticMean($x);
    }

    /**
     * Get slope
     *
     * @param float $b1 Beta 1
     * @param float $x  Obersved x values
     * @param float $y  Observed y values
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSlope(float $b1, float $y, float $x) : float
    {
        return 0.0;
    }

    /**
     * Get elasticity
     *
     * @param float $b1 Beta 1
     * @param float $x  Obersved x values
     * @param float $y  Observed y values
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getElasticity(float $b1, float $y, float $x): float
    {
        return 0.0;
    }
}