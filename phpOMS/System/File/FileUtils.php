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

namespace phpOMS\System\File;

/**
 * Path exception class.
 *
 * @category   Framework
 * @package    phpOMS\System\File
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class FileUtils
{
    /* public */ const CODE_EXTENSION         = ['cpp', 'c', 'h', 'hpp', 'cs', 'css', 'htm', 'html', 'php', 'rb'];
    /* public */ const TEXT_EXTENSION         = ['doc', 'docx', 'txt', 'md', 'csv'];
    /* public */ const PRESENTATION_EXTENSION = ['ppt', 'pptx'];
    /* public */ const PDF_EXTENSION          = ['pdf'];
    /* public */ const ARCHIVE_EXTENSION      = ['zip', '7z', 'rar'];
    /* public */ const AUDIO_EXTENSION        = ['mp3', 'wav'];
    /* public */ const VIDEO_EXTENSION        = ['mp4'];
    /* public */ const SPREADSHEET_EXTENSION  = ['xls', 'xlsm'];
    /* public */ const IMAGE_EXTENSION        = ['png', 'gif', 'jpg', 'jpeg', 'tiff', 'bmp'];

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
     * Get file extension type.
     *
     * @param string $extension Extension string
     *
     * @return int Extension type
     *
     * @since  1.0.0
     */
    public static function getExtensionType(string $extension) : int
    {
        $extension = strtolower($extension);

        if (in_array($extension, self::CODE_EXTENSION)) {
            return ExtensionType::CODE;
        } elseif (in_array($extension, self::TEXT_EXTENSION)) {
            return ExtensionType::TEXT;
        } elseif (in_array($extension, self::PRESENTATION_EXTENSION)) {
            return ExtensionType::PRESENTATION;
        } elseif (in_array($extension, self::PDF_EXTENSION)) {
            return ExtensionType::PDF;
        } elseif (in_array($extension, self::ARCHIVE_EXTENSION)) {
            return ExtensionType::ARCHIVE;
        } elseif (in_array($extension, self::AUDIO_EXTENSION)) {
            return ExtensionType::AUDIO;
        } elseif (in_array($extension, self::VIDEO_EXTENSION)) {
            return ExtensionType::VIDEO;
        } elseif (in_array($extension, self::IMAGE_EXTENSION)) {
            return ExtensionType::IMAGE;
        } elseif (in_array($extension, self::SPREADSHEET_EXTENSION)) {
            return ExtensionType::SPREADSHEET;
        }

        return ExtensionType::UNKNOWN;
    }

    /**
     * Make file path absolute
     *
     * @param string $origPath File path
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function absolute(string $origPath) : string
    {
        if (!file_exists($origPath)) {
            $startsWithSlash = strpos($origPath, '/') === 0 ? '/' : '';

            $path = [];
            $parts = explode('/', $origPath);

            foreach ($parts as $part) {
                if (empty($part) || $part === '.') {
                    continue;
                }
          
                if ($part !== '..') {
                    $path[] = $part;
                } elseif (!empty($path)) {
                    array_pop($path);
                } else {
                    throw new PathException($origPath);
                }
            }
          
            return $startsWithSlash . implode('/', $path);
        }

        return realpath($origPath);
    }
}