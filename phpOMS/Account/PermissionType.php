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
 * Permission type enum.
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class PermissionType extends Enum
{
    /* public */ const NONE       = 1;
    /* public */ const READ       = 2;
    /* public */ const CREATE     = 4;
    /* public */ const MODIFY     = 8;
    /* public */ const DELETE     = 16;
    /* public */ const PERMISSION = 32;
}
