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

namespace phpOMS\Validation\Finance;

use phpOMS\Stdlib\Base\Enum;

/**
 * Iban error type enum.
 *
 * @category   Framework
 * @package    phpOMS\Datatypes
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class IbanErrorType extends Enum
{
    /* public */ const INVALID_COUNTRY = 1;
    /* public */ const INVALID_LENGTH = 2;
    /* public */ const INVALID_CHECKSUM = 4;
    /* public */ const EXPECTED_ZERO = 8;
    /* public */ const EXPECTED_NUMERIC = 16;
}
