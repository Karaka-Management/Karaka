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

namespace phpOMS\Business\Finance\Forecasting\ExponentialSmoothing;

use phpOMS\Stdlib\Base\Enum;

/**
 * Smoothing enum.
 *
 * @category   Framework
 * @package    phpOMS\Html
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class SeasonalType extends Enum
{
    /* public */ const ALL = 0;
    /* public */ const NONE = 1;
    /* public */ const ADDITIVE = 2;
    /* public */ const MULTIPLICATIVE = 4;
}
