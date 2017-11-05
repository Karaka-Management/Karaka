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
namespace phpOMS\Business\Finance\Forecasting;

use phpOMS\Math\Statistic\Average;

class ARIMA
{
    private $data = [];
    private $order = 0;

    public function __construct(array $data, int $order = 12)
    {
        $this->data = $data;
        $this->order = $order;

        if ($order !== 12 && $order !== 4) {
            throw new \Exception('ARIMA only supports quarterly and monthly decomposition');
        }
    }

    public function getDecomposition() : array
    {
        $iteration1 = $this->getIteration($this->data);
        $iteration2 = $this->getIteration($iteration1);
        $iteration3 = $this->getIteration($iteration2);

        return $iteration3;
    }

    private function getIteration(array $data) : array
    {
        $multiplicativeDecomposition = new ClassicalDecomposition($data, $this->order, ClassicalDecomposition::MULTIPLICATIVE);
        $tempDecomposition           = $multiplicativeDecomposition->getDecomposition();

        // 1
        $trendCycleComponent          = ClassicalDecomposition::computeTrendCycle($data, $this->order);
        $centeredRatios               = ClassicalDecomposition::computeDetrendedSeries($this->data, $trendCycleComponent, ClassicalDecomposition::MULTIPLICATIVE);
        $prelimSeasonalComponent      = Average::totalMovingAverage(Average::totalMovingAverage($centeredRatios, 3, null, true), 3, null, true);
        $prelimRemainder              = $this->getPrelimRemainder($centeredRatios, $prelimSeasonalComponent);
        $modifiedRemainder            = $this->removeOutliers($prelimRemainder, 0.5);
        $modifiedCenteredRatios       = $this->getModifiedCenteredRatios($prelimSeasonalComponent, $modifiedRemainder);
        $revisedSeasonalComponent     = Average::totalMovingAverage(Average::totalMovingAverage($modifiedCenteredRatios, 3, null, true), 3, null, true);
        $prelimSeasonalAdjustedSeries = $this->getPrelimSeasonalAdjustedSeries($revisedSeasonalComponent);
        $trendCycleComponent          = $this->getTrendCycleEstimation($prelimSeasonalAdjustedSeries);

        // 2
        $centeredRatios           = ClassicalDecomposition::computeDetrendedSeries($this->data, $trendCycleComponent, ClassicalDecomposition::MULTIPLICATIVE);
        $prelimSeasonalComponent  = Average::totalMovingAverage(Average::totalMovingAverage($centeredRatios, 5, null, true), 3, null, true);
        $prelimRemainder          = $this->getPrelimRemainder($centeredRatios, $prelimSeasonalComponent);
        $modifiedRemainder        = $this->removeOutliers($prelimRemainder, 0.5);
        $modifiedCenteredRatios   = $this->getModifiedCenteredRatios($prelimSeasonalComponent, $modifiedRemainder);
        $revisedSeasonalComponent = Average::totalMovingAverage(Average::totalMovingAverage($modifiedCenteredRatios, 5, null, true), 3, null, true);
        $seasonalAdjustedSeries   = $this->getSeasonalAdjustedSeries($revisedSeasonalComponent);

        $remainder         = $this->getRemainder($seasonalAdjustedSeries, $trendCycleComponent);
        $modifiedRemainder = $this->removeOutliers($remainder, 0.5);
        $modifiedData      = $this->getModifiedData($trendCycleComponent, $seasonalAdjustedSeries, $modifiedRemainder);

        return $modifiedData;
    }

    private function getPrelimRemainder(array $centeredRatios, array $prelimSeasonalComponent) : array
    {
        $remainder = [];
        $count     = count($prelimSeasonalComponent);

        for ($i = 0; $i < $count; $i++) {
            // +1 since 3x3 MA
            $remainder[] = $centeredRatios[$i + 1] / $prelimSeasonalComponent[$i];
        }

        return $remainder;
    }

    private function removeOutliers(array $data, float $deviation = 0.5) : array
    {
        $avg = Average::arithmeticMean($data);

        foreach ($data as $key => $value) {
            if ($value / $avg - 1 > $deviation) {
                $data[$key] = $avg;
            }
        }

        return $data;
    }

    private function getModifiedCenteredRatios(array $seasonal, array $remainder) : array
    {
        $centeredRatio = [];
        $count         = count($seasonal);

        for ($i = 0; $i < $count; $i++) {
            // +1 since 3x3 MA
            $centeredRatio[] = $remainder[$i + 1] * $seasonal[$i];
        }

        return $centeredRatio;
    }

    private function getTrendCycleEstimation(array $seasonal) : array
    {
        $count = count($seasonal);

        if ($count >= 12) {
            $weight = Average::MAH23;
        } elseif ($count >= 6) {
            $weight = Average::MAH13;
        } else {
            $weight = Average::MAH9;
        }

        // todo: implement

        return $seasonal;
    }

    private function getSeasonalAdjustedSeries(array $seasonal) : array
    {
        $adjusted = [];
        $count    = count($seasonal);
        $start    = ClassicalDecomposition::getStartOfDecomposition(count($this->data), $count);

        for ($i = 0; $i < $count; $i++) {
            $adjusted[] = $this->data[$start + $i] / $seasonal[$i];
        }

        return $adjusted;
    }

    private function getRemainder(array $seasonal, array $trendCycle)
    {
        $remainder = [];
        foreach ($seasonal as $key => $e) {
            $remainder = $e / $trendCycle[$key];
        }

        return $remainder;
    }

    private function getModifiedData(array $trendCycleComponent, array $seasonalAdjustedSeries, array $remainder) : array
    {
        $data  = [];
        $count = count($trendCycleComponent);

        for ($i = 0; $i < $count; $i++) {
            $data[] = $trendCycleComponent[$i] * $seasonalAdjustedSeries[$i] * $remainder[$i];
        }

        return $data;
    }
}