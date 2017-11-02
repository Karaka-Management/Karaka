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
 * Color class for color operations.
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class ColorUtils
{

    /**
     * Convert int to rgb
     *
     * @param int   $rgbInt Value to convert
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function intToRgb(int $rgbInt) : array
    {
        $rgb = ['r' => 0, 'g' => 0, 'b' => 0];

        $rgb['b'] = $rgbInt & 255;
        $rgb['g'] = ($rgbInt >> 8) & 255;
        $rgb['r'] = ($rgbInt >> 16) & 255;

        return $rgb;
    }

    /**
     * Convert rgb to int
     *
     * @param array $rgb Int rgb array
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function rgbToInt(array $rgb) : int
    {
        $i = (255 & $rgb['r']) << 16;
        $i += (255 & $rgb['g']) << 8;
        $i += (255 & $rgb['b']);

        return $i;
    }
}
