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
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class ContentPutMode extends Enum
{
    /* public */ const APPEND  = 1;
    /* public */ const PREPEND = 2;
    /* public */ const REPLACE = 4;
    /* public */ const CREATE  = 8;
}