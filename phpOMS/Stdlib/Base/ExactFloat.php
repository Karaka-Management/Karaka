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

namespace phpOMS\Stdlib\Base;

class ExactFloat
{

    private static $length = 0;

    public static function setLength($length) /* : void */
    {
        self::$length = (int) $length;
    }

    public static function sum($a, $b, $length = null)
    {
        $length  = $length ?? self::$length;
        $split_a = explode('.', $a) + ['0', '0'];
        $split_b = explode('.', $b) + ['0', '0'];

        $sign_a   = '+';
        $sign_b   = '+';
        $sign_sum = '';

        $decimals    = [0, 0];
        $decimals[0] = (int) $split_a[0] + (int) $split_b[0];

        /* Get sign and length */
        $len_a = strlen($split_a[1]);

        if ($a[0] === '-') {
            $sign_a = '-';
        }

        $len_b = strlen($split_b[1]);

        if ($b[0] === '-') {
            $sign_b = '-';
        }

        /* Pad to same length */
        $len_max = max($len_a, $len_b);

        $val_a = (int) ($sign_a . str_pad($split_a[1], $len_max, '0'));
        $val_b = (int) ($sign_b . str_pad($split_b[1], $len_max, '0'));

        $temp_sum = $val_a + $val_b;

        if ($sign_a === '+' && $sign_b === '+') {
            if (strlen((string) $temp_sum) > $len_max) {
                $decimals[0]++;
                $decimals[1] = (int) substr((string) $temp_sum, 1);
            }
        } elseif ($sign_a === '+' && $sign_b === '-') {
            // todo: keep 0.5 in mind maybe decimals0--?!?!?! most likely not
            if ((int) $split_a[0] > (int) $split_b[0]) {
                if ($val_a < $val_b) {
                    $temp_sum = 10 * strlen((string) $temp_sum) - $temp_sum;
                }
            } else {
                if ($val_a > $val_b) {
                    $temp_sum = 10 * strlen((string) $temp_sum) - $temp_sum;
                }
            }

            $decimals[1] = (int) ltrim((string) $temp_sum, '-');
        } elseif ($sign_a === '-' && $sign_b === '+') {
            if ((int) $split_a[0] < (int) $split_b[0]) {
                if ($val_a > $val_b) {
                    $temp_sum = 10 * strlen((string) $temp_sum) - $temp_sum;
                }
            } else {
                if ($val_a < $val_b) {
                    $temp_sum = 10 * strlen((string) $temp_sum) - $temp_sum;
                }
            }

            $decimals[1] = (int) ltrim((string) $temp_sum, '-');
        } elseif ($sign_a === '-' && $sign_b === '-') {
            if (strlen((string) $temp_sum) > $len_max + 1) {
                $decimals[0]--;
                $decimals[1] = (int) substr((string) $temp_sum, 2);
            }

            if ($decimals[0] === 0) {
                $sign_sum = '-';
            }
        }

        /* Too short */
        $str_sum = str_pad((string) $decimals[1], $length, '0');

        /* Too long */
        /* TODO: handle rounding, carefull with e.g. 1.99995 -> 2.00 */
        if ($sign_sum === '-') {
            $str_sum = substr($str_sum, 0, $length + 1);
        } else {
            $str_sum = substr($str_sum, 0, $length);
        }

        return $sign_sum . $decimals[0] . ($length > 0 ? '.' . $str_sum : '');
    }

    public static function mult($a, $b, $length = null)
    {
    }

    public static function div($a, $b, $length = null)
    {
    }
}
