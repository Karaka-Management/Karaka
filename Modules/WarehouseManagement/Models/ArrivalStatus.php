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
namespace Modules\Warehousing\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Arrival status enum.
 *
 * @category   Warehousing
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class ArrivalStatus extends Enum
{
    /* public */ const NONE = 0;

    /* public */ const PENDING = 1;

    /* public */ const CHECKING = 2;

    /* public */ const SORTING = 3;

    /* public */ const FINISHED = 4;
}
