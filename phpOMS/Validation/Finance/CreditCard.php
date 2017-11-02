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

namespace phpOMS\Validation\Finance;

use phpOMS\Validation\ValidatorAbstract;

/**
 * Validator abstract.
 *
 * @category   Validation
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class CreditCard extends ValidatorAbstract
{

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function isValid($value, array $constraints = null) : bool
    {
        $value = preg_replace('/\D/', '', $value);

        // Set the string length and parity
        $number_length = strlen($value);
        $parity        = $number_length % 2;

        // Loop through each digit and do the maths
        $total = 0;
        for ($i = 0; $i < $number_length; $i++) {
            $digit = $value[$i];
            // Multiply alternate digits by two
            if ($i % 2 == $parity) {
                $digit *= 2;
                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            // Total up the digits
            $total += $digit;
        }

        // If the total mod 10 equals 0, the value is valid
        return ($total % 10 == 0) ? true : false;
    }

    /**
     * Luhn algorithm or mod 10 algorithm is used to verify credit cards.
     *
     * @param string $num Credit card number.
     *
     * @return bool Returns true if the number is a valid credit card and false if it isn't.
     *
     * @since  1.0.0
     */
    public static function luhnTest(string $num) : bool
    {
        $len = strlen($num);
        $sum = 0;

        for ($i = $len - 1; $i >= 0; $i--) {
            $ord = ord($num[$i]);

            if (($len - 1) & $i) {
                $sum += $ord;
            } else {
                $sum += $ord / 5 + (2 * $ord) % 10;
            }
        }

        return $sum % 10 == 0;
    }
}
