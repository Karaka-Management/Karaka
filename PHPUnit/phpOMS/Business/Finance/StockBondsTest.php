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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\phpOMS\Business\Finance;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Business\Finance\StockBonds;

class StockBondsTest extends \PHPUnit\Framework\TestCase
{
	public function testRatios()
	{
		self::assertEquals(100 / 50, StockBonds::getBookValuePerShare(100, 50));
		self::assertEquals(100 / 50, StockBonds::getCurrentYield(100, 50));
		self::assertEquals(100 / 50, StockBonds::getDividendPayoutRatio(100, 50));
		self::assertEquals(100 / 50, StockBonds::getDividendYield(100, 50));
		self::assertEquals(100 / 50, StockBonds::getDividendsPerShare(100, 50));
		self::assertEquals(100 / 50, StockBonds::getEarningsPerShare(100, 50));
		self::assertEquals(100 / 50, StockBonds::getEquityMultiplier(100, 50));
		self::assertEquals(100 / 50, StockBonds::getPriceToBookValue(100, 50));
		self::assertEquals(100 / 50, StockBonds::getPriceEarningsRatio(100, 50));
		self::assertEquals(100 / 50, StockBonds::getPriceToSalesRatio(100, 50));
	}
}
