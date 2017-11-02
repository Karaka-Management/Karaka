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
 * Link type enum.
 *
 * @category   Modules
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class LinkType extends Enum
{
    /* public */ const CATEGORY = 0;

    /* public */ const LINK = 1;
}
