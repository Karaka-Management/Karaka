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
namespace Modules\Reporter\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Reporter status.
 *
 * @category   Framework
 * @package    phpOMS\Auth
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class TemplateDataType extends Enum
{
    /* public */ const OTHER = 0;

    /* public */ const GLOBAL_DB = 1;

    /* public */ const GLOBAL_FILE = 2;
}
