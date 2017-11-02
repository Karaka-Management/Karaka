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

namespace phpOMS\Math\Statistic\Forecast;

use phpOMS\Math\Functions\Functions;
use phpOMS\Math\Statistic\Average;
use phpOMS\Math\Statistic\MeasureOfDispersion;

/**
 * Basic forecast functions.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Error
{
    /**
     * Get the error of a forecast.
     *
     * @param float $observed   Dataset
     * @param float $forecasted Forecasted
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getForecastError(float $observed, float $forecasted) : float
    {
        return $observed - $forecasted;
    }

    /**
     * Get array of errors of a forecast.
     *
     * @param array $observed   Dataset
     * @param array $forecasted Forecasted
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getForecastErrorArray(array $observed, array $forecasted) : array
    {
        $errors = [];

        foreach ($forecasted as $key => $expected) {
            $errors[] = self::getForecastError($observed[$key], $expected);
        }

        return $errors;
    }

    /**
     * Get error percentage.
     *
     * @param float $error    Error
     * @param float $observed Dataset
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPercentageError(float $error, float $observed) : float
    {
        return $error / $observed;
    }

    /**
     * Get error percentages.
     *
     * @param array $errors   Errors
     * @param array $observed Dataset
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getPercentageErrorArray(array $errors, array $observed) : array
    {
        $percentages = [];

        foreach ($errors as $key => $error) {
            $percentages[] = self::getPercentageError($error, $observed[$key]);
        }

        return $percentages;
    }

    /**
     * Get mean absolute error (MAE).
     *
     * @param array $errors Errors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMeanAbsoulteError(array $errors) : float
    {
        return Average::arithmeticMean(Functions::abs($errors));
    }

    /**
     * Get mean squared error (MSE).
     *
     * @param array $errors Errors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMeanSquaredError(array $errors) : float
    {
        return Average::arithmeticMean(self::square($errors));
    }

    /**
     * Get root mean squared error (RMSE).
     *
     * @param array $errors Errors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRootMeanSquaredError(array $errors) : float
    {
        return sqrt(Average::arithmeticMean(self::square($errors)));
    }

    /**
     * Goodness of fit.
     *
     * Evaluating how well the observed data fit the linear regression model.
     *
     * @latex R^{2} = \frac{\sum \left(\hat{y}_{i} - \bar{y}\right)^2}{\sum \left(y_{i} - \bar{y}\right)^2}
     *
     * @param array $observed   Obersved y values
     * @param array $forecasted Forecasted y values
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCoefficientOfDetermination(array $observed, array $forecasted) : float
    {
        $countO = count($observed);
        $countF = count($forecasted);
        $sum1   = 0;
        $sum2   = 0;
        $meanY  = Average::arithmeticMean($observed);

        for ($i = 0; $i < $countF; $i++) {
            $sum1 += ($forecasted[$i] - $meanY) ** 2;
        }

        for ($i = 0; $i < $countO; $i++) {
            $sum2 += ($observed[$i] - $meanY) ** 2;
        }

        return $sum1 / $sum2;
    }

    /**
     * Get sum squared error (SSE).
     *
     * @param array $errors Errors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSumSquaredError(array $errors) : float
    {
        $error = 0.0;

        foreach ($errors as $e) {
            $error += $e * $e;
        }

        return $error;
    }

    /**
     * Get R Bar Squared
     *
     * @param float $R R
     * @param int $observations Amount of observations
     * @param int $predictors Amount of predictors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRBarSquared(float $R, int $observations, int $predictors) : float
    {
        return 1 - (1 - $R * ($observations - 1) / ($observations - $predictors - 1));
    }

    /**
     * Get Aike's information criterion (AIC)
     *
     * @param float $sse SSE
     * @param int $observations Amount of observations
     * @param int $predictors Amount of predictors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAkaikeInformationCriterion(float $sse, int $observations, int $predictors) : float
    {
        return $observations * log($sse / $observations) + 2 * ($predictors + 2);
    }

    /**
     * Get corrected Aike's information criterion (AIC)
     *
     * Correction for small amount of observations
     *
     * @param float $aic AIC
     * @param int $observations Amount of observations
     * @param int $predictors Amount of predictors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCorrectedAkaikeInformationCriterion(float $aic, int $observations, int $predictors) : float
    {
        return $aic + (2 * ($predictors + 2) * ($predictors + 3)) / ($observations - $predictors - 3);
    }

    /**
     * Get Bayesian information criterion (BIC)
     *
     * @param float $sse SSE
     * @param int $observations Amount of observations
     * @param int $predictors Amount of predictors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSchwarzBayesianInformationCriterion(float $sse, int $observations, int $predictors) : float
    {
        return $observations * log($sse / $observations) + ($predictors + 2) * log($observations);
    }

    /**
     * Get mean absolute percentage error (MAPE).
     *
     * @param array $observed   Dataset
     * @param array $forecasted Forecasted
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMeanAbsolutePercentageError(array $observed, array $forecasted) : float
    {
        return Average::arithmeticMean(Functions::abs(self::getPercentageErrorArray(self::getForecastErrorArray($observed, $forecasted), $observed)));
    }

    /**
     * Get mean absolute percentage error (sMAPE).
     *
     * @param array $observed   Dataset
     * @param array $forecasted Forecasted
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSymmetricMeanAbsolutePercentageError(array $observed, array $forecasted) : float
    {
        $error = [];

        foreach ($observed as $key => $value) {
            $error[] = 200 * abs($value - $forecasted[$key]) / ($value + $forecasted[$key]);
        }

        return Average::arithmeticMean($error);
    }

    /**
     * Square all values in array.
     *
     * @param array $values Values to square
     *
     * @return array
     *
     * @since  1.0.0
     *         todo: move to utils?! implement sqrt for array as well... could be usefull for others (e.g. matrix)
     */
    private static function square(array $values) : array
    {
        $squared = [];

        foreach ($values as $value) {
            $squared[] = $value * $value;
        }

        return $squared;
    }

    /**
     * Get cross sectional scaled errors (CSSE)
     *
     * @param array $errors   Errors
     * @param array $observed Dataset
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getCrossSectionalScaledErrorArray(array $errors, array $observed) : array
    {
        $scaled    = [];
        $deviation = MeasureOfDispersion::meanDeviation($observed);

        foreach ($errors as $error) {
            $error[] = $error / $deviation;
        }

        return $scaled;
    }

    /**
     * Get cross sectional scaled errors (CSSE)
     *
     * @param float $error    Errors
     * @param array $observed Dataset
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCrossSectionalScaledError(float $error, array $observed) : float
    {
        $mean = Average::arithmeticMean($observed);
        $sum  = 0.0;

        foreach ($observed as $value) {
            $sum += abs($value - $mean);
        }

        return $error / MeasureOfDispersion::meanDeviation($observed);
    }

    /**
     * Get mean absolute scaled error (MASE)
     *
     * @param array $scaledErrors Scaled errors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMeanAbsoluteScaledError(array $scaledErrors) : float
    {
        return Average::arithmeticMean(Functions::abs($scaledErrors));
    }

    /**
     * Get mean absolute scaled error (MASE)
     *
     * @param array $scaledErrors Scaled errors
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getMeanSquaredScaledError(array $scaledErrors) : float
    {
        return Average::arithmeticMean(self::square($scaledErrors));
    }

    /**
     * Get scaled error (SE)
     *
     * @param array $errors   Errors
     * @param array $observed Dataset
     * @param int   $m        Shift
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getScaledErrorArray(array $errors, array $observed, int $m = 1) : array
    {
        $scaled = [];
        $naive  = 1 / (count($observed) - $m) * self::getNaiveForecast($observed, $m);

        foreach ($errors as $error) {
            $error[] = $error / $naive;
        }

        return $scaled;
    }

    /**
     * Get scaled error (SE)
     *
     * @param float $error    Errors
     * @param array $observed Dataset
     * @param int   $m        Shift
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getScaledError(float $error, array $observed, int $m = 1) : float
    {
        return $error / (1 / (count($observed) - $m) * self::getNaiveForecast($observed, $m));
    }

    /**
     * Get naive forecast
     *
     * @param array $observed Dataset
     * @param int   $m        Shift
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function getNaiveForecast(array $observed, int $m = 1) : float
    {
        $sum   = 0.0;
        $count = count($observed);

        for ($i = 0 + $m; $i < $count; $i++) {
            $sum += abs($observed[$i] - $observed[$i - $m]);
        }

        return $sum;
    }
}