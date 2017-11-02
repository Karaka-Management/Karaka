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
 * String utils class.
 *
 * This class provides static helper functionalities for strings.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class StringUtils
{

    /**
     * Constructor.
     *
     * This class is purely static and is preventing any initialization
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Check if a string contains any of the provided needles.
     *
     * The validation is done case sensitive.
     *
     * @param string $haystack Haystack
     * @param array  $needles  Needles to check if any of them are part of the haystack
     *
     * @example StringUtils::contains('This string', ['This', 'test']); // true
     * @example StringUtils::contains('This string', 'is st'); // true
     * @example StringUtils::contains('This string', 'something'); // false
     *
     * @return bool The function returns true if any of the needles is part of the haystack, false otherwise.
     *
     * @since  1.0.0
     */
    public static function contains(string $haystack, array $needles) : bool
    {
        foreach ($needles as $needle) {
            if (strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a string contains any of the provided needles.
     *
     * The validation is done case sensitive.
     *
     * @param string $haystack Haystack
     * @param array  $needles  Needles to check if any of them are part of the haystack
     *
     * @example StringUtils::mb_contains('This string', ['This', 'test']); // true
     * @example StringUtils::mb_contains('This string', 'is st'); // true
     * @example StringUtils::mb_contains('This string', 'something'); // false
     *
     * @return bool The function returns true if any of the needles is part of the haystack, false otherwise.
     *
     * @since  1.0.0
     */
    public static function mb_contains(string $haystack, array $needles) : bool
    {
        foreach ($needles as $needle) {
            if (mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Tests if a string ends with a certain string.
     *
     * The validation is done case sensitive. The function takes strings or an array of strings for the validation.
     * In case of an array the function will test if any of the needles is at the end of the haystack string.
     *
     * @param string       $haystack Haystack
     * @param string|array $needles  Needles to check if they are at the end of the haystack.
     *
     * @example StringUtils::endsWith('Test string', ['test1', 'string']); // true
     * @example StringUtils::endsWith('Test string', 'string'); // true
     * @example StringUtils::endsWith('Test string', 'String'); // false
     *
     * @return bool The function returns true if any of the needles is at the end of the haystack, false otherwise.
     *
     * @since  1.0.0
     */
    public static function endsWith(string $haystack, $needles) : bool
    {
        if (is_string($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ($needle === '' || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Tests if a string starts with a certain string.
     *
     * The validation is done case sensitive. The function takes strings or an array of strings for the validation.
     * In case of an array the function will test if any of the needles is at the beginning of the haystack string.
     *
     * @param string       $haystack Haystack
     * @param string|array $needles  Needles to check if they are at the beginning of the haystack.
     *
     * @example StringUtils::startsWith('Test string', ['Test', 'something']); // true
     * @example StringUtils::startsWith('Test string', 'string'); // false
     * @example StringUtils::startsWith('Test string', 'Test'); // true
     *
     * @return bool The function returns true if any of the needles is at the beginning of the haystack, false otherwise.
     *
     * @since  1.0.0
     */
    public static function startsWith(string $haystack, $needles) : bool
    {
        if (is_string($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ($needle === '' || strrpos($haystack, $needle, -strlen($haystack)) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Tests if a multi byte string starts with a certain string.
     *
     * The validation is done case sensitive. The function takes strings or an array of strings for the validation.
     * In case of an array the function will test if any of the needles is at the beginning of the haystack string.
     *
     * @param string       $haystack Haystack
     * @param string|array $needles  Needles to check if they are at the beginning of the haystack.
     *
     * @return bool The function returns true if any of the needles is at the beginning of the haystack, false otherwise.
     *
     * @since  1.0.0
     */
    public static function mb_startsWith(string $haystack, $needles) : bool
    {
        if (is_string($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ($needle === '' || mb_strrpos($haystack, $needle, -mb_strlen($haystack)) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Tests if a multi byte string ends with a certain string.
     *
     * The validation is done case sensitive. The function takes strings or an array of strings for the validation.
     * In case of an array the function will test if any of the needles is at the end of the haystack string.
     *
     * @param string       $haystack Haystack
     * @param string|array $needles  Needles to check if they are at the end of the haystack.
     *
     * @example StringUtils::endsWith('Test string', ['test1', 'string']); // true
     * @example StringUtils::endsWith('Test string', 'string'); // true
     * @example StringUtils::endsWith('Test string', String); // false
     *
     * @return bool The function returns true if any of the needles is at the end of the haystack, false otherwise.
     *
     * @since  1.0.0
     */
    public static function mb_endsWith(string $haystack, $needles) : bool
    {
        if (is_string($needles)) {
            $needles = [$needles];
        }

        foreach ($needles as $needle) {
            if ($needle === '' || (($temp = mb_strlen($haystack) - mb_strlen($needle)) >= 0 && mb_strpos($haystack, $needle, $temp) !== false)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Makes first letter of a multi byte string upper case.
     *
     * @param string $string String to upper case first letter.
     *
     * @return string Multi byte string with first character as upper case.
     *
     * @since  1.0.0
     */
    public static function mb_ucfirst(string $string) : string
    {
        $strlen    = mb_strlen($string);
        $firstChar = mb_substr($string, 0, 1);
        $then      = mb_substr($string, 1, $strlen - 1);

        return mb_strtoupper($firstChar) . $then;
    }

    /**
     * Makes first letter of a multi byte string lower case.
     *
     * @param string $string String to lower case first letter.
     *
     * @return string Multi byte string with first character as lower case.
     *
     * @since  1.0.0
     */
    public static function mb_lcfirst(string $string) : string
    {
        $strlen    = mb_strlen($string);
        $firstChar = mb_substr($string, 0, 1);
        $then      = mb_substr($string, 1, $strlen - 1);

        return mb_strtolower($firstChar) . $then;
    }

    /**
     * Trim multi byte characters from a multi byte string.
     *
     * @param string $string   Multi byte string to trim multi byte characters from.
     * @param string $charlist Multi byte character list used for trimming
     *
     * @return string Trimmed multi byte string.
     *
     * @since  1.0.0
     */
    public static function mb_trim(string $string, string $charlist = ' ') : string
    {
        if ($charlist === ' ') {
            return trim($string);
        } else {
            $charlist = str_replace('/', '\/', preg_quote($charlist));

            return preg_replace('/(^[' . $charlist . ']+)|([ ' . $charlist . ']+$)/us', '', $string);
        }
    }

    /**
     * Trim multi byte characters from the right of a multi byte string.
     *
     * @param string $string   Multi byte string to trim multi byte characters from.
     * @param string $charlist Multi byte character list used for trimming
     *
     * @return string Trimmed multi byte string.
     *
     * @since  1.0.0
     */
    public static function mb_rtrim(string $string, string $charlist = ' ') : string
    {
        if ($charlist === ' ') {
            return rtrim($string);
        } else {
            $charlist = str_replace('/', '\/', preg_quote($charlist));

            return preg_replace('/([' . $charlist . ']+$)/us', '', $string);
        }
    }

    /**
     * Trim multi byte characters from the left of a multi byte string.
     *
     * @param string $string   Multi byte string to trim multi byte characters from.
     * @param string $charlist Multi byte character list used for trimming
     *
     * @return string Trimmed multi byte string.
     *
     * @since  1.0.0
     */
    public static function mb_ltrim(string $string, string $charlist = ' ') : string
    {
        if ($charlist === ' ') {
            return ltrim($string);
        } else {
            $charlist = str_replace('/', '\/', preg_quote($charlist));

            return preg_replace('/(^[' . $charlist . ']+)/us', '', $string);
        }
    }

    /**
     * Count occurences of character at the beginning of a string.
     *
     * @param string $string    String to analyze.
     * @param string $character Character to count at the beginning of the string.
     *
     * @example StringUtils::countCharacterFromStart('    Test string', ' '); // 4
     * @example StringUtils::countCharacterFromStart('    Test string', 's'); // 0
     *
     * @return int The amount of repeating occurences at the beginning of the string.
     *
     * @since  1.0.0
     */
    public static function countCharacterFromStart(string $string, string $character) : int
    {
        $count  = 0;
        $length = strlen($string);

        for ($i = 0; $i < $length; $i++) {
            if ($string[$i] !== $character) {
                break;
            }

            $count++;
        }

        return $count;
    }

    /**
     * Calculate string entropy
     *
     * @param string $value String to analyze.
     *
     * @return float 
     *
     * @since  1.0.0
     */
    public static function getEntropy(string $value) : float
    {
        $entroy = 0.0;
        $size = mb_strlen($value);
        $countChars = self::mb_count_chars($value);

        foreach ($countChars as $v) {
            $p = $v / $size;
            $entroy -= $p * log($p) / log(2);
        }

        return $entroy;
    }

    /**
     * Count chars of utf-8 string.
     *
     * @param string $input String to count chars.
     *
     * @return array 
     *
     * @since  1.0.0
     */
    public static function mb_count_chars(string $input) : array
    {
        $l      = mb_strlen($input, 'UTF-8');
        $unique = [];

        for ($i = 0; $i < $l; $i++) {
            $char = mb_substr($input, $i, 1, 'UTF-8');

            if (!array_key_exists($char, $unique)) {
                $unique[$char] = 0;
            }

            $unique[$char]++;
        }

        return $unique;
    }
}
