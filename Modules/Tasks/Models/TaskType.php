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
 * Task type enum.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class TaskType extends Enum
{
    /* public */ const TEMPLATE = 1;
    /* public */ const SINGLE   = 2;
    /* public */ const HIDDEN   = 3;
}
