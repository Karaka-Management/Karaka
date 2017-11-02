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
namespace Modules\Tasks\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Task priority enum.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class TaskPriority extends Enum
{
    /* public */ const VLOW = 1;

    /* public */ const LOW = 2;

    /* public */ const MEDIUM = 3;

    /* public */ const HIGH = 4;

    /* public */ const VHIGH = 5;
}
