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

namespace phpOMS\Math\Functions;

/**
 * Well known functions class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Functions
{
    /**
     * Calculate gammar function value.
     *
     * Example: (7)
     *
     * @param int $k Variable
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getGammaInteger(int $k) : int
    {
        return self::fact($k - 1);
    }

    /**
     * Calculate gammar function value.
     *
     * Example: (7, 2)
     *
     * @param int $n     Factorial upper bound
     * @param int $start Factorial starting value
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function fact(int $n, int $start = 1) : int
    {
        $fact = 1;

        for ($i = $start; $i < $n + 1; $i++) {
            $fact *= $i;
        }

        return $fact;
    }

    /**
     * Calculate binomial coefficient
     *
     * Algorithm optimized for large factorials without the use of big int or string manipulation.
     *
     * Example: (7, 2)
     *
     * @param int $n
     * @param int $k
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function binomialCoefficient(int $n, int $k) : int
    {
        $max = max([$k, $n - $k]);
        $min = min([$k, $n - $k]);

        $fact  = 1;
        $range = array_reverse(range(1, $min));

        for ($i = $max + 1; $i < $n + 1; $i++) {
            $div = 1;
            foreach ($range as $key => $d) {
                if ($i % $d === 0) {
                    $div = $d;

                    unset($range[$key]);
                    break;
                }
            }

            $fact *= $i / $div;
        }

        $fact2 = 1;

        foreach ($range as $d) {
            $fact2 *= $d;
        }

        return $fact / $fact2;
    }

    /**
     * Calculate ackermann function.
     *
     * @param int $m
     * @param int $n
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function ackermann(int $m, int $n) : int
    {
        if ($m === 0) {
            return $n + 1;
        } elseif ($n === 0) {
            return self::ackermann($m - 1, 1);
        }

        return self::ackermann($m - 1, self::ackermann($m, $n - 1));
    }

    /**
     * Applying abs to every array value
     *
     * @param array $values Numeric values
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function abs(array $values) : array
    {
        $abs = [];

        foreach ($values as $value) {
            $abs[] = abs($value);
        }

        return $abs;
    }

    /**
     * Calculate inverse modular.
     *
     * @param int $a
     * @param int $n Modulo
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function invMod(int $a, int $n) : int
    {
        if ($n < 0) {
            $n = -$n;
        }

        if ($a < 0) {
            $a = $n - (-$a % $n);
        }

        $t  = 0;
        $nt = 1;
        $r  = $n;
        $nr = $a % $n;

        while ($nr != 0) {
            $quot = (int) ($r / $nr);
            $tmp  = $nt;
            $nt   = $t - $quot * $nt;
            $t    = $tmp;
            $tmp  = $nr;
            $nr   = $r - $quot * $nr;
            $r    = $tmp;
        }

        if ($r > 1) {
            return -1;
        }

        if ($t < 0) {
            $t += $n;
        }

        return $t;
    }

    /**
     * Modular implementation for negative values.
     *
     * @param int $a
     * @param int $b
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function mod($a, $b) : int
    {
        if ($a < 0) {
            return ($a + $b) % $b;
        }

        return $a % $b;
    }

    /**
     * Check if value is odd.
     *
     * @param int $a Value to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isOdd($a) : bool
    {
        return (bool) ($a & 1);
    }

    /**
     * Check if value is even.
     *
     * @param int $a Value to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isEven($a) : bool
    {
        return !((bool) ($a & 1));
    }

    /**
     * Gets the relative position on a circular construct.
     *
     * @example The relative fiscal month (August) in a company where the fiscal year starts in July.
     * @example 2 = getRelativeDegree(8, 12, 7);
     *
     * @param int $value Value to get degree
     * @param int $length Circle size
     * @param int $start Start value
     *
     * @return int Lowest value is 0 and highest value is length - 1
     *
     * @since  1.0.0
     */
    public static function getRelativeDegree(int $value, int $length, int $start = 0) : int
    {
        return abs(self::mod($value - $start, $length));
    }
}
