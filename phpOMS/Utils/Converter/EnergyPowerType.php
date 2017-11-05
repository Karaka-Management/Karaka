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
abstract class EnergyPowerType extends Enum
{
    /* public */ const KILOWATT_HOUERS = 'kWh';
    /* public */ const MEGAWATT_HOUERS = 'MWh';
    /* public */ const KILOTONS = 'kt';
    /* public */ const JOULS = 'J';
    /* public */ const CALORIES = 'Cal';
    /* public */ const BTU = 'BTU';
    /* public */ const KILOJOULS = 'kJ';
    /* public */ const THERMEC = 'thmEC';
    /* public */ const NEWTON_METERS = 'Nm';
}
