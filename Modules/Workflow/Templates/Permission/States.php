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
namespace Modules\Workflow\Templates\Permission;

use phpOMS\Stdlib\Base\Enum;

/**
 * Task status enum.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class States extends Enum
{
    /* public */ const DEFAULT = 0;
    /* public */ const PENDING = 1;
    /* public */ const APPROVED = 2;
    /* public */ const DISMISSED = 3;
}
