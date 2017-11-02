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
namespace phpOMS\Utils\IO\Zip;
/**
 * Archive interface
 *
 * @category   Framework
 * @package    phpOMS\Utils\IO
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface ArchiveInterface
{
    /**
     * Create archive.
     *
     * @param string $sources     Files and directories to compress
     * @param string   $destination Output destination
     * @param bool     $overwrite   Overwrite if destination is existing
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function pack($sources, string $destination, bool $overwrite = true) : bool;
    
    /**
     * Unpack archive.
     *
     * @param string   $source     File to decompress
     * @param string   $destination Output destination
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function unpack(string $source, string $destination) : bool;
}
