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

namespace phpOMS\Business\Finance;

/**
 * Finance class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Loan
{
    /**
     * Balloon Loan - Payments
     *
     * @param float $PV      Present value
     * @param float $r       Rate per period
     * @param int   $n       Number of periods
     * @param float $balloon Balloon balance
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPaymentsOnBalloonLoan(float $PV, float $r, int $n, float $balloon = 0) : float
    {
        return ($PV - $balloon / pow(1 + $r, $n)) * $r / (1 - pow(1 + $r, -$n));
    }

    /**
     * Loan - Balloon Balance
     *
     * @param float $PV Present value (original balance)
     * @param float $P  Payment
     * @param float $r  Rate per payment
     * @param int   $n  Number of payments
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getBalloonBalanceOfLoan(float $PV, float $P, float $r, int $n) : float
    {
        return $PV * pow(1 + $r, $n) - $P * (pow(1 + $r, $n) - 1) / $r;
    }

    /**
     * Loan - Payment
     *
     * @param float $PV Present value (original balance)
     * @param float $r  Rate per period
     * @param int   $n  Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getLoanPayment(float $PV, float $r, int $n) : float
    {
        return $r * $PV / (1 - pow(1 + $r, -$n));
    }

    /**
     * Loan - Remaining Balance
     *
     * @param float $PV Present value (original balance)
     * @param float $P  Payment
     * @param float $r  Rate per payment
     * @param int   $n  Number of payments
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRemainingBalanceLoan(float $PV, float $P, float $r, int $n) : float
    {
        return $PV * pow(1 + $r, $n) - $P * (pow(1 + $r, $n) - 1) / $r;
    }

    /**
     * Loan to Deposit Ratio
     *
     * @param float $loans    Loans
     * @param float $deposits Deposits
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getLoanToDepositRatio(float $loans, float $deposits) : float
    {
        return $loans / $deposits;
    }

    /**
     * Loan to Value (LTV)
     *
     * @param float $loan       Loan amount
     * @param float $collateral Value of collateral
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getLoanToValueRatio(float $loan, float $collateral) : float
    {
        return $loan / $collateral;
    }

}
