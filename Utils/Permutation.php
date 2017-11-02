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

namespace phpOMS\Utils;

/**
 * String utils.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Permutation
{
    /**
     * Create all permutations.
     *
     * @param array $toPermute data to permutate
     * @param array $result    existing permutations
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function permut(array $toPermute, array $result = []) : array
    {
        $permutations = [];

        if (empty($toPermute)) {
            $permutations[] = implode('', $result);
        } else {
            foreach ($toPermute as $key => $val) {
                $newArr   = $toPermute;
                $newres   = $result;
                $newres[] = $val;

                unset($newArr[$key]);
                
                $permutations = array_merge($permutations, self::permut($newArr, $newres));
            }
        }

        return $permutations;
    }

    /**
     * Check if two strings are permutations of each other.
     *
     * @param string $a String a
     * @param string $b String b
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isPermutation(string $a, string $b) : bool
    {
        return count_chars($a, 1) === count_chars($b, 1);
    }

    /**
     * Check if a string is a palindrome.
     *
     * @param string $a      String a
     * @param string $filter Characters to filter
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isPalindrome(string $a, string $filter = 'a-zA-Z0-9') : bool
    {
        $a = strtolower(preg_replace('/[^' . $filter . ']/', '', $a));

        return $a === strrev($a);
    }

    /**
     * Permutate based on transposition key.
     *
     * @param string|array $toPermute To permutate
     * @param array        $key       Permutation keys
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function permutate($toPermute, array $key)
    {
        if (!is_array($toPermute) && !is_string($toPermute)) {
            throw new \InvalidArgumentException('Parameter has to be array or string');
        }

        $length = is_array($toPermute) ? count($toPermute) : strlen($toPermute);

        if (count($key) > $length) {
            throw new \InvalidArgumentException('There mustn not be more keys than permutation elements.');
        }

        $i = 0;
        foreach ($key as $pos) {
            $temp                = $toPermute[$i];
            $toPermute[$i]       = $toPermute[$pos - 1];
            $toPermute[$pos - 1] = $temp;
            $i++;
        }

        return $toPermute;
    }
}