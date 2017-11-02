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

namespace phpOMS\Validation;

use phpOMS\Utils\StringUtils;

/**
 * Validator class.
 *
 * @category   Framework
 * @package    phpOMS\Validation
 * @since      1.0.0
 */
final class Validator extends ValidatorAbstract
{

    /**
     * Validate variable based on multiple factors.
     *
     * @param mixed $var         Variable to validate
     * @param array $constraints Constraints for validation
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isValid($var, array $constraints = null) : bool
    {
        if (!isset($constraints)) {
            return true;
        }

        foreach ($constraints as $callback => $settings) {
            $callback = StringUtils::endsWith($callback, 'Not') ? substr($callback, 0, -3) : $callback;
            $valid = self::$callback($var, ...$settings);
            $valid = (StringUtils::endsWith($callback, 'Not') ? $valid : !$valid);

            if (!$valid) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate variable by type.
     *
     * @param mixed           $var        Variable to validate
     * @param string[]|string $constraint Array of allowed types
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isType($var, $constraint) : bool
    {
        if (!is_array($constraint)) {
            $constraint = [$constraint];
        }

        foreach ($constraint as $key => $value) {
            if (!is_a($var, $value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate variable by length.
     *
     * @param string    $var Variable to validate
     * @param int|float $min Min. length
     * @param int|float $max Max. length
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function hasLength(string $var, int $min = 0, int $max = PHP_INT_MAX) : bool
    {
        $length = strlen($var);

        if ($length <= $max && $length >= $min) {
            return true;
        }

        return false;
    }

    /**
     * Validate variable by substring.
     *
     * @param string       $var    Variable to validate
     * @param string|array $substr Substring
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function contains(string $var, $substr) : bool
    {
        return is_string($substr) ? strpos($var, $substr) !== false : StringUtils::contains($var, $substr);
    }

    /**
     * Validate variable by pattern.
     *
     * @param string $var     Variable to validate
     * @param string $pattern Pattern for validation
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function matches(string $var, string $pattern) : bool
    {
        return (preg_match($pattern, $var) !== false ? true : false);
    }

    /**
     * Validate variable by interval.
     *
     * @param int|float $var Variable to validate
     * @param int|float $min Min. value
     * @param int|float $max Max. value
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function hasLimit($var, $min = 0, $max = PHP_INT_MAX) : bool
    {
        if ($var <= $max && $var >= $min) {
            return true;
        }

        return false;
    }
}
