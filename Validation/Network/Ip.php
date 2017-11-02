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

namespace phpOMS\Validation\Network;

use phpOMS\Validation\ValidatorAbstract;

/**
 * Validator abstract.
 *
 * @category   Validation
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Ip extends ValidatorAbstract
{

    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function isValid($value, array $constraints = null) : bool
    {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Validate IPv6
     *
     * @param mixed $value to validate
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isValidIpv6($value) : bool
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Validate IPv4
     *
     * @param mixed $value to validate
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isValidIpv4($value) : bool
    {
        return filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }
}
