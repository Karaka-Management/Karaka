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

namespace phpOMS\Business\Finance\Forecasting;

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
abstract class SmoothingType extends Enum
{
    /* public */ const CENTERED_MOVING_AVERAGE = 1;
}
