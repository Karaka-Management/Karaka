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

namespace Tests\PHPUnit\phpOMS\Math\Number;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Number\Integer;

class IntegerTest extends \PHPUnit\Framework\TestCase
{
	public function testInteger() 
	{
		self::assertTrue(Integer::isInteger(4));
		self::assertFalse(Integer::isInteger(1.0));
		self::assertFalse(Integer::isInteger('3'));

		self::assertArraySubset([2, 2, 5, 5], Integer::trialFactorization(100));
		self::assertEquals([], Integer::trialFactorization(1));

		self::assertEquals(101, Integer::pollardsRho(10403, 2, 1, 2, 2));

		self::assertEquals([59, 101], Integer::fermatFactor(5959));
	}

	/**
     * @expectedException \Exception
     */
    public function testInvalidFermatParameter()
    {
        Integer::fermatFactor(8);
    }

	public function testGCD()
	{
		self::assertEquals(4, Integer::greatestCommonDivisor(4, 4));
		self::assertEquals(6, Integer::greatestCommonDivisor(54, 24));
		self::assertEquals(6, Integer::greatestCommonDivisor(24, 54));
		self::assertEquals(1, Integer::greatestCommonDivisor(7, 13));
	}
}
