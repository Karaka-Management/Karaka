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
 * Volume type enum.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class VolumeType extends Enum
{
    /* public */ const UK_GALLON = 'UK gal';
    /* public */ const US_GALLON_LIQUID = 'US gal lqd';
    /* public */ const US_GALLON_DRY = 'US gal dry';
    /* public */ const UK_PINT = 'pt';
    /* public */ const US_PINT_LIQUID = 'US pt lqd';
    /* public */ const US_PINT_DRY = 'US pt dry';
    /* public */ const US_QUARTS_LIQUID = 'US qt lqd';
    /* public */ const US_QUARTS_DRY = 'US qt dry';
    /* public */ const UK_QUARTS = 'UK qt dry';
    /* public */ const US_GILL = 'US gi';
    /* public */ const UK_GILL = 'UK gi';
    /* public */ const LITER = 'L';
    /* public */ const MICROLITER = 'mul';
    /* public */ const MILLILITER = 'mL';
    /* public */ const CENTILITER = 'cl';
    /* public */ const KILOLITER = 'kl';
    /* public */ const UK_BARREL = 'UK bbl';
    /* public */ const US_BARREL_DRY = 'US bbl dry';
    /* public */ const US_BARREL_LIQUID = 'US bbl lqd';
    /* public */ const US_BARREL_OIL = 'US bbl oil';
    /* public */ const US_BARREL_FEDERAL = 'US bbl fed';
    /* public */ const US_OUNCES = 'us fl oz';
    /* public */ const UK_OUNCES = 'uk fl oz';
    /* public */ const US_TEASPOON = 'US tsp';
    /* public */ const UK_TEASPOON = 'UK tsp';
    /* public */ const METRIC_TEASPOON = 'Metric tsp';
    /* public */ const US_TABLESPOON = 'US tblsp';
    /* public */ const UK_TABLESPOON = 'UK tblsp';
    /* public */ const METRIC_TABLESPOON = 'Metric tblsp';
    /* public */ const US_CUP = 'US cup';
    /* public */ const CAN_CUP = 'Can cup';
    /* public */ const METRIC_CUP = 'Metric cup';
    /* public */ const CUBIC_CENTIMETER = 'cm';
    /* public */ const CUBIC_MILLIMETER = 'mm';
    /* public */ const CUBIC_METER = 'm';
    /* public */ const CUBIC_INCH = 'in';
    /* public */ const CUBIC_FEET = 'ft';
    /* public */ const CUBIC_YARD = 'yd';
}
