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

/**
 * Address type enum.
 *
 * @category   Framework
 * @package    phpOMS\Datatypes
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Forecasts
{
    /**
     * Get forecast/prediction interval.
     *
     * @param float $forecast Forecast value
     * @param float $standardDeviation Standard Deviation of forecast
     * @param float $interval Forecast multiplier for prediction intervals
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getForecastInteval(float $forecast, float $standardDeviation, float $interval = ForecastIntervalMultiplier::P_95) : array
    {
        return [$forecast - $interval * $standardDeviation, $forecast + $interval * $standardDeviation];
    }
}