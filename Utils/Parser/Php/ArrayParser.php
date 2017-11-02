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

namespace phpOMS\Utils\Parser\Php;

/**
 * Array parser class.
 *
 * Parsing/serializing arrays to and from php file
 *
 * @category   Framework
 * @package    phpOMS\Utils\Parser
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class ArrayParser
{
    /**
     * Serializing array (recursively).
     *
     * @param array $arr Array to serialize
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function serializeArray(array $arr) : string
    {
        $stringify = '[' . PHP_EOL;

        foreach ($arr as $key => $val) {
            if (is_string($key)) {
                $key = '"' . $key . '"';
            }

            $stringify .= '    ' . $key . ' => ' . self::parseVariable($val) . ',' . PHP_EOL;

        }

        return $stringify . ']';
    }

    /**
     * Serialize value.
     *
     * @param mixed $value Value to serialzie
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function parseVariable($value) : string
    {
        if (is_array($value)) {
            return ArrayParser::serializeArray($value) . PHP_EOL;
        } elseif (is_string($value)) {
            return '"' . $value . '"';
        } elseif (is_scalar($value)) {
            return (string) $value;
        } elseif (is_null($value)) {
            return 'null';
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif ($value instanceOf \Serializable) {
            return self::parseVariable($value->serialize());
        } else {
            throw new \UnexpectedValueException();
        }
    }
}
