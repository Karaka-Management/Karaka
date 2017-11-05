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
 * Well known functions class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Prime
{
    /**
     * Is mersenne number?
     *
     * @param int $n Number to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isMersenne(int $n) : bool
    {
        $mersenne = log($n + 1, 2);

        return $mersenne - (int) $mersenne < 0.00001;
    }

    /**
     * Get mersenne number
     *
     * @param int $p Power
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function mersenne(int $p) : int
    {
        return 2 ** $p - 1;
    }

    /**
     * Is prime?
     *
     * @param int $n Number to test
     * @param int $k Accuracy
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function rabinTest(int $n, int $k = 10000) : bool
    {
        if ($n == 2) {
            return true;
        }

        if ($n < 2 || $n % 2 == 0) {
            return false;
        }

        $d = $n - 1;
        $s = 0;

        while ($d % 2 == 0) {
            $d /= 2;
            $s++;
        }

        for ($i = 0; $i < $k; $i++) {
            $a = mt_rand(2, $n - 1);

            $x = bcpowmod((string) $a, (string) $d, (string) $n);

            if ($x == 1 || $x == $n - 1) {
                continue;
            }

            for ($j = 1; $j < $s; $j++) {
                $x = bcmod(bcmul($x, $x), (string) $n);

                if ($x == 1) {
                    return false;
                }

                if ($x == $n - 1) {
                    continue 2;
                }
            }

            return false;
        }

        return true;
    }

    /**
     * Create prime numbers
     *
     * @param int $n Primes to generate
     *
     * @return int[]
     *
     * @since  1.0.0
     */
    public static function sieveOfEratosthenes(int $n) : array
    {
        $number = 2;
        $range  = range(2, $n);
        $primes = array_combine($range, $range);

        while ($number * $number < $n) {
            for ($i = $number; $i <= $n; $i += $number) {
                if ($i == $number) {
                    continue;
                }

                unset($primes[$i]);
            }

            $number = next($primes);
        }

        return array_values($primes);
    }

    /**
     * Is prime?
     *
     * @param int $n Number to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isPrime(int $n) : bool
    {
        $i = 2;

        if ($n === 2) {
            return true;
        }

        $sqrtN = sqrt($n);
        while ($i <= $sqrtN) {
            if ($n % $i === 0) {
                return false;
            }

            $i++;
        }

        return true;
    }
}