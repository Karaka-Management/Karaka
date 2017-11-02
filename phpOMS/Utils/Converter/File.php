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
 * File converter.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class File
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
     * Get file size string.
     *
     * @param int $bytes Amount of bytes
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function byteSizeToString(int $bytes) : string
    {
        if ($bytes < 1000) {
            return $bytes . 'b';
        } elseif ($bytes > 999 && $bytes < 1000000) {
            return ((float) number_format($bytes / 1000, 1)) . 'kb';
        } elseif ($bytes > 999999 && $bytes < 1000000000) {
            return ((float) number_format($bytes / 1000000, 1)) . 'mb';
        } else {
            return ((float) number_format($bytes / 1000000000, 1)) . 'gb';
        }
    }

    /**
     * Get file size string.
     *
     * @param int $kilobytes Amount of kilobytes
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function kilobyteSizeToString(int $kilobytes) : string
    {
        if ($kilobytes < 1000) {
            return ((float) number_format($kilobytes, 1)) . 'kb';
        } elseif ($kilobytes > 999 && $kilobytes < 1000000) {
            return ((float) number_format($kilobytes / 1000, 1)) . 'mb';
        } else {
            return ((float) number_format($kilobytes / 1000000, 1)) . 'gb';
        }
    }
}
