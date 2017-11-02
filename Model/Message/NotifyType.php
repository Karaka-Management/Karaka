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

namespace Model\Message;

use phpOMS\Stdlib\Base\Enum;

/**
 * NotifyType class.
 *
 * @category   Modules
 * @package    Model\Message
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class NotifyType extends Enum
{
    /* public */ const BINARY = 0;
    /* public */ const INFO = 1;
    /* public */ const WARNING = 2;
    /* public */ const ERROR = 3;
    /* public */ const FATAL = 4;
}
