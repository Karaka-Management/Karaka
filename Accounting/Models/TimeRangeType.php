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
namespace Modules\Accounting\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Time range type enum.
 *
 * @category   Modules
 * @package    Modules\Accounting\Models
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class TimeRangeType extends Enum
{
    /* public */ const ENTRY_DATE      = 0; /* Date of when the entry happened */
    /* public */ const DUE_DATE        = 1; /* Date of when the entry is due (only for invoices) */
    /* public */ const RECEIPT_DATE    = 2; /* Date of the receipt */
    /* public */ const ASSOCIATED_DATE = 3; /* Date of the association (e.g. when did the articles arrive) */
}
