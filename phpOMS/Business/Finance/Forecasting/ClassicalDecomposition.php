<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Business\Finance\Forecasting
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Business\Finance\Forecasting;

use phpOMS\Math\Statistic\Average;

/**
 * Classical decomposition class.
 *
 * This can be used to simplify time series patterns for forecasts.
 *
 * @category   Framework
 * @package    phpOMS\Business\Finance\Forecasting
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @see        https://www.otexts.org/fpp/6/1
 * @since      1.0.0
 */
class ClassicalDecomposition
{
    /**
     * Decomposition mode.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const ADDITIVE = 0;

    /**
     * Decomposition mode.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MULTIPLICATIVE = 1;

    /**
     * Decomposition mode.
     *
     * @var int
     * @since 1.0.0
     */
    private $mode = self::ADDITIVE;

    /**
     * Raw data.
     *
     * @var array
     * @since 1.0.0
     */
    private $data = [];

    /**
     * Order or seasonal period.
     *
     * @var int
     * @since 1.0.0
     */
    private $order = 0;

    /**
     * Raw data size.
     *
     * @var int
     * @since 1.0.0
     */
    private $dataSize = 0;

    /**
     * Constructor.
     *
     * @param array $data  Historic data
     * @param int   $order Seasonal period (e.g. 4 = quarterly, 12 = monthly, 7 = weekly pattern in daily data)
     * @param int   $mode  Decomposition mode
     *
     * @since  1.0.0
     */
    public function __construct(array $data, int $order, int $mode = self::ADDITIVE)
    {
        $this->mode  = $mode;
        $this->data  = $data;
        $this->order = $order;

        $this->dataSize = count($data);
    }

    /**
     * Get decomposition.
     *
     * @return array Returns an array containing the trend cycle component, detrended series, seasonal component and remainder component.
     *
     * @since  1.0.0
     */
    public function getDecomposition() : array
    {
        $trendCycleComponent = self::computeTrendCycle($this->data, $this->order);
        $detrendedSeries     = self::computeDetrendedSeries($this->data, $trendCycleComponent, $this->mode);
        $seasonalComponent   = $this->computeSeasonalComponent($detrendedSeries, $this->order);
        $remainderComponent  = self::computeRemainderComponent($this->data, $trendCycleComponent, $seasonalComponent, $this->mode);

        return [
            'trendCycleComponent' => $trendCycleComponent,
            'detrendedSeries'     => $detrendedSeries,
            'seasonalComponent'   => $seasonalComponent,
            'remainderComponent'  => $remainderComponent,
        ];
    }

    /**
     * Calculate trend cycle
     *
     * @param array $data  Data to analyze
     * @param int   $order Seasonal period (e.g. 4 = quarterly, 12 = monthly, 7 = weekly pattern in daily data)
     *
     * @return array Total moving average 2 x m-MA
     *
     * @since  1.0.0
     */
    public static function computeTrendCycle(array $data, int $order) : array
    {
        $mMA = Average::totalMovingAverage($data, $order, null, true);

        return $order % 2 === 0 ? Average::totalMovingAverage($mMA, $order, null, true) : $mMA;
    }

    /**
     * Calculate detrended series
     *
     * @param array $data  Data to analyze
     * @param array $trendCycleComponent Trend cycle component
     * @param int $mode Detrend mode
     *
     * @return array Detrended series / seasonal normalized data
     *
     * @since  1.0.0
     */
    public static function computeDetrendedSeries(array $data, array $trendCycleComponent, int $mode) : array
    {
        $detrended = [];
        $count     = count($trendCycleComponent);
        $start     = self::getStartOfDecomposition(count($data), $count);

        for ($i = 0; $i < $count; $i++) {
            $detrended[] = $mode === self::ADDITIVE ? $data[$start + $i] - $trendCycleComponent[$i] : $data[$start + $i] / $trendCycleComponent[$i];
        }

        return $detrended;
    }

    /**
     * Calculate the data start point for the decomposition
     *
     * By using averaging methods some initial data get's incorporated into the average which reduces the data points.
     *
     * @param int $dataSize Original data size
     * @param int $trendCycleComponents Trend cycle component size
     *
     * @return int New data start index
     *
     * @since  1.0.0
     */
    public static function getStartOfDecomposition(int $dataSize, int $trendCycleComponents) : int
    {
        return ($dataSize - $trendCycleComponents) / 2;
    }

    /**
     * Calculate the seasonal component
     *
     * Average of the detrended values for every month, quarter, day etc.
     *
     * @param array $detrendedSeries Detrended series
     * @param int $order Seasonal period (e.g. 4 = quarterly, 12 = monthly, 7 = weekly pattern in daily data)
     *
     * @return array
     *
     * @since  1.0.0
     */
    private function computeSeasonalComponent(array $detrendedSeries, int $order) : array
    {
        $seasonalComponent = [];
        $count             = count($detrendedSeries);

        for ($i = 0; $i < $order; $i++) {
            $temp = [];

            for ($j = $i; $j < $count; $j += $order) {
                $temp[] = $detrendedSeries[$j];
            }

            $seasonalComponent[] = Average::arithmeticMean($temp);
        }

        return $seasonalComponent;
    }

    /**
     * Calculate the remainder component or error
     *
     * @param array $data Raw data
     * @param array $trendCycleComponent Trend cycle component
     * @param array $seasonalComponent Seasonal component
     * @param int $mode Detrend mode
     *
     * @return array All remainders or absolute errors
     *
     * @since  1.0.0
     */
    public static function computeRemainderComponent(array $data, array $trendCycleComponent, array $seasonalComponent, int $mode = self::ADDITIVE) : array
    {
        $dataSize           = count($data);
        $remainderComponent = [];
        $count              = count($trendCycleComponent);
        $start              = self::getStartOfDecomposition($dataSize, $count);
        $seasons            = count($seasonalComponent);

        for ($i = 0; $i < $count; $i++) {
            $remainderComponent[] = $mode === self::ADDITIVE ? $data[$start + $i] - $trendCycleComponent[$i] - $seasonalComponent[$i % $seasons] : $data[$start + $i] / ($trendCycleComponent[$i] * $seasonalComponent[$i % $seasons]);
        }

        return $remainderComponent;
    }
}