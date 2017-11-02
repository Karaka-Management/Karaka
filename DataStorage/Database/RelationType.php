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

namespace phpOMS\DataStorage\Database;

use phpOMS\Stdlib\Base\Enum;

/**
 * Database type enum.
 *
 * Database types that are supported by the application
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class RelationType extends Enum
{
    /* public */ const NONE       = 1;
    /* public */ const NEWEST     = 2;
    /* public */ const BELONGS_TO = 4;
    /* public */ const OWNS_ONE   = 8;
    /* public */ const HAS_MANY   = 16;
    /* public */ const ALL        = 32;
    /* public */ const REFERENCE  = 64;
}
