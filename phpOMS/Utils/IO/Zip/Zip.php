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

use phpOMS\System\File\FileUtils;
use phpOMS\Utils\StringUtils;

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
class Zip implements ArchiveInterface
{

    /**
     * {@inheritdoc}
     */
    public static function pack($sources, string $destination, bool $overwrite = true) : bool
    {
        $destination = FileUtils::absolute(str_replace('\\', '/', $destination));

        if (!$overwrite && file_exists($destination)) {
            return false;
        }

        $zip = new \ZipArchive();
        if (!$zip->open($destination, $overwrite ? \ZipArchive::CREATE | \ZipArchive::OVERWRITE : \ZipArchive::CREATE)) {
            return false;
        }

        /** @var array $sources */
        foreach ($sources as $source => $relative) {
            $source = str_replace('\\', '/', realpath($source));

            if (!file_exists($source)) {
                continue;
            }

            if (is_dir($source)) {
                $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

                foreach ($files as $file) {
                    $file = str_replace('\\', '/', $file);

                    /* Ignore . and .. */
                    if (in_array(mb_substr($file, mb_strrpos($file, '/') + 1), ['.', '..'])) {
                        continue;
                    }

                    $absolute = realpath($file);
                    $absolute = str_replace('\\', '/', $absolute);
                    $dir = str_replace($source . '/', '', $relative . '/' . $absolute);

                    if (is_dir($absolute)) {
                        $zip->addEmptyDir($dir . '/');
                    } elseif (is_file($absolute)) {
                        $zip->addFile($absolute, $dir);
                    }
                }
            } elseif (is_file($source)) {
                $zip->addFile($source, $relative);
            }
        }

        return $zip->close();
    }
    
    /**
     * {@inheritdoc}
     */
    public static function unpack(string $source, string $destination) : bool
    {
        if (!file_exists($source)) {
            return false;
        }

        $destination = str_replace('\\', '/', $destination);
        $destination = rtrim($destination, '/');

        $zip = new \ZipArchive();
        if (!$zip->open($source)) {
            return false;
        }
        
        $zip->extractTo($destination . '/');
        
        return $zip->close();
    }
}
