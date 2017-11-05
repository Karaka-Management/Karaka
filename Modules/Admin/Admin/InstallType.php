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

namespace Modules\Admin\Admin;

use phpOMS\Stdlib\Base\Enum;

/**
 * Tag type enum.
 *
 * @category   Framework
 * @package    phpOMS\Html
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class InstallType extends Enum
{
    /* public */ const PERMISSION = 0;
    /* public */ const GROUP = 1;
}
