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

namespace phpOMS\Stdlib\Queue;

use phpOMS\Stdlib\Base\Enum;

/**
 * Account type enum.
 *
 * @category   Framework
 * @package    phpOMS\Stdlib
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class PriorityMode extends Enum
{
    /* public */ const FIFO = 1;
    /* public */ const LIFO = 2;
    /* public */ const EARLIEST_DEADLINE = 4;
    /* public */ const SHORTEST_JOB = 8;
    /* public */ const HIGHEST = 16;
    /* public */ const LOWEST = 32;
}
