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

use phpOMS\Localization\ISO4217CharEnum;
use phpOMS\Message\Http\Rest;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Localization\Localization;
use phpOMS\Uri\Http;

/**
 * Currency converter.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Currency
{

    /**
     * ECB currency rates.
     *
     * @var array|null
     * @since 1.0.0
     */
    private static $ecbCurrencies = null;

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
     * Reset currency rates.
     *
     * Can be used in order to refresh them. Be careful currency rates only get updated once a day from the ECB website.
     *
     * @since  1.0.0
     */
    public static function resetCurrencies() /* : void */
    {
        self::$ecbCurrencies = null;
    }

    /**
     * Convert from EUR
     *
     * @param float  $value Value to convert
     * @param string $to    Output currency
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function fromEurTo(float $value, string $to) : float
    {
        $currencies = self::getEcbEuroRates();
        $to         = strtoupper($to);

        if (!isset($currencies[$to])) {
            throw new \InvalidArgumentException('Currency doesn\'t exists');
        }

        return $value * $currencies[$to];
    }

    /**
     * Get ECB currency rates.
     *
     * @return array
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function getEcbEuroRates() : array
    {
        if (!isset(self::$ecbCurrencies)) {
            $request = new Request(new Http('http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml'));
            $request->setMethod(RequestMethod::GET);

            $xml = new \SimpleXMLElement(Rest::request($request));

            if (!isset($xml->Cube)) {
                throw new \Exception('Invalid xml path');
                
            } 

            $node = $xml->Cube->Cube->Cube;
            self::$ecbCurrencies = [];
            
            foreach ($node as $key => $value) {
                self::$ecbCurrencies[strtoupper((string) $value->attributes()['currency'])] = (float) $value->attributes()['rate'];
            }
        }

        return self::$ecbCurrencies;
    }

    /**
     * Convert to EUR
     *
     * @param float  $value Value to convert
     * @param string $from  Input currency
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function fromToEur(float $value, string $from) : float
    {
        $currencies = self::getEcbEuroRates();
        $from       = strtoupper($from);

        if (!isset($currencies[$from])) {
            throw new \InvalidArgumentException('Currency doesn\'t exists');
        }

        return $value / $currencies[$from];
    }

    /**
     * Convert currency based on ECB reates
     *
     * @param float  $value Value to convert
     * @param string $from  Input currency
     * @param string $to    Output currency
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertCurrency(float $value, string $from, string $to) : float
    {
        $currencies = self::getEcbEuroRates();
        $from       = strtoupper($from);
        $to         = strtoupper($to);

        if ((!isset($currencies[$from]) && $from !== ISO4217CharEnum::_EUR) || (!isset($currencies[$to]) && $to !== ISO4217CharEnum::_EUR)) {
            throw new \InvalidArgumentException('Currency doesn\'t exists');
        }

        if ($from !== ISO4217CharEnum::_EUR) {
            $value /= $currencies[$from];
        }

        return $to === ISO4217CharEnum::_EUR ? $value : $value * $currencies[$to];
    }
}
