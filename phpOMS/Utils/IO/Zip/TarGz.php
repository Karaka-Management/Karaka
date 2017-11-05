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
namespace phpOMS\Utils\IO\Zip;
/**
 * Zip class for handling zip files.
 *
 * Providing basic zip support
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class TarGz implements ArchiveInterface
{
    /**
     * {@inheritdoc}
     */
    public static function pack($source, string $destination, bool $overwrite = true) : bool
    {
        if (!Tar::pack($source, $destination . '.tmp', $overwrite)) {
            return false;
        }

        $pack = Gz::pack($destination . '.tmp', $destination, $overwrite);
        unlink($destination . '.tmp');

        return $pack;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function unpack(string $source, string $destination) : bool
    {
        if (!Gz::unpack($source, $destination . '.tmp')) {
            return false;
        }

        $unpacked = Tar::unpack($destination . '.tmp', $destination);
        unlink($destination . '.tmp');

        return $unpacked;
    }
}
