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
 * Task status enum.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class TaskVisibility extends Enum
{
    /* public */ const TO  = 1;
    /* public */ const CC  = 2;
    /* public */ const BCC = 3;
}
