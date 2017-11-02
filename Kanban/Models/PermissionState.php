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

namespace Modules\Kanban\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Permision state enum.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class PermissionState extends Enum
{
    /* public */ const DASHBOARD = 1;
    /* public */ const BOARD = 2;
    /* public */ const COLUMN = 3;
    /* public */ const CARD = 4;
    /* public */ const LABEL = 4;
}
