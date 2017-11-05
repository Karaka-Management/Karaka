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

namespace phpOMS\Math\Number;

use phpOMS\Stdlib\Base\Enum;

/**
 * Number type enum.
 *
 * @category   Framework
 * @package    Utils
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class NumberType extends Enum
{
    /* public */ const N_INTEGER = 0;
    /* public */ const N_NATURAL = 1;
    /* public */ const N_EVEN = 2;
    /* public */ const N_UNEVEN = 4;
    /* public */ const N_PRIME = 8;
    /* public */ const N_REAL = 16;
    /* public */ const N_RATIONAL = 32;
    /* public */ const N_IRRATIONAL = 64;
    /* public */ const N_COMPLEX = 128;
}