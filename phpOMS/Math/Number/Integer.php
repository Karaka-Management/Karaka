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
 * Integer class
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Integer
{
    /**
     * Is integer.
     *
     * @param mixed $value Value to test
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isInteger($value) : bool
    {
        return is_int($value);
    }

    /**
     * Trial factorization.
     *
     * @param int $value Integer to factorize
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function trialFactorization(int $value) : array
    {
        if ($value < 2) {
            return [];
        }

        $factors = [];
        $primes  = Prime::sieveOfEratosthenes((int) $value ** 0.5);

        foreach ($primes as $prime) {
            if ($prime * $prime > $value) {
                break;
            }

            while ($value % $prime === 0) {
                $factors[] = $prime;
                $value /= $prime;
            }
        }

        if ($value > 1) {
            $factors[] = $value;
        }

        return $factors;
    }

    /**
     * Pollard's Rho.
     *
     * Integer factorization algorithm
     *
     * @param int $n         Integer to factorize
     * @param int $x         Used for g(x) = (x^2 + 1) mod n
     * @param int $factor    Period for repetition
     * @param int $cycleSize Cycle size
     * @param int $y         Fixed value for g(x) = g(y) mod p
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function pollardsRho(int $n, int $x = 2, int $factor = 1, int $cycleSize = 2, int $y = 2) : int
    {
        while ($factor === 1) {
            for ($i = 1; $i < $cycleSize && $factor <= 1; $i++) {
                $x      = ($x * $x + 1) % $n;
                $factor = self::greatestCommonDivisor($x - $y, $n);
            }

            $cycleSize *= 2;
            $y = $x;
        }

        return $factor;
    }

    /**
     * Greatest common diviser.
     *
     * @param int $n Number one
     * @param int $m Number two
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function greatestCommonDivisor(int $n, int $m) : int
    {
        $n = abs($n);
        $m = abs($m);

        while ($n !== $m) {
            if ($n > $m) {
                $n -= $m;
            } else {
                $m -= $n;
            }
        }

        return $m;
    }

    /**
     * Fermat factorization of odd integers.
     *
     * @param int $value Integer to factorize
     * @param int $limit Max amount of iterations
     *
     * @return array
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function fermatFactor(int $value, int $limit = 1000000) : array
    {
        if (($value % 2) === 0) {
            throw new \Exception('Only odd integers are allowed');
        }

        $a  = (int) ceil(sqrt($value));
        $b2 = (int) ($a * $a - $value);
        $i  = 1;

        while (!Numbers::isSquare($b2) && $i < $limit) {
            $i++;
            $a += 1;
            $b2 = (int) ($a * $a - $value);
        }

        return [(int) round($a - sqrt($b2)), (int) round($a + sqrt($b2))];
    }
}