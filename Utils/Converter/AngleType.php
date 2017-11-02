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

namespace phpOMS\Utils\Converter;

use phpOMS\Stdlib\Base\Enum;

/**
 * Speed type enum.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class AngleType extends Enum
{
    /* public */ const DEGREE = 'deg';
    /* public */ const RADIAN = 'rad';
    /* public */ const SECOND = 'arcsec';
    /* public */ const MINUTE = 'arcmin';
    /* public */ const MILLIRADIAN_US = 'mil (us ww2)';
    /* public */ const MILLIRADIAN_UK = 'mil (uk)';
    /* public */ const MILLIRADIAN_USSR = 'mil (ussr)';
    /* public */ const MILLIRADIAN_NATO = 'mil (nato)';
    /* public */ const GRADIAN = 'g';
    /* public */ const CENTRAD = 'crad';
}
