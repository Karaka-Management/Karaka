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

namespace phpOMS\Math\Number;

/**
 * Numbers class.
 *
 * @category   Framework
 * @package    Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Numbers
{
    /**
     * Is perfect number?
     *
     * @param int $n Number to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isPerfect(int $n) : bool
    {
        $sum = 0;

        for ($i = 1; $i < $n; $i++) {
            if ($n % $i == 0) {
                $sum += $i;
            }
        }

        return $sum == $n;
    }

    /**
     * Is self describing number?
     *
     * @param int $n Number to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isSelfdescribing(int $n) : bool
    {
        $n = (string) $n;
        $split = str_split($n);

        foreach ($split as $place => $value) {
            if (substr_count($n, (string) $place) != $value) {
                return false;
            }
        }

        return true;
    }

    /**
     * Is square number?
     *
     * @param int $n Number to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isSquare(int $n) : bool
    {
        return abs(((int) sqrt($n)) * ((int) sqrt($n)) - $n) < 0.001;
    }

    /**
     * Count trailling zeros
     *
     * @param int $n Number to test
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function countTrailingZeros(int $n) : int
    {
        $count = 0;
        while ($n !== 0) {
            if ($n & 1 == 1) {
                break;
            } else {
                $count++;
                $n = $n >> 1;
            }
        }

        return $count;
    }
}