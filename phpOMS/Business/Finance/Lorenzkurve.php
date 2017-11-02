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

/**
 * Finance class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Lorenzkurve
{
    /**
     * Calculate Gini coefficient
     *
     * @param array $data Datapoints (can be unsorted)
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getGiniCoefficient(array $data) : float
    {
        $sum1 = 0;
        $sum2 = 0;
        $i    = 1;
        $n    = count($data);

        sort($data);

        foreach ($data as $key => $value) {
            $sum1 += $i * $value;
            $sum2 += $value;
            $i++;
        }

        return 2 * $sum1 / ($n * $sum2) - ($n + 1) / $n;
    }
}