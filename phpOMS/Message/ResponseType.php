<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Message
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Message;

use phpOMS\Stdlib\Base\Enum;

/**
 * Request type enum.
 *
 * @category   Framework
 * @package    phpOMS\Message
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class ResponseType extends Enum
{
    /* public */ const HTTP = 0; /* HTTP */
    /* public */ const SOCKET = 1; /* Socket */
    /* public */ const CONSOLE = 2; /* Console */
}
