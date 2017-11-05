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

namespace phpOMS\Utils\Compression;

/**
 * Compression Interface
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface CompressionInterface
{
    /**
     * Compresses source text
     *
     * @param string $source Source text to compress
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function compress(string $source) : string;

    /**
     * Decompresses text
     *
     * @param string $compressed Compressed text to decompress
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function decompress(string $compressed) : string;
}