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

namespace phpOMS\Business\Marketing;

/**
 * Marketing Metrics
 * 
 * This class provided basic marketing metric calculations
 *
 * @category   Framework
 * @package    phpOMS\Business
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Metrics {
    /**
     * Calculate customer retention
     * 
     * @param int $ce Customer at the end of the period
     * @param int $cn New customers during period
     * @param int $cs Customers at the start of the period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCustomerRetention(int $ce, int $cn, int $cs) : float
    {
        return ($ce - $cn) / $cs;
    }
}