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

namespace phpOMS\Utils\Converter;

use phpOMS\Stdlib\Base\Enum;

/**
 * Speed type enum.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class SpeedType extends Enum
{
    /* public */ const MILES_PER_DAY = 'mpd';
    /* public */ const MILES_PER_HOUR = 'mph';
    /* public */ const MILES_PER_MINUTE = 'mpm';
    /* public */ const MILES_PER_SECOND = 'mps';
    /* public */ const KILOMETERS_PER_DAY = 'kpd';
    /* public */ const KILOMETERS_PER_HOUR = 'kph';
    /* public */ const KILOMETERS_PER_MINUTE = 'kpm';
    /* public */ const KILOMETERS_PER_SECOND = 'kps';
    /* public */ const METERS_PER_DAY = 'md';
    /* public */ const METERS_PER_HOUR = 'mh';
    /* public */ const METERS_PER_MINUTE = 'mm';
    /* public */ const METERS_PER_SECOND = 'ms';
    /* public */ const CENTIMETERS_PER_DAY = 'cpd';
    /* public */ const CENTIMETERS_PER_HOUR = 'cph';
    /* public */ const CENTIMETERS_PER_MINUTES = 'cpm';
    /* public */ const CENTIMETERS_PER_SECOND = 'cps';
    /* public */ const MILLIMETERS_PER_DAY = 'mmpd';
    /* public */ const MILLIMETERS_PER_HOUR = 'mmph';
    /* public */ const MILLIMETERS_PER_MINUTE = 'mmpm';
    /* public */ const MILLIMETERS_PER_SECOND = 'mmps';
    /* public */ const YARDS_PER_DAY = 'ypd';
    /* public */ const YARDS_PER_HOUR = 'yph';
    /* public */ const YARDS_PER_MINUTE = 'ypm';
    /* public */ const YARDS_PER_SECOND = 'yps';
    /* public */ const INCHES_PER_DAY = 'ind';
    /* public */ const INCHES_PER_HOUR = 'inh';
    /* public */ const INCHES_PER_MINUTE = 'inm';
    /* public */ const INCHES_PER_SECOND = 'ins';
    /* public */ const FEET_PER_DAY = 'ftd';
    /* public */ const FEET_PER_HOUR = 'fth';
    /* public */ const FEET_PER_MINUTE = 'ftm';
    /* public */ const FEET_PER_SECOND = 'fts';
    /* public */ const MACH = 'mach';
    /* public */ const KNOTS = 'knots';
}
