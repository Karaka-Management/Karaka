<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Business
 * @package    phpOMS
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types = 1);

namespace phpOMS\Business\Finance;

use phpOMS\Math\Statistic\Average;
use phpOMS\Math\Matrix\Exception\InvalidDimensionException;

/**
 * Finance class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class FinanceFormulas
{

    /**
     * Annual Percentage Yield
     *
     * @latex  APY = \left(1+ \frac{r}{n}\right)^{n}-1
     *
     * @param float $r Stated annual interest rate
     * @param int   $n number of times compounded
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAnnualPercentageYield(float $r, int $n) : float
    {
        return pow(1 + $r / $n, $n) - 1;
    }

    /**
     * Annual Percentage Yield
     *
     * @latex  r = \left(\left(APY + 1\right)^{\frac{1}{n}} - 1\right) \cdot n
     *
     * @param float $apy Annual percentage yield
     * @param int   $n   Number of times compounded
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getStateAnnualInterestRateOfAPY(float $apy, int $n) : float
    {
        return (pow($apy + 1, 1 / $n) - 1) * $n;
    }

    /**
     * Annuity - Future Value
     *
     * @param float $P Periodic payment
     * @param float $r Stated annual interest rate
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFutureValueOfAnnuity(float $P, float $r, int $n) : float
    {
        return $P * (pow(1 + $r, $n) - 1) / $r;
    }

    /**
     * Annuity - Future Value
     *
     * @param float $fva Future value annuity
     * @param float $P   Periodic payment
     * @param float $r   Stated annual interest rate
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getNumberOfPeriodsOfFVA(float $fva, float $P, float $r) : int
    {
        return (int) round(log($fva / $P * $r + 1) / log(1 + $r));
    }

    /**
     * Future Value
     *
     * @param float $fva Future value annuity
     * @param float $r   Stated annual interest rate
     * @param int   $n   Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPeriodicPaymentOfFVA(float $fva, float $r, int $n) : float
    {
        return $fva / ((pow(1 + $r, $n) - 1) / $r);
    }


    /**
     * Annuity - Future Value w/ Continuous Compounding
     *
     * @param float $cf Cach flow
     * @param float $r  Rate
     * @param int   $t  Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFutureValueOfAnnuityConinuousCompounding(float $cf, float $r, int $t) : float
    {
        return $cf * (exp($r * $t) - 1) / (exp($r) - 1);
    }

    /**
     * Annuity - Future Value w/ Continuous Compounding
     *
     * @param float $fvacc Future value annuity continuous compoinding
     * @param float $r     Rate
     * @param int   $t     Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCashFlowOfFVACC(float $fvacc, float $r, int $t) : float
    {
        return $fvacc / ((exp($r * $t) - 1) / (exp($r) - 1));
    }

    /**
     * Annuity - Future Value w/ Continuous Compounding
     *
     * @param float $fvacc Future value annuity continuous compoinding
     * @param float $cf    Cach flow
     * @param float $r     Rate
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getTimeOfFVACC(float $fvacc, float $cf, float $r) : int
    {
        return (int) round(log($fvacc / $cf * (exp($r) - 1) + 1) / $r);
    }

    /**
     * Annuity - Payment (PV)
     *
     * @param float $pv Present value
     * @param float $r  Rate per period
     * @param int   $n  Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAnnuityPaymentPV(float $pv, float $r, int $n) : float
    {
        return $r * $pv / (1 - pow(1 + $r, -$n));
    }

    /**
     * Annuity - Payment (PV)
     *
     * @param float $p  Payment
     * @param float $pv Present value
     * @param float $r  Rate per period
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getNumberOfAPPV(float $p, float $pv, float $r) : int
    {
        return (int) round(-log(-($r * $pv / $p - 1)) / log(1 + $r));
    }

    /**
     * Annuity - Payment (PV)
     *
     * @param float $p Payment
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueOfAPPV(float $p, float $r, int $n) : float
    {
        return $p / $r * (1 - pow(1 + $r, -$n));
    }

    /**
     * Annuity - Payment (FV)
     *
     * @param float $fv Present value
     * @param float $r  Rate per period
     * @param int   $n  Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAnnuityPaymentFV(float $fv, float $r, int $n) : float
    {
        return $r * $fv / (pow(1 + $r, $n) - 1);
    }

    /**
     * Annuity - Payment (FV)
     *
     * @param float $p  Payment
     * @param float $fv Present value
     * @param float $r  Rate per period
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getNumberOfAPFV(float $p, float $fv, float $r) : int
    {
        return (int) round(log($fv * $r / $p + 1) / log(1 + $r));
    }

    /**
     * Annuity - Payment (FV)
     *
     * @param float $p Payment
     * @param float $r Present value
     * @param int   $n Rate per period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFutureValueOfAPFV(float $p, float $r, int $n) : float
    {
        return $p / $r * (pow(1 + $r, $n) - 1);
    }

    /**
     * Annuity - Payment Factor (PV)
     *
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAnnutiyPaymentFactorPV(float $r, int $n) : float
    {
        return $r / (1 - pow(1 + $r, -$n));
    }

    /**
     * Annuity - Payment Factor (PV)
     *
     * @param float $p Payment factor
     * @param float $r Rate per period
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getNumberOfAPFPV(float $p, float $r) : int
    {
        return (int) round(-log(-($r / $p - 1)) / log(1 + $r));
    }

    /**
     * Annuity - Present Value
     *
     * @param float $P Periodic payment
     * @param float $r Stated annual interest rate
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueOfAnnuity(float $P, float $r, int $n) : float
    {
        return $P * (1 - pow(1 + $r, -$n)) / $r;
    }

    /**
     * Annuity - Present Value
     *
     * @param float $pva Future value annuity
     * @param float $P   Periodic payment
     * @param float $r   Stated annual interest rate
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getNumberOfPeriodsOfPVA(float $pva, float $P, float $r) : int
    {
        return (int) round(-log(-($pva / $P * $r - 1)) / log(1 + $r));
    }

    /**
     * Annuity - Present Value
     *
     * @param float $pva Future value annuity
     * @param float $r   Stated annual interest rate
     * @param int   $n   Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPeriodicPaymentOfPVA(float $pva, float $r, int $n) : float
    {
        return $pva / ((1 - pow(1 + $r, -$n)) / $r);
    }

    /**
     * Annuity - PV Factor
     *
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueAnnuityFactor(float $r, int $n) : float
    {
        return (1 - pow(1 + $r, -$n)) / $r;
    }

    /**
     * Annuity - PV Factor
     *
     * @param float $p Payment factor
     * @param float $r Rete per period
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getPeriodsOfPVAF(float $p, float $r) : int
    {
        return (int) round(-log(-($p * $r - 1)) / log(1 + $r));
    }

    /**
     * Annuity Due - Present Value
     *
     * @param float $P Periodic payment
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueOfAnnuityDue(float $P, float $r, int $n) : float
    {
        return $P + $P * ((1 - pow(1 + $r, -($n - 1))) / $r);
    }

    /**
     * Annuity Due - Present Value
     *
     * Using alternative formula for PV
     *
     * @param float $PV Present value
     * @param float $r  Rate per period
     * @param int   $n  Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPeriodicPaymentOfPVAD(float $PV, float $r, int $n) : float
    {
        return $PV * $r / (1 - pow(1 + $r, -$n)) * 1 / (1 + $r);
    }

    /**
     * Annuity Due - Present Value
     *
     * @param float $PV Present value
     * @param float $P  Periodic payment
     * @param float $r  Rate per period
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getPeriodsOfPVAD(float $PV, float $P, float $r) : int
    {
        return (int) round(-(log(-($PV - $P) / $P * $r + 1) / log(1 + $r) - 1));
    }

    /**
     * Annuity Due - Future Value
     *
     * @param float $P Periodic payment
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFutureValueOfAnnuityDue(float $P, float $r, int $n) : float
    {
        return (1 + $r) * $P * (pow(1 + $r, $n) - 1) / $r;
    }

    /**
     * Annuity Due - Future Value
     *
     * @param float $FV Future value
     * @param float $r  Rate per period
     * @param int   $n  Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPeriodicPaymentOfFVAD(float $FV, float $r, int $n) : float
    {
        return $FV / ((1 + $r) * ((pow(1 + $r, $n) - 1) / $r));
    }

    /**
     * Annuity Due - Future Value
     *
     * @param float $FV Future value
     * @param float $P  Periodic payment
     * @param float $r  Rate per period
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getPeriodsOfFVAD(float $FV, float $P, float $r) : int
    {
        return (int) round(log($FV / (1 + $r) / $P * $r + 1) / log(1 + $r));
    }

    /**
     * Asset to Sales Ratio
     *
     * @param float $assets  Assets
     * @param float $revenue Revenue
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAssetToSalesRatio(float $assets, float $revenue) : float
    {
        return $assets / $revenue;
    }

    /**
     * Asset Turnover Ratio
     *
     * @param float $assets  Assets
     * @param float $revenue Revenue
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAssetTurnoverRatio(float $assets, float $revenue) : float
    {
        return $revenue / $assets;
    }

    /**
     * Average Collection Period
     *
     * @param float $receivables Receivables turnover (use getReceivablesTurnover)
     * @param int   $period      Period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getAverageCollectionPeriod(float $receivables, int $period = 365) : float
    {
        return $period / $receivables;
    }

    /**
     * Receivables Turnover
     *
     * @param float $sales       Sales in period
     * @param float $receivables Avg. account receivables
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getReceivablesTurnover(float $sales, float $receivables) : float
    {
        return $sales / $receivables;
    }

    /**
     * Compound Interest
     *
     * @param float $P Principal
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCompoundInterest(float $P, float $r, int $n) : float
    {
        return $P * (pow(1 + $r, $n) - 1);
    }

    /**
     * Principal of compound interest
     *
     * @param float $C Compound interest
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPrincipalOfCompundInterest(float $C, float $r, int $n) : float
    {
        return $C / (pow(1 + $r, $n) - 1);
    }

    /**
     * Principal of compound interest
     *
     * @param float $P Principal
     * @param float $C Compound interest
     * @param float $r Rate per period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPeriodsOfCompundInterest(float $P, float $C, float $r) : float
    {
        return log($C / $P + 1) / log(1 + $r);
    }

    /**
     * Continuous Compounding
     *
     * @param float $P Principal
     * @param float $r Rate per period
     * @param int   $t Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getContinuousCompounding(float $P, float $r, int $t) : float
    {
        return $P * exp($r * $t);
    }

    /**
     * Continuous Compounding
     *
     * @param float $C Compounding
     * @param float $r Rate per period
     * @param int   $t Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPrincipalOfContinuousCompounding(float $C, float $r, int $t) : float
    {
        return $C / exp($r * $t);
    }

    /**
     * Continuous Compounding
     *
     * @param float $P Principal
     * @param float $C Compounding
     * @param float $r Rate per period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPeriodsOfContinuousCompounding(float $P, float $C, float $r) : float
    {
        return log($C / $P) / $r;
    }

    /**
     * Continuous Compounding
     *
     * @param float $P Principal
     * @param float $C Compounding
     * @param float $t Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRateOfContinuousCompounding(float $P, float $C, float $t) : float
    {
        return log($C / $P) / $t;
    }

    /**
     * Current Ratio
     *
     * @param float $assets      Assets
     * @param float $liabilities Liabilities
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCurrentRatio(float $assets, float $liabilities) : float
    {
        return $assets / $liabilities;
    }

    /**
     * Days in Inventory
     *
     * @param float $inventory Inventory turnover
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDaysInInventory(float $inventory) : float
    {
        return 365 / $inventory;
    }

    /**
     * Debt Coverage Ratio
     *
     * @param float $income  Net operating income
     * @param float $service Debt service
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDebtCoverageRatio(float $income, float $service) : float
    {
        return $income / $service;
    }

    /**
     * Debt Ratio
     *
     * @param float $liabilities Total liabilities
     * @param float $assets      Total assets
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDebtRatio(float $liabilities, float $assets) : float
    {
        return $liabilities / $assets;
    }

    /**
     * Debt to Equity Ratio (D/E)
     *
     * @param float $liabilities Total liabilities
     * @param float $equity      Total assets
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDebtToEquityRatio(float $liabilities, float $equity) : float
    {
        return $liabilities / $equity;
    }

    /**
     * Debt to Income Ratio (D/I)
     *
     * @param float $payments Periodic payments
     * @param float $income   Periodic income
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDebtToIncomeRatio(float $payments, float $income) : float
    {
        return $payments / $income;
    }

    /**
     * Discounted Payback Period
     *
     * @param float $CF Periodic cash flow
     * @param float $O1 Initial Investment (Outflow)
     * @param float $r  Rate
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDiscountedPaybackPeriod(float $CF, float $O1, float $r) : float
    {
        return log(1 / (1 - $O1 * $r / $CF)) / log(1 + $r);
    }

    /**
     * Doubling Time
     *
     * @param float $r Rate of return
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDoublingTime(float $r) : float
    {
        return log(2) / log(1 + $r);
    }

    /**
     * Get rate to dobule
     *
     * @param float $t Time in which to double investment
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDoublingRate(float $t) : float
    {
        return exp(log(2) / $t) - 1;
    }

    /**
     * Doubling Time - Continuous Compounding
     *
     * @param float $r Rate of return
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDoublingTimeContinuousCompounding(float $r) : float
    {
        return log(2) / $r;
    }

    /**
     * Equivalent Annual Annuity
     *
     * @param float $NPV Net present value
     * @param float $r   Rate per period
     * @param int   $n   Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getEquivalentAnnualAnnuity(float $NPV, float $r, int $n) : float
    {
        return $r * $NPV / (1 - pow(1 + $r, -$n));
    }

    /**
     * Equivalent Annual Annuity
     *
     * @param float $C   Equivalent annuity cash flow
     * @param float $NPV Net present value
     * @param float $r   Rate per period
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getPeriodsOfEAA(float $C, float $NPV, float $r) : int
    {
        return (int) round(log(-$r * $NPV / $C + 1) / log(1 + $r));
    }

    /**
     * Equivalent Annual Annuity
     *
     * @param float $C Net present value
     * @param float $r Rate per period
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getNetPresentValueOfEAA(float $C, float $r, int $n) : float
    {
        return $C / $r * (1 - pow(1 + $r, -$n));
    }

    /**
     * Free Cash Flow to Equity (FCFE)
     *
     * @param float $income    Net income
     * @param float $depamo    Depreciation & amortisation
     * @param float $capital   Capital expenses
     * @param float $wc        Change in working capital
     * @param float $borrowing Net Borrowing
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFreeCashFlowToEquity(float $income, float $depamo, float $capital, float $wc, float $borrowing) : float
    {
        return $income + $depamo - $capital - $wc + $borrowing;
    }

    /**
     * Free Cash Flow to Firm (FCFF)
     *
     * @param float $ebit    EBIT
     * @param float $t       Tax rate
     * @param float $depamo  Depreciation & amortisation
     * @param float $capital Capital expenses
     * @param float $wc      Change in working capital
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFreeCashFlowToFirm(float $ebit, float $t, float $depamo, float $capital, float $wc) : float
    {
        return $ebit * (1 - $t) + $depamo - $capital - $wc;
    }

    /**
     * Future Value
     *
     * @param float $C Cash flow at period 0
     * @param float $r Rate of return
     * @param int   $n Numbers of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFutureValue(float $C, float $r, int $n) : float
    {
        return $C * pow(1 + $r, $n);
    }

    /**
     * Future Value - Continuous Compounding
     *
     * @param float $PV Present value
     * @param float $r  Rate of return
     * @param int   $t  Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFutureValueContinuousCompounding(float $PV, float $r, int $t) : float
    {
        return $PV * exp($r * $t);
    }

    /**
     * Future Value Factor
     *
     * @param float $r Rate of return
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getFutureValueFactor(float $r, int $n) : float
    {
        return pow(1 + $r, $n);
    }

    /**
     * Future Value Factor
     *
     * @param array $r Rate of return
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getGeometricMeanReturn(array $r) : float
    {
        return Average::geometricMean($r) - 1;
    }

    /**
     * Growing Annuity - Future Value
     *
     * @param float $P First payment
     * @param float $r Rate of return
     * @param float $g Growth rate
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getGrowingAnnuityFV(float $P, float $r, float $g, int $n) : float
    {
        return $P * (pow(1 + $r, $n) - pow(1 + $g, $n)) / ($r - $g);
    }

    /**
     * Growing Annuity - Payment (PV)
     *
     * @param float $PV Present value
     * @param float $r  Rate of return
     * @param float $g  Growth rate
     * @param int   $n  Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getGrowingAnnuityPaymentPV(float $PV, float $r, float $g, int $n) : float
    {
        return $PV * ($r - $g) / (1 - pow((1 + $g) / (1 + $r), $n));
    }

    /**
     * Growing Annuity - Payment (FV)
     *
     * @param float $FV Present value
     * @param float $r  Rate of return
     * @param float $g  Growth rate
     * @param int   $n  Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getGrowingAnnuityPaymentFV(float $FV, float $r, float $g, int $n) : float
    {
        return $FV * ($r - $g) / (pow(1 + $r, $n) - pow(1 + $g, $n));
    }

    /**
     * Growing Annuity - Present Value
     *
     * @param float $P First payment
     * @param float $r Rate of return
     * @param float $g Growth rate
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getGrowingAnnuityPV(float $P, float $r, float $g, int $n) : float
    {
        return $P / ($r - $g) * (1 - pow((1 + $g) / (1 + $r), $n));
    }

    /**
     * Growing Perpetuity - Present Value
     *
     * @param float $D Dividend or coupon at period 1
     * @param float $r Rate of return
     * @param float $g Growth rate
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getGrowingPerpetuityPV(float $D, float $r, float $g) : float
    {
        return $D / ($r - $g);
    }

    /**
     * Interest Coverage Ratio
     *
     * @param float $ebit    EBIT
     * @param float $expense Interest expense
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getInterestCoverageRatio(float $ebit, float $expense) : float
    {
        return $ebit / $expense;
    }

    /**
     * Inventory Turnover Ratio
     *
     * @param float $sales     Sales
     * @param float $inventory Inventory
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getInventoryTurnoverRatio(float $sales, float $inventory) : float
    {
        return $sales / $inventory;
    }

    /**
     * Net Present Value
     *
     * @param array $C Cash flow ($C[0] = initial investment)
     * @param float $r Discount rate
     *
     * @return float
     *
     * @throws InvalidDimensionException Throws this exception if the length of the array is 0
     *
     * @since  1.0.0
     */
    public static function getNetPresentValue(array $C, float $r) : float
    {
        $count = count($C);

        if ($count === 0) {
            throw new InvalidDimensionException($count);
        }

        $npv = -$C[0];

        for ($i = 1; $i < $count; $i++) {
            $npv += $C[$i] / pow(1 + $r, $i);
        }

        return $npv;
    }

    /**
     * Net Profit Margin
     *
     * @param float $income Net income
     * @param float $sales  Sales revenue
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getNetProfitMargin(float $income, float $sales) : float
    {
        return $income / $sales;
    }

    /**
     * Net Working Capital
     *
     * @param float $assets      Current assets
     * @param float $liabilities Current liabilities
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getNetWorkingCapital(float $assets, float $liabilities) : float
    {
        return $assets - $liabilities;
    }

    /**
     * Number of Periods - PV & FV
     *
     * @param float $FV Future value
     * @param float $PV Present value
     * @param float $r  Rate per period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getNumberOfPeriodsPVFV(float $FV, float $PV, float $r) : float
    {
        return log($FV / $PV) / log(1 + $r);
    }

    /**
     * Payback Period
     *
     * @param float $investment Initial investment
     * @param float $cash       Periodic cash flow
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPaybackPeriod(float $investment, float $cash) : float
    {
        return $investment / $cash;
    }

    /**
     * Perpetuity
     *
     * @param float $D Dividend or coupon per period
     * @param float $r Discount rate
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueOfPerpetuity(float $D, float $r) : float
    {
        return $D / $r;
    }

    /**
     * Number of Periods - PV & FV
     *
     * @param float $C Cash flow at period 1
     * @param float $r Rate of return
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValue(float $C, float $r, int $n) : float
    {
        return $C / pow(1 + $r, $n);
    }

    /**
     * PV - Continuous Compounding
     *
     * @param float $C Cash flow
     * @param float $r Rate of return
     * @param int   $t Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueContinuousCompounding(float $C, float $r, int $t) : float
    {
        return $C / exp($r * $t);
    }

    /**
     * Present Value Factor
     *
     * @param float $r Rate of return
     * @param int   $n Number of periods
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueFactor(float $r, int $n) : float
    {
        return 1 / pow(1 + $r, $n);
    }

    /**
     * Quick Ratio
     *
     * @param float $assets      Quick assets (current assets - inventory)
     * @param float $liabilities Current liabilities
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getQuickRatio(float $assets, float $liabilities) : float
    {
        return $assets / $liabilities;
    }

    /**
     * Rate of Inflation
     *
     * @param float $newCPI Consumer price index new
     * @param float $oldCPI Consumer price index old
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRateOfOnflation(float $newCPI, float $oldCPI) : float
    {
        return $newCPI / $oldCPI - 1;
    }

    /**
     * Real Rate of Return
     *
     * @param float $nominal   Nominal rate
     * @param float $inflation Inflation rate
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRealRateOfReturn(float $nominal, float $inflation) : float
    {
        return (1 + $nominal) / (1 + $inflation) - 1;
    }

    /**
     * Receivables Turnover Ratio
     *
     * @param float $sales      Sales revenue
     * @param float $receivable Avg. accounts receivable
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getReceivablesTurnoverRatio(float $sales, float $receivable) : float
    {
        return $sales / $receivable;
    }

    /**
     * Receivables Turnover Ratio
     *
     * @param float $income    Net income
     * @param float $dividends Dividends
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRetentionRatio(float $income, float $dividends) : float
    {
        return ($income - $dividends) / $income;
    }

    /**
     * Return on Assets (ROA)
     *
     * @param float $income Net income
     * @param float $assets Avg. total assets
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getReturnOnAssets(float $income, float $assets) : float
    {
        return $income / $assets;
    }

    /**
     * Return on Equity (ROE)
     *
     * @param float $income Net income
     * @param float $equity Avg. stockholder's equity
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getReturnOnEquity(float $income, float $equity) : float
    {
        return $income / $equity;
    }

    /**
     * Return on Investment (ROI)
     *
     * @param float $earnings   Earnings
     * @param float $investment Initial investment
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getReturnOnInvestment(float $earnings, float $investment) : float
    {
        return $earnings / $investment - 1;
    }

    /**
     * Simple Interest
     *
     * @param float $P Principal
     * @param float $r Rate
     * @param int   $t Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSimpleInterest(float $P, float $r, int $t) : float
    {
        return $P * $r * $t;
    }

    /**
     * Simple Interest Rate
     *
     * @param float $I Interest
     * @param float $P Principal
     * @param int   $t Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSimpleInterestRate(float $I, float $P, int $t) : float
    {
        return $I / ($P * $t);
    }

    /**
     * Simple Interest Principal
     *
     * @param float $I Interest
     * @param float $r Rate
     * @param int   $t Time
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSimpleInterestPrincipal(float $I, float $r, int $t) : float
    {
        return $I / ($r * $t);
    }

    /**
     * Simple Interest Principal
     *
     * @param float $I Interest
     * @param float $P Principal
     * @param float $r Rate
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getSimpleInterestTime(float $I, float $P, float $r) : int
    {
        return (int) round($I / ($P * $r));
    }

    /**
     * Relative market share by share
     *
     * @param float $ownShare Own market share
     * @param float $competitorShare Largest competitor market share
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRelativeMarketShareByShare(float $ownShare, float $competitorShare) : float
    {
        return $ownShare / $competitorShare;
    }

    /**
     * Relative market share by sales
     *
     * @param float $ownSales Own sales
     * @param float $competitorSales Largest competitor sales
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getRelativeMarketShareBySales(float $ownSales, float $competitorSales) : float
    {
        return $ownSales / $competitorSales;
    }

}
