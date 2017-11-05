<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Message\Http
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Message\Http;

use phpOMS\Stdlib\Base\Enum;

/**
 * OS type enum.
 *
 * OS Types which could be useful in order to create statistics or deliver OS specific content.
 *
 * @category   Framework
 * @package    phpOMS\Message\Http
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class OSType extends Enum
{
    /* public */ const WINDOWS_81     = 'windows nt 6.3'; /* Windows 8.1 */
    /* public */ const WINDOWS_8      = 'windows nt 6.2'; /* Windows 8 */
    /* public */ const WINDOWS_7      = 'windows nt 6.1'; /* Windows 7 */
    /* public */ const WINDOWS_VISTA  = 'windows nt 6.0'; /* Windows Vista */
    /* public */ const WINDOWS_SERVER = 'windows nt 5.2'; /* Windows Server 2003/XP x64 */
    /* public */ const WINDOWS_XP     = 'windows nt 5.1'; /* Windows XP */
    /* public */ const WINDOWS_XP_2   = 'windows xp'; /* Windows XP */
    /* public */ const WINDOWS_2000   = 'windows nt 5.0'; /* Windows 2000 */
    /* public */ const WINDOWS_ME     = 'windows me'; /* Windows ME */
    /* public */ const WINDOWS_98     = 'win98'; /* Windows 98 */
    /* public */ const WINDOWS_95     = 'win95'; /* Windows 95 */
    /* public */ const WINDOWS_311    = 'win16'; /* Windows 3.11 */
    /* public */ const MAC_OS_X       = 'macintosh'; /* Mac OS X */
    /* public */ const MAC_OS_X_2     = 'mac os x'; /* Mac OS X */
    /* public */ const MAC_OS_9       = 'mac_powerpc'; /* Mac OS 9 */
    /* public */ const LINUX          = 'linux'; /* Linux */
    /* public */ const UBUNTU         = 'ubuntu'; /* Ubuntu */
    /* public */ const IPHONE         = 'iphone'; /* IPhone */
    /* public */ const IPOD           = 'ipod'; /* IPod */
    /* public */ const IPAD           = 'ipad'; /* IPad */
    /* public */ const ANDROID        = 'android'; /* Android */
    /* public */ const BLACKBERRY     = 'blackberry'; /* Blackberry */
    /* public */ const MOBILE         = 'webos'; /* Mobile */
}
