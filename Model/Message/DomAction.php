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

namespace Model\Message;

use phpOMS\Stdlib\Base\Enum;

/**
 * DomAction class.
 *
 * @category   Modules
 * @package    Model\Message
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class DomAction extends Enum
{
    /* public */ const CREATE_BEFORE = 0;
    /* public */ const CREATE_AFTER = 1;
    /* public */ const DELETE = 2;
    /* public */ const REPLACE = 3;
    /* public */ const MODIFY = 4;
    /* public */ const SHOW = 5;
    /* public */ const HIDE = 6;
    /* public */ const ACTIVATE = 7;
    /* public */ const DEACTIVATE = 8;
   
}
