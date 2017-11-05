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
 * Encoding Interface
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface EncodingInterface
{
    /**
     * Encode source text
     *
     * @param string $source Source text to decode
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function encode($source);

    /**
     * Dedecodes text
     *
     * @param string $decoded decoded text to dedecode
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function decode($decoded);
}