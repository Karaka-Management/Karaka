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

namespace phpOMS\Business\Finance\Forecasting\ExponentialSmoothing;

use phpOMS\Business\Finance\Forecasting\SmoothingType;
use phpOMS\Math\Statistic\Average;
use phpOMS\Math\Statistic\Forecast\Error;

class ExponentialSmoothing
{
    private $data = [];

    private $errors = [];

    private $rmse = 0.0;

    private $mse = 0.0;

    private $mae = 0.0;

    private $sse = 0.0;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getRMSE() : float
    {
        return $this->rmse;
    }

    public function getMSE() : float
    {
        return $this->mse;
    }

    public function getMAE() : float
    {
        return $this->mae;
    }

    public function getSSE() : float
    {
        return $this->sse;
    }

    public function getErrors() : array
    {
        return $this->errors;
    }

    public function getForecast(int $future, int $trendType = TrendType::NONE, int $seasonalType = SeasonalType::NONE, int $cycle = 12, float $damping = 1) : array 
    {
        $this->rmse = PHP_INT_MAX;

        if ($trendType === TrendType::ALL || $seasonalType === SeasonalType::ALL) {
            $trends = [$trendType];
            if ($trendType === TrendType::ALL) {
                $trends = [TrendType::NONE, TrendType::ADDITIVE, TrendType::MULTIPLICATIVE];
            }

            $seasonals = [$seasonalType];
            if ($seasonalType === SeasonalType::ALL) {
                $seasonals = [SeasonalType::NONE, SeasonalType::ADDITIVE, SeasonalType::MULTIPLICATIVE];
            }

            $forecast = [];
            $bestError = PHP_INT_MAX;
            foreach ($trends as $trend) {
                foreach ($seasonals as $seasonal) {
                    $tempForecast = $this->getForecast($future, $trend, $seasonal, $cycle, $damping);

                    if ($this->rmse < $bestError) {
                        $bestError = $this->rmse;
                        $forecast = $tempForecast;
                    }
                }
            }

            return $forecast;
        } elseif ($trendType === TrendType::NONE && $seasonalType === SeasonalType::NONE) {
            return $this->getNoneNone($future);
        } elseif ($trendType === TrendType::NONE && $seasonalType === SeasonalType::ADDITIVE) {
            return $this->getNoneAdditive($future, $cycle);
        } elseif ($trendType === TrendType::NONE && $seasonalType === SeasonalType::MULTIPLICATIVE) {
            return $this->getNoneMultiplicative($future, $cycle);
        } elseif ($trendType === TrendType::ADDITIVE && $seasonalType === SeasonalType::NONE) {
            return $this->getAdditiveNone($future, $damping);
        } elseif ($trendType === TrendType::ADDITIVE && $seasonalType === SeasonalType::ADDITIVE) {
            return $this->getAdditiveAdditive($future, $cycle, $damping);
        } elseif ($trendType === TrendType::ADDITIVE && $seasonalType === SeasonalType::MULTIPLICATIVE) {
            return $this->getAdditiveMultiplicative($future, $cycle, $damping);
        } elseif ($trendType === TrendType::MULTIPLICATIVE && $seasonalType === SeasonalType::NONE) {
            return $this->getMultiplicativeNone($future, $damping);
        } elseif ($trendType === TrendType::MULTIPLICATIVE && $seasonalType === SeasonalType::ADDITIVE) {
            return $this->getMultiplicativeAdditive($future, $cycle, $damping);
        } elseif ($trendType === TrendType::MULTIPLICATIVE && $seasonalType === SeasonalType::MULTIPLICATIVE) {
            return $this->getMultiplicativeMultiplicative($future, $cycle, $damping);
        }

        throw new \Exception();
    }

    private function dampingSum(float $damping, int $length) : float
    {
        if (abs($damping - 1) < 0.001) {
            return $length;
        }

        $sum = 0;
        for ($i = 0; $i < $length; $i++) {
            $sum += pow($damping, $i);
        }

        return $sum;
    }

    public function getNoneNone(int $future) : array 
    {
        $level = [$this->data[0]];
        $dataLength = count($this->data) + $future;
        $forecast = [];

        $alpha = 0.00;
        while ($alpha < 1) {
            $error = [];
            $tempForecast = [];

            for ($i = 1; $i < $dataLength; $i++) {
                $level[$i] = $alpha * ($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) + (1 - $alpha) * $level[$i - 1];

                $tempForecast[$i] = $level[$i];
                $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
            }

            $tempRMSE = Error::getRootMeanSquaredError($error);
            
            if ($tempRMSE < $this->rmse) {
                $this->rmse = $tempRMSE;
                $forecast   = $tempForecast;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getNoneAdditive(int $future, int $cycle) : array 
    {
        $level = [$this->data[0]];
        $dataLength = count($this->data) + $future;
        $forecast = [];
        $seasonal = [];

        for ($i = 1; $i < $cycle + 1; $i++) {
            $seasonal[$i] = $this->data[$i - 1] - $level[0];
        }

        $alpha = 0.00;
        while ($alpha < 1) {
            $gamma = 0.00;

            while ($gamma < 1) {
                $gamma_ = $gamma * (1 - $alpha);
                $error = [];
                $tempForecast = [];

                for ($i = 1; $i < $dataLength; $i++) {
                    $hm = (int) floor(($i - 1) % $cycle) + 1;

                    $level[$i] = $alpha * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) - $seasonal[$i]) + (1 - $alpha) * $level[$i - 1];
                    $seasonal[$i + $cycle] = $gamma_ * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) - $level[$i - 1]) + (1 - $gamma_) * $seasonal[$i];

                    $tempForecast[$i] = $level[$i] + $seasonal[$i + $hm];
                    $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                }
                    
                $tempRMSE = Error::getRootMeanSquaredError($error);
            
                if ($tempRMSE < $this->rmse) {
                    $this->rmse = $tempRMSE;
                    $forecast   = $tempForecast;
                }
       
                $gamma += 0.01;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getNoneMultiplicative(int $future, int $cycle) : array 
    {
        $level = [$this->data[0]];
        $dataLength = count($this->data) + $future;
        $forecast = [];
        $seasonal = [];

        for ($i = 1; $i < $cycle + 1; $i++) {
            $seasonal[$i] = $this->data[$i] / $level[0];
        }

        $alpha = 0.00;
        while ($alpha < 1) {
            $gamma = 0.00;

            while ($gamma < 1) {
                $gamma_ = $gamma * (1 - $alpha);
                $error = [];
                $tempForecast = [];

                for ($i = 1; $i < $dataLength; $i++) {
                    $hm = (int) floor(($i - 1) % $cycle) + 1;

                    $level[$i] = $alpha * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) / $seasonal[$i]) + (1 - $alpha) * $level[$i - 1];
                    $seasonal[$i + $cycle] = $gamma_ * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) / $level[$i - 1]) + (1 - $gamma_) * $seasonal[$i];

                    $tempForecast[$i] = $level[$i] + $seasonal[$i + $hm];
                    $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                }
                    
                $tempRMSE = Error::getRootMeanSquaredError($error);
            
                if ($tempRMSE < $this->rmse) {
                    $this->rmse = $tempRMSE;
                    $forecast   = $tempForecast;
                }
       
                $gamma += 0.01;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getAdditiveNone(int $future, float $damping) : array 
    {
        $level = [$this->data[0]];
        $trend = [$this->data[1] - $this->data[0]];
        $dataLength = count($this->data) + $future;
        $forecast = [];

        $alpha = 0.00;
        while ($alpha < 1) {
            $beta = 0.00;

            while ($beta < 1) {
                $error = [];
                $tempForecast = [];

                for ($i = 1; $i < $dataLength; $i++) {
                    $level[$i] = $alpha * ($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) + (1 - $alpha) * ($level[$i - 1] + $damping * $trend[$i - 1]);
                    $trend[$i] = $beta * ($level[$i] - $level[$i - 1]) + (1 - $beta) * $damping * $trend[$i - 1];

                    $tempForecast[$i] = $level[$i] + $this->dampingSum($damping, $i) * $trend[$i];
                    $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                }
                    
                $tempRMSE = Error::getRootMeanSquaredError($error);
            
                if ($tempRMSE < $this->rmse) {
                    $this->rmse = $tempRMSE;
                    $forecast   = $tempForecast;
                }
       
                $beta += 0.01;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getAdditiveAdditive(int $future, int $cycle, float $damping) : array 
    {
        $level = [1 / $cycle * array_sum(array_slice($this->data, 0, $cycle))];
        $trend = [1 / $cycle];
        $dataLength = count($this->data) + $future;
        $forecast = [];
        $seasonal = [];

        $sum = 0;
        for ($i = 1; $i < $cycle + 1; $i++) {
            $sum += ($this->data[$cycle] - $this->data[$i]) / $cycle;
        }

        $trend[0] *= $sum;

        for ($i = 1; $i < $cycle + 1; $i++) {
            $seasonal[$i] = $this->data[$i - 1] - $level[0];
        }

        $alpha = 0.00;
        while ($alpha < 1) {
            $beta = 0.00;

            while ($beta < 1) {
                $gamma = 0.00;

                while ($gamma < 1) {
                    $gamma_ = $gamma * (1 - $alpha);
                    $error = [];
                    $tempForecast = [];

                    for ($i = 1; $i < $dataLength; $i++) {
                        $hm = (int) floor(($i - 1) % $cycle) + 1;

                        $level[$i] = $alpha * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) - $seasonal[$i]) + (1 - $alpha) * ($level[$i - 1] + $damping * $trend[$i - 1]);
                        $trend[$i] = $beta * ($level[$i] - $level[$i - 1]) + (1 - $beta) * $damping * $trend[$i - 1];
                        $seasonal[$i + $cycle] = $gamma_ * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) - $level[$i - 1]) + (1 - $gamma_) * $seasonal[$i];

                        $tempForecast[$i] = $level[$i] + $this->dampingSum($damping, $i) * $trend[$i] + $seasonal[$i + $hm];
                        $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                    }

                    $tempRMSE = Error::getRootMeanSquaredError($error);
            
                    if ($tempRMSE < $this->rmse) {
                        $this->rmse = $tempRMSE;
                        $forecast   = $tempForecast;
                    }

                    $gamma += 0.01;
                }

                $beta += 0.01;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getAdditiveMultiplicative(int $future, int $cycle, float $damping) : array 
    {
        $level = [1 / $cycle * array_sum(array_slice($this->data, 0, $cycle))];
        $trend = [1 / $cycle];
        $dataLength = count($this->data) + $future;
        $forecast = [];
        $seasonal = [];
        $gamma_ = $gamma * (1 - $alpha);

        $sum = 0;
        for ($i = 1; $i < $cycle + 1; $i++) {
            $sum += ($this->data[$cycle] - $this->data[$i]) / $cycle;
        }

        $trend[0] *= $sum;

        for ($i = 1; $i < $cycle + 1; $i++) {
            $seasonal[$i] = $this->data[$i] / $level[0];
        }

        $alpha = 0.00;
        while ($alpha < 1) {
            $beta = 0.00;

            while ($beta < 1) {
                $gamma = 0.00;

                while ($gamma < 1) {
                    $gamma_ = $gamma * (1 - $alpha);
                    $error = [];
                    $tempForecast = [];

                    for ($i = 1; $i < $dataLength; $i++) {
                        $hm = (int) floor(($i - 1) % $cycle) + 1;

                        $level[$i] = $alpha * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) / $seasonal[$i]) + (1 - $alpha) * ($level[$i - 1] + $damping * $trend[$i - 1]);
                        $trend[$i] = $beta * ($level[$i] - $level[$i - 1]) + (1 - $beta) * $damping * $trend[$i - 1];
                        $seasonal[$i + $cycle] = $gamma_ * ($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) / ($level[$i - 1] + $damping * $trend[$i - 1]) + (1 - $gamma_) * $seasonal[$i];

                        $tempForecast[] = ($level[$i] + $this->dampingSum($damping, $i) * $trend[$i - 1]) * $seasonal[$i + $hm];
                        $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                    }
                    
                    $tempRMSE = Error::getRootMeanSquaredError($error);
            
                    if ($tempRMSE < $this->rmse) {
                        $this->rmse = $tempRMSE;
                        $forecast   = $tempForecast;
                    }

                    $gamma += 0.01;
                }

                $beta += 0.01;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getMultiplicativeNone(int $future, float $damping) : array 
    {
        $level = [$this->data[0]];
        $trend = [$this->data[1] / $this->data[0]];
        $dataLength = count($this->data) + $future;
        $forecast = [];

        $alpha = 0.00;
        while ($alpha < 1) {
            $beta = 0.00;

            while ($beta < 1) {
                $error = [];
                $tempForecast = [];

                for ($i = 1; $i < $dataLength; $i++) {
                    $level[$i] = $alpha * ($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) + (1 - $alpha) * $level[$i - 1] * pow($trend[$i - 1], $damping);
                    $trend[$i] = $beta * ($level[$i] / $level[$i - 1]) + (1 - $beta) * pow($trend[$i - 1], $damping);

                    $tempForecast[$i] = $level[$i] * pow($trend[$i], $this->dampingSum($damping, $i));
                    $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                }

                $tempRMSE = Error::getRootMeanSquaredError($error);
            
                if ($tempRMSE < $this->rmse) {
                    $this->rmse = $tempRMSE;
                    $forecast   = $tempForecast;
                }

                $beta += 0.01;
            }
            $alpha += 0.01;
        }
            
        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getMultiplicativeAdditive(int $future, int $cycle, float $damping) : array 
    {
        $level = [$this->data[0]];
        $trend = [1 / $cycle];
        $dataLength = count($this->data) + $future;
        $forecast = [];
        $seasonal = [];

        $sum = 0;
        for ($i = 1; $i < $cycle + 1; $i++) {
            $sum += ($this->data[$cycle] - $this->data[$i]) / $cycle;
        }

        $trend[0] *= $sum;

        for ($i = 1; $i < $cycle + 1; $i++) {
            $seasonal[$i] = $this->data[$i - 1] - $level[0];
        }

        $alpha = 0.00;
        while ($alpha < 1) {
            $beta = 0.00;

            while ($beta < 1) {
                $gamma = 0.00;

                while ($gamma < 1) {
                    $gamma_ = $gamma * (1 - $alpha);
                    $error = [];
                    $tempForecast = [];

                    for ($i = 1; $i < $dataLength; $i++) {
                        $hm = (int) floor(($i - 1) % $cycle) + 1;

                        $level[$i] = $alpha * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) - $seasonal[$i]) + (1 - $alpha) * $level[$i - 1] * pow($trend[$i - 1], $damping);
                        $trend[$i] = $beta * ($level[$i] / $level[$i - 1]) + (1 - $beta) * pow($trend[$i - 1], $damping);
                        $seasonal[$i + $cycle] = $gamma_ * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) - $level[$i - 1] * pow($trend[$i - 1], $damping)) + (1 - $gamma_) * $seasonal[$i];

                        $tempForecast[$i] = $level[$i] * pow($trend[$i], $this->dampingSum($damping, $i)) + $seasonal[$i + $hm];
                        $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                    }

                    $tempRMSE = Error::getRootMeanSquaredError($error);
            
                    if ($tempRMSE < $this->rmse) {
                        $this->rmse = $tempRMSE;
                        $forecast   = $tempForecast;
                    }

                    $gamma += 0.01;
                }

                $beta += 0.01;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

    public function getMultiplicativeMultiplicative(int $future, int $cycle, float $damping) : array 
    {
        $level = [$this->data[0]];
        $trend = [1 / $cycle];
        $dataLength = count($this->data) + $future;
        $forecast = [];
        $seasonal = [];

        $sum = 0;
        for ($i = 1; $i < $cycle + 1; $i++) {
            $sum += ($this->data[$cycle] - $this->data[$i]) / $cycle;
        }

        $trend[0] *= $sum;

        for ($i = 1; $i < $cycle + 1; $i++) {
            $seasonal[$i] = $this->data[$i] / $level[0];
        }

        $alpha = 0.00;
        while ($alpha < 1) {
            $beta = 0.00;

            while ($beta < 1) {
                $gamma = 0.00;

                while ($gamma < 1) {
                    $gamma_ = $gamma * (1 - $alpha);
                    $error = [];
                    $tempForecast = [];

                    for ($i = 1; $i < $dataLength; $i++) {
                        $hm = (int) floor(($i - 1) % $cycle) + 1;

                        $level[$i] = $alpha * (($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) / $seasonal[$i]) + (1 - $alpha) * $level[$i - 1] * pow($trend[$i - 1], $damping);
                        $trend[$i] = $beta * ($level[$i] / $level[$i - 1]) + (1 - $beta) * pow($trend[$i - 1], $damping);
                        $seasonal[$i + $cycle] = $gamma_ * ($i < $dataLength - $future ? $this->data[$i - 1] : $tempForecast[$i - 1]) / ($level[$i - 1] * pow($trend[$i - 1], $damping)) + (1 - $gamma_) * $seasonal[$i];

                        $tempForecast[$i] = $level[$i] * pow($trend[$i], $this->dampingSum($damping, $i)) * $seasonal[$i + $hm];
                        $error[] = $i < $dataLength - $future ? $this->data[$i] - $tempForecast[$i] : 0;
                    }
                    
                    $tempRMSE = Error::getRootMeanSquaredError($error);
            
                    if ($tempRMSE < $this->rmse) {
                        $this->rmse = $tempRMSE;
                        $forecast   = $tempForecast;
                    }

                    $gamma += 0.01;
                }

                $beta += 0.01;
            }

            $alpha += 0.01;
        }

        $this->errors = $error;
        $this->mse    = Error::getMeanSquaredError($error);
        $this->mae    = Error::getMeanAbsoulteError($error);
        $this->sse    = Error::getSumSquaredError($error);

        return $forecast;
    }

}