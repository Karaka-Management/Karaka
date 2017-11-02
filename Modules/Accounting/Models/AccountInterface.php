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
namespace Modules\Accounting\Models;

/**
 * Account interface.
 *
 * @category   Module
 * @package    Accounting
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface AccountInterface
{

    /**
     * Get all groups.
     *
     * This function gets all groups in a range
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getBalance();

    /**
     * Close out account.
     *
     * @since  1.0.0
     */
    public function closeOut();
}
