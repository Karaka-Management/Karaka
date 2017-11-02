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

namespace phpOMS\Business\Finance;

class Depreciation
{
    public static function getLinearDepreciationRate(float $start, int $duration) : float
    {
        return $start / $duration;
    }

    public static function getLinearDepreciationResidualInT(float $start, int $duration, int $t) : float
    {
        return $start - self::getLinearDepreciationRate($start, $duration) * $t;
    }

    public static function getArithmeticProgressivDepreciationRate(float $start, int $duration) : float
    {
        return $start / ($duration * ($duration + 1) / 2);
    }

    public static function getArithmeticProgressivDepreciationInT(float $start, int $duration, int $t) : float
    {
        return $t * self::getArithmeticProgressivDepreciationRate($start, $duration);
    }

    public static function getArithmeticProgressivDepreciationResidualInT(float $start, int $duration, int $t) : float
    {
        return $start - self::getArithmeticProgressivDepreciationRate($start, $duration) * $t * ($t + 1) / 2;
    }

    public static function getGeometicProgressivDepreciationRate(float $start, float $residual, int $duration) : float
    {
        return (1 - pow($residual / $start, 1 / $duration));
    }

    public static function getGeometicDegressivDepreciationInT(float $start, float $residual, int $duration, int $t) : float
    {
        return $start * (1 - self::getGeometicDegressivDepreciationRate($start, $residual, $duration)) ** $t;
    }

    public static function getGeometicDegressivDepreciationResidualInT(float $start, float $residual, int $duration, int $t) : float
    {
    }

    public static function getGeometicProgressivDepreciationInT(float $start, float $residual, int $duration, int $t) : float
    {
        return $start * (1 - self::getGeometicProgressivDepreciationRate($start, $residual, $duration)) ** ($duration - $t + 1);
    }

    public static function getGeometicProgressivDepreciationResidualInT(float $start, float $residual, int $duration, int $t) : float
    {
    }
}