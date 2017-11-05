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

namespace phpOMS\DataStorage\Database;

use phpOMS\Stdlib\Base\Enum;

/**
 * Database status enum.
 *
 * Possible database connection status
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class DatabaseStatus extends Enum
{
    /* public */ const OK               = 0; /* Database connection successful */
    /* public */ const MISSING_DATABASE = 1; /* Couldn't find database */
    /* public */ const MISSING_TABLE    = 2; /* One of the core tables couldn't be found */
    /* public */ const FAILURE          = 3; /* Unknown failure */
    /* public */ const READONLY         = 4; /* Database connection is in readonly (but ok) */
    /* public */ const CLOSED           = 5; /* Database connection closed */
}
