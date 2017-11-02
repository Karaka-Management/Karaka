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
namespace Modules\Calendar\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Interval type type enum.
 *
 * @category   Calendar
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class IntervalType extends Enum
{
    /* public */ const ABSOLUTE = 1;

    /* public */ const RELATIVE = 2;
}
