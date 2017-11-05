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

namespace phpOMS\Router;

use phpOMS\Stdlib\Base\Enum;

/**
 * Route verb enum.
 *
 * @category   Framework
 * @package    phpOMS\Router
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class RouteVerb extends Enum
{
    /* public */ const GET = 1;
    /* public */ const PUT = 2;
    /* public */ const SET = 4;
    /* public */ const DELETE = 8;
    /* public */ const ANY = 16;
}
