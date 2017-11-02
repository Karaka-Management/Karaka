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

namespace phpOMS\Math\Statistic\Forecast;

use phpOMS\Stdlib\Base\Enum;

/**
 * Prediction interval multiplier.
 *
 * @category   Framework
 * @package    phpOMS\Datatypes
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class ForecastIntervalMultiplier extends Enum
{
    /* public */ const P_50 = 0.67;
    /* public */ const P_55 = 0.76;
    /* public */ const P_60 = 0.84;
    /* public */ const P_65 = 0.93;
    /* public */ const P_70 = 1.04;
    /* public */ const P_75 = 1.15;
    /* public */ const P_80 = 1.28;
    /* public */ const P_85 = 1.44;
    /* public */ const P_90 = 1.64;
    /* public */ const P_95 = 1.96;
    /* public */ const P_96 = 2.05;
    /* public */ const P_97 = 2.17;
    /* public */ const P_98 = 2.33;
    /* public */ const P_99 = 2.58;
}
