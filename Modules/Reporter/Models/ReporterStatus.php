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
namespace Modules\Reporter\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Reporter status.
 *
 * @category   Framework
 * @package    phpOMS\Auth
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class ReporterStatus extends Enum
{
    /* public */ const INACTIVE = 0;

    /* public */ const ACTIVE = 1;
}
