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
namespace Modules\Calendar\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Accept status enum.
 *
 * @category   Calendar
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class AcceptStatus extends Enum
{
    /* public */ const ACCEPTED = 0;

    /* public */ const DENIED = 1;
}
