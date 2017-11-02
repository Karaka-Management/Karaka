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
 * Array utils.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class ArrayUtils
{

    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Check if needle exists in multidimensional array.
     *
     * @param string $path  Path to element
     * @param array  $data  Array
     * @param string $delim Delimiter for path
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function unsetArray(string $path, array $data, string $delim = '/') : array
    {
        $nodes  = explode($delim, trim($path, $delim));
        $prevEl = null;
        $el     = &$data;

        $node = null;

        foreach ($nodes as &$node) {
            $prevEl = &$el;

            if (!isset($el[$node])) {
                break;
            }

            $el = &$el[$node];
        }

        if ($prevEl !== null) {
            unset($prevEl[$node]);
        }

        return $data;
    }

    /**
     * Set element in array by path
     *
     * @param string $path      Path to element
     * @param array  $data      Array
     * @param mixed  $value     Value to add
     * @param string $delim     Delimiter for path
     * @param bool   $overwrite Overwrite if existing
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function setArray(string $path, array $data, $value, string $delim = '/', bool $overwrite = false) : array
    {
        $pathParts = explode($delim, trim($path, $delim));
        $current   = &$data;

        foreach ($pathParts as $key) {
            $current = &$current[$key];
        }

        if ($overwrite) {
            $current = $value;
        } elseif (is_array($current) && !is_array($value)) {
            $current[] = $value;
        } elseif (is_array($current) && is_array($value)) {
            $current += $value;
        } elseif (is_scalar($current) && $current !== null) {
            $current = [$current, $value];
        } else {
            $current = $value;
        }

        return $data;
    }

    /**
     * Get element of array by path
     *
     * @param string $path      Path to element
     * @param array  $data      Array
     * @param string $delim     Delimiter for path
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function getArray(string $path, array $data, string $delim = '/')
    {
        $pathParts = explode($delim, trim($path, $delim));
        $current   = $data;

        foreach ($pathParts as $key) {
            $current = $current[$key];
        }

        return $current;
    }

    /**
     * Check if needle exists in multidimensional array.
     *
     * @param mixed $needle   Needle for search
     * @param array $haystack Haystack for search
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function inArrayRecursive($needle, array $haystack) : bool
    {
        $found = false;

        foreach ($haystack as $item) {
            if ($item === $needle) {
                return true;
            } elseif (is_array($item)) {
                $found = self::inArrayRecursive($needle, $item);

                if ($found) {
                    return true;
                }
            }
        }

        return $found;
    }

    /**
     * Check if any of the needles are in the array
     *
     * @param mixed $needles   Needles for search
     * @param array $haystack Haystack for search
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function anyInArray(array $needles, array $haystack) : bool
    {
        foreach ($needles as $needle) {
            if (in_array($needle, $haystack)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if all of the needles are in the array
     *
     * @param mixed $needles   Needles for search
     * @param array $haystack Haystack for search
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function allInArray(array $needles, array $haystack) : bool
    {
        foreach ($needles as $needle) {
            if (!in_array($needle, $haystack)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Stringify array.
     *
     * @param array $array Array to stringify
     *
     * @return string
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function stringify(array $array) : string
    {
        $str = '[';

        foreach ($array as $key => $value) {
            if (is_string($key)) {
                $key = '\'' . $key . '\'';
            }

            switch (gettype($value)) {
                case 'array':
                    $str .= $key . ' => ' . self::stringify($value) . ', ';
                    break;
                case 'integer':
                case 'double':
                case 'float':
                    $str .= $key . ' => ' . $value . ', ';
                    break;
                case 'string':
                    $str .= $key . ' => \'' . $value . '\'' . ', ';
                    break;
                case 'object':
                    $str .= $key . ' => ' . get_class($value['default']) . '()';
                    // TODO: implement object with parameters -> Reflection
                    break;
                case 'boolean':
                    $str .= $key . ' => ' . ($value['default'] ? 'true' : 'false') . ', ';
                    break;
                case 'NULL':
                    $str .= $key . ' => null, ';
                    break;
                default:
                    throw new \Exception('Unknown default type');
            }
        }

        return $str . ']';
    }

    /**
     * Convert array to csv string.
     *
     * @param array  $data      Data to convert
     * @param string $delimiter Delim to use
     * @param string $enclosure Enclosure to use
     * @param string $escape    Escape to use
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function arrayToCSV(array $data, string $delimiter = ';', string $enclosure = '"', string $escape = '\\') : string
    {
        $outstream = fopen('php://memory', 'r+');
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        fputcsv($outstream, $data, $delimiter, $enclosure, $escape);
        rewind($outstream);
        $csv = fgets($outstream);
        fclose($outstream);

        return $csv;
    }

    /**
     * Get array value by argument id.
     *
     * Useful for parsing command line parsing
     *
     * @param string $id   Id to find
     * @param array  $args CLI command list
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function getArg(string $id, array $args) /* : ?string */
    {
        if (($key = array_search($id, $args)) === false || $key === count($args) - 1) {
            return null;
        }

        return trim($args[$key + 1], '" ');
    }

    /**
     * Flatten array
     *
     * Reduces multi dimensional array to one dimensional array. Flatten tries to maintain the index as far as possible.
     *
     * @param array $array Multi dimensional array to flatten
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function arrayFlatten(array $array) : array
    {

        // see collection collapse as alternative?!
        $flat  = [];
        $stack = array_values($array);

        while (!empty($stack)) {
            $value = array_shift($stack);

            if (is_array($value)) {
                $stack = array_merge(array_values($value), $stack);
            } else {
                $flat[] = $value;
            }
        }

        return $flat;
    }

    /**
     * Sum of array elements
     *
     * @param array $array Array to sum
     * @param int $start Start index
     * @param int $count Amount of elements to sum
     *
     * @return int|float
     *
     * @since  1.0.0
     */
    public static function arraySum(array $array, int $start = 0, int $count = 0)
    {
        $count = $count === 0 ? count($array) : $start + $count;
        $sum   = 0;
        $array = array_values($array);

        for ($i = $start; $i <= $count - 1; $i++) {
            $sum += $array[$i];
        }

        return $sum;
    }

    /**
     * Sum multi dimensional array
     *
     * @param array $array Multi dimensional array to flatten
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public static function arraySumRecursive(array $array)
    {
        return array_sum(self::arrayFlatten($array));
    }
}
