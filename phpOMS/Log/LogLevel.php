<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Log
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Log;

use phpOMS\Stdlib\Base\Enum;

/**
 * Log level enum.
 *
 * @category   Framework
 * @package    phpOMS\Log
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class LogLevel extends Enum
{
    /* public */ const EMERGENCY = 'emergency';
    /* public */ const ALERT = 'alert';
    /* public */ const CRITICAL = 'critical';
    /* public */ const ERROR = 'error';
    /* public */ const WARNING = 'warning';
    /* public */ const NOTICE = 'notice';
    /* public */ const INFO = 'info';
    /* public */ const DEBUG = 'debug';
}
