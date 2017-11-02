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
abstract class PressureType extends Enum
{
    /* public */ const PASCALS = 'Pa';
    /* public */ const BAR = 'bar';
    /* public */ const POUND_PER_SQUARE_INCH = 'psi';
    /* public */ const ATMOSPHERES = 'atm';
    /* public */ const INCHES_OF_MERCURY = 'inHg';
    /* public */ const INCHES_OF_WATER = 'inH20';
    /* public */ const MILLIMETERS_OF_WATER = 'mmH20';
    /* public */ const MILLIMETERS_OF_MERCURY = 'mmHg';
    /* public */ const MILLIBAR = 'mbar';
    /* public */ const KILOGRAM_PER_SQUARE_METER = 'kg/m2';
    /* public */ const NEWTONS_PER_METER_SQUARED = 'N/m2';
    /* public */ const POUNDS_PER_SQUARE_FOOT = 'psf';
    /* public */ const TORRS = 'Torr';
}
