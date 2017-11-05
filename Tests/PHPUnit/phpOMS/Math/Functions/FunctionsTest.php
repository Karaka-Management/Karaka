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

namespace Tests\PHPUnit\phpOMS\Math\Functions;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Functions\Functions;

class FunctionsTest extends \PHPUnit\Framework\TestCase
{
	public function testFactorial()
	{
		self::assertEquals(Functions::fact(4), Functions::getGammaInteger(5));

		self::assertEquals(120, Functions::fact(5));
		self::assertEquals(39916800, Functions::fact(11));

		self::assertEquals(21, Functions::binomialCoefficient(7, 2));
		self::assertEquals(6, Functions::binomialCoefficient(4, 2));
		self::assertEquals(13983816, Functions::binomialCoefficient(49, 6));
	}

	public function testAckermann()
	{
		self::assertEquals(5, Functions::ackermann(2, 1));
		self::assertEquals(125, Functions::ackermann(3, 4));
		self::assertEquals(5, Functions::ackermann(0, 4));
		self::assertEquals(13, Functions::ackermann(4, 0));
	}

	public function testMultiplicativeInverseModulo()
	{
		self::assertEquals(4, Functions::invMod(3, -11));
		self::assertEquals(12, Functions::invMod(10, 17));
	}

	public function testAbs()
	{
		self::assertEquals([1, 3, 4], Functions::abs([-1, 3, -4]));
	}

	public function testProperties()
	{
		self::assertTrue(Functions::isOdd(3));
		self::assertTrue(Functions::isOdd(-3));
		self::assertFalse(Functions::isOdd(4));
		self::assertFalse(Functions::isOdd(-4));

		self::assertTrue(Functions::isEven(4));
		self::assertTrue(Functions::isEven(-4));
		self::assertFalse(Functions::isEven(3));
		self::assertFalse(Functions::isEven(-3));
	}

	public function testCircularPosition()
	{
		self::assertEquals(0, Functions::getRelativeDegree(7, 12, 7));
		self::assertEquals(5, Functions::getRelativeDegree(12, 12, 7));
		self::assertEquals(11, Functions::getRelativeDegree(6, 12, 7));
	}
}
