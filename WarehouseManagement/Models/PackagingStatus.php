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
namespace Modules\Warehousing\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Packaging status enum.
 *
 * @category   Warehousing
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class PackagingStatus extends Enum
{
    /* public */ const PENDING = 0;

    /* public */ const PACKING = 1;

    /* public */ const PACKED = 2;

    /* public */ const SUSPENDED = 3;

    /* public */ const CANCELED = 4;
}
