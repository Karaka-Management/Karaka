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
namespace Modules\Admin\Models;

use phpOMS\Account\PermissionAbstract;

/**
 * InfoManager class.
 *
 * Handling the info files for modules
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class AccountPermission extends PermissionAbstract
{
    private $account = 0;

    public function getAccount() : int
    {
        return $account;
    }
}
