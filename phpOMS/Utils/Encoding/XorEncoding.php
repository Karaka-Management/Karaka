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

namespace phpOMS\Utils\Encoding;

/**
 * XOR encoding class
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
final class XorEncoding
{

    /**
     * {@inheritdoc}
     */
    public static function decode(string $raw, string $key) : string
    {
        return self::encode($raw, $key);
    }

    /**
     * {@inheritdoc}
     */
    public static function encode(string $source, string $key) : string
    {
        $result    = '';
        $length    = strlen($source);
        $keyLength = strlen($key) - 1;

        for ($i = 0, $j = 0; $i < $length; $i++, $j++) {
            if ($j > $keyLength) {
                $j = 0;
            }

            $ascii = ord($source[$i]) ^ ord($key[$j]);
            $result .= chr($ascii);
        }

        return $result;
    }
}