<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Utils\Converter;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Converter\Currency;
use phpOMS\Localization\ISO4217CharEnum;

class CurrencyTest extends \PHPUnit\Framework\TestCase
{
	public function testCurrency()
	{
		self::assertGreaterThan(0, Currency::fromEurTo(1, ISO4217CharEnum::_USD));
		self::assertGreaterThan(0, Currency::fromToEur(1, ISO4217CharEnum::_USD));
		
		Currency::resetCurrencies();
		self::assertGreaterThan(0, Currency::convertCurrency(1, ISO4217CharEnum::_USD, ISO4217CharEnum::_GBP));
	}

	/**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFromEur()
    {
        Currency::fromEurTo(1, 'ERROR');
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidToEur()
    {
        Currency::fromToEur(1, 'ERROR');
	}
	
	/**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConvert()
    {
        Currency::convertCurrency(1, 'ERROR', 'TEST');
    }
}
