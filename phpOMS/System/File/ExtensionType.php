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

use phpOMS\Stdlib\Base\Enum;

/**
 * Database type enum.
 *
 * Database types that are supported by the application
 *
 * @category   Framework
 * @package    phpOMS\System
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class ExtensionType extends Enum
{
    /* public */ const UNKNOWN      = 1;
    /* public */ const CODE         = 2;
    /* public */ const AUDIO        = 4;
    /* public */ const VIDEO        = 8;
    /* public */ const TEXT         = 16;
    /* public */ const SPREADSHEET  = 32;
    /* public */ const PDF          = 64;
    /* public */ const ARCHIVE      = 128;
    /* public */ const PRESENTATION = 256;
    /* public */ const IMAGE        = 512;
}