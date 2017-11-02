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
namespace Modules\Navigation\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Navigation type enum.
 *
 * @category   Modules
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class NavigationType extends Enum
{
    /* public */ const TOP = 1;

    /* public */ const SIDE = 2;

    /* public */ const CONTENT = 3;

    /* public */ const TAB = 4;

    /* public */ const CONTENT_SIDE = 5;

    /* public */ const BOTTOM = 6;
}
