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

namespace phpOMS\Utils\Converter;

/**
 * Numeric converter.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Numeric
{

    /**
     * Romans association.
     *
     * @var array
     * @since 1.0.0
     */
    /* public */ const ROMANS = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];

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
     * Convert base.
     *
     * @param string $numberInput   Input number
     * @param string $fromBaseInput Input layout (e.g. 0123456789ABCDEF)
     * @param string $toBaseInput   Output layout (e.g. 0123456789ABCDEF)
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function convertBase(string $numberInput, string $fromBaseInput, string $toBaseInput) : string
    {
        if ($fromBaseInput == $toBaseInput) {
            return $numberInput;
        }

        $fromBase  = str_split($fromBaseInput, 1);
        $toBase    = str_split($toBaseInput, 1);
        $number    = str_split($numberInput, 1);
        $fromLen   = strlen($fromBaseInput);
        $toLen     = strlen($toBaseInput);
        $numberLen = strlen($numberInput);
        $newOutput = '';

        if ($toBaseInput === '0123456789') {
            $newOutput = 0;

            for ($i = 1; $i <= $numberLen; $i++) {
                $newOutput = bcadd((string) $newOutput, bcmul((string) array_search($number[$i - 1], $fromBase), bcpow((string) $fromLen, (string) ($numberLen - $i))));
            }

            return $newOutput;
        }

        $base10 = $fromBaseInput != '0123456789' ? self::convertBase($numberInput, $fromBaseInput, '0123456789') : $numberInput;

        if ($base10 < strlen($toBaseInput)) {
            return $toBase[$base10];
        }

        while ($base10 !== '0') {
            $newOutput = $toBase[bcmod($base10, (string) $toLen)] . $newOutput;
            $base10    = bcdiv($base10, (string) $toLen, 0);
        }

        return $newOutput;
    }

    /**
     * Convert arabic to roman.
     *
     * Be aware that there is no standard for larger roman numbers.
     *
     * @param int $arabic Arabic number
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function arabicToRoman(int $arabic) : string
    {
        $result = '';

        while ($arabic > 0) {
            foreach (self::ROMANS as $rom => $arb) {
                if ($arabic >= $arb) {
                    $arabic -= $arb;
                    $result .= $rom;
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * Convert roman to arabic.
     *
     * @param string $roman Roman number
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function romanToArabic(string $roman) : int
    {
        $result = 0;

        foreach (self::ROMANS as $key => $value) {
            while (strpos($roman, $key) === 0) {
                $result += $value;
                $roman = substr($roman, strlen($key));
            }
        }

        return $result;
    }

    /**
     * Convert numeric to alpha.
     *
     * This can be used for alpha lists such as e.g. word uses.
     *
     * @param int $number Number to convert
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function numericToAlpha(int $number) : string
    {
        $alpha = '';

        for ($i = 1; $number >= 0 && $i < 10; $i++) {
            $alpha = chr(0x41 + ($number % pow(26, $i) / pow(26, $i - 1))) . $alpha;
            $number -= pow(26, $i);
        }

        return $alpha;
    }

    /**
     * Convert alpha to numeric.
     *
     * @param string $alpha Alpha to convert
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function alphaToNumeric(string $alpha) : int
    {
        $numeric = 0;
        $length  = strlen($alpha);

        for ($i = 0; $i < $length; $i++) {
            $numeric += pow(26, $i) * (ord($alpha[$length - $i - 1]) - 0x40);
        }

        return $numeric - 1;
    }
}
