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
namespace Modules\Billing\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Task type enum.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class InvoiceStatus extends Enum
{
    /* public */ const ACTIVE = 1;
    /* public */ const ARCHIVED  = 2;
    /* public */ const DELETED   = 3;
}
