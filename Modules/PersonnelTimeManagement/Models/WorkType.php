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
namespace Modules\PersonnelTimeManagement\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Work status enum.
 *
 * @category   Module
 * @package    Modules\HumanResources
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class WorkType extends Enum
{
    /* public */ const OFF = 0;

    /* public */ const WORKING = 1;

    /* public */ const LATE = 2;

    /* public */ const SICK = 3;

    /* public */ const VACATION = 4;

    /* public */ const REMOTE = 5;

    /* public */ const TRAVEL = 6;
}
