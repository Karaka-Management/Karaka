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
class StockBonds
{
    /**
     * Bond Equivalent Yield
     *
     * @param float $fv    Face value
     * @param float $price Price
     * @param int   $days  Days to maturity
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getBondEquivalentYield(float $fv, float $price, int $days) : float
    {
        return ($fv - $price) / $price * 365 / $days;
    }

    /**
     * Book Value per Share
     *
     * @param float $total  Total common stockholder's Equity
     * @param int   $common Number of common shares
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getBookValuePerShare(float $total, int $common) : float
    {
        return $total / $common;
    }

    /**
     * Capital Asset Pricing Model (CAPM)
     *
     * @param float $rf   Risk free rate
     * @param float $beta Risk to invest in a stock relative to the risk of the market
     * @param float $r    Return on the market
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getExpectedReturnCAPM(float $rf, float $beta, float $r) : float
    {
        return $rf + $beta * ($r - $rf);
    }

    /**
     * Capital Gains Yield
     *
     * @param float $P0 Old stock price
     * @param float $P1 New stock price
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCapitalGainsYield(float $P0, float $P1) : float
    {
        return $P1 / $P0 - 1;
    }

    /**
     * Current Yield
     *
     * @param float $coupons Annual coupons
     * @param float $price   Current bond price
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getCurrentYield(float $coupons, float $price) : float
    {
        return $coupons / $price;
    }

    /**
     * Diluted Earnings per Share
     *
     * @param float $income Net Income
     * @param float $avg    Avg. shares
     * @param float $other  Other convertible instruments
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDilutedEarningsPerShare(float $income, float $avg, float $other) : float
    {
        return $income / ($avg + $other);
    }

    /**
     * Dividend Payout Ratio
     *
     * @param float $dividends Dividends
     * @param float $income    Net income
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDividendPayoutRatio(float $dividends, float $income) : float
    {
        return $dividends / $income;
    }

    /**
     * Dividend Yield
     *
     * @param float $dividends Dividends
     * @param float $price     Initial price for the period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDividendYield(float $dividends, float $price) : float
    {
        return $dividends / $price;
    }

    /**
     * Dividend Yield
     *
     * @param float $dividends Dividends
     * @param int   $shares    Initial price for the period
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getDividendsPerShare(float $dividends, int $shares) : float
    {
        return $dividends / $shares;
    }

    /**
     * Earnings Per Share
     *
     * @param float $income Net income
     * @param float $shares Weighted avg. outstanding shares
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getEarningsPerShare(float $income, float $shares) : float
    {
        return $income / $shares;
    }

    /**
     * Equity Multiplier
     *
     * @param float $assets Total assets
     * @param float $equity Stockholder's equity
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getEquityMultiplier(float $assets, float $equity) : float
    {
        return $assets / $equity;
    }

    /**
     * Holding Period Return
     *
     * @param array $r Rate of return
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getHoldingPeriodReturn(array $r) : float
    {
        $hpr = 1.0;

        foreach ($r as $value) {
            $hpr *= 1 + $value;
        }

        return $hpr - 1;
    }

    /**
     * Net Asset Value
     *
     * @param float $assets      Fund assets
     * @param float $liabilities Fund liabilities
     * @param int   $shares      Outstanding shares
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getNetAssetValue(float $assets, float $liabilities, int $shares) : float
    {
        return ($assets - $liabilities) / $shares;
    }

    /**
     * Price to Book Value
     *
     * @param float $market Market price per share
     * @param float $book   Book value per share
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPriceToBookValue(float $market, float $book) : float
    {
        return $market / $book;
    }

    /**
     * Price to Earnings (P/E Ratio)
     *
     * @param float $price    Price per share
     * @param float $earnings Earnings per share
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPriceEarningsRatio(float $price, float $earnings) : float
    {
        return $price / $earnings;
    }

    /**
     * Price to Sales (P/S Ratio)
     *
     * @param float $price Price per share
     * @param float $sales Sales per share
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPriceToSalesRatio(float $price, float $sales) : float
    {
        return $price / $sales;
    }

    /**
     * Stock - PV with Constant Growth
     *
     * @param float $dividend Estimated dividends for next period
     * @param float $r        Required rate of return
     * @param float $g        Growth rate
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getPresentValueOfStockConstantGrowth(float $dividend, float $r, float $g = 0.0) : float
    {
        return $dividend / ($r - $g);
    }

    /**
     * Tax Equivalent Yield
     *
     * @param float $free Tax free yield
     * @param float $tax  Tax rate
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getTaxEquivalentYield(float $free, float $tax) : float
    {
        return $free / (1 - $tax);
    }

    /**
     * Total Stock Return
     *
     * @param float $P0 Initial stock price
     * @param float $P1 Ending stock price
     * @param float $D  Dividends
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getTotalStockReturn(float $P0, float $P1, float $D) : float
    {
        return ($P1 - $P0 + $D) / $P0;
    }

    /**
     * Yield to Maturity
     *
     * @param float $C Coupon/interest payment
     * @param float $F Face value
     * @param float $P Price
     * @param int   $n Years to maturity
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getYieldToMaturity(float $C, float $F, float $P, int $n) : float
    {
        return ($C + ($F - $P) / $n) / (($F + $P) / 2);
    }

    /**
     * Zero Coupon Bond Value
     *
     * @param float $F Face value
     * @param float $r Rate or yield
     * @param int   $t Time to maturity
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getZeroCouponBondValue(float $F, float $r, int $t) : float
    {
        return $F / pow(1 + $r, $t);
    }

    /**
     * Zero Coupon Bond Effective Yield
     *
     * @param float $F  Face value
     * @param float $PV Present value
     * @param int   $n  Time to maturity
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getZeroCouponBondEffectiveYield(float $F, float $PV, int $n) : float
    {
        return pow($F / $PV, 1 / $n) - 1;
    }

}
