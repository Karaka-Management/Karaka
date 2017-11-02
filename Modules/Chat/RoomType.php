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
namespace Modules\Chat;

use phpOMS\Stdlib\Base\Enum;

/**
 * Room type enum.
 *
 * @category   Chat
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class RoomType extends Enum
{
    /* public */ const PUBLIC_CHAT = 0;

    /* public */ const PRIVATE_CHAT = 1;

    /* public */ const TEMP_CHAT = 2;
}
