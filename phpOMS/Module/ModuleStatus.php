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
namespace phpOMS\Module;

use phpOMS\Stdlib\Base\Enum;

/**
 * Module status enum.
 *
 * @category   phpOMS
 * @package    Module
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class ModuleStatus extends Enum
{
    /* public */ const ACTIVE = 1;
    /* public */ const INACTIVE = 2;
}
