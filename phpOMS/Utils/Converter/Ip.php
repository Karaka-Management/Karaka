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

/**
 * Ip converter.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Ip
{
    /* public */ const IP_TABLE_ITERATIONS = 100;

    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    public static function ip2Float(string $ip) : float
    {
        $split = explode('.', $ip);

        return $split[0] * (256 ** 3) + $split[1] * (256 ** 2) + $split[2] * (256 ** 1) + $split[3];
    }
}