<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Account;

use phpOMS\Stdlib\Base\Enum;

/**
 * Accept status enum.
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class GroupStatus extends Enum
{
    /* public */ const ACTIVE   = 1;
    /* public */ const INACTIVE = 2;
    /* public */ const HIDDEN   = 4;
}
