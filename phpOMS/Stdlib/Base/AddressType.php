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

namespace phpOMS\Stdlib\Base;

/**
 * Address type enum.
 *
 * @category   Framework
 * @package    phpOMS\Datatypes
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class AddressType extends Enum
{
    /* public */ const HOME = 1;
    /* public */ const BUSINESS = 2;
    /* public */ const SHIPPING = 3;
    /* public */ const BILLING = 4;
    /* public */ const WORK = 5;
    /* public */ const CONTRACT = 6;
    /* public */ const OTHER = 7;
}
