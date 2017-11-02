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

use phpOMS\Math\Number\Prime;

class PrimeTest extends \PHPUnit\Framework\TestCase
{
	public function testPrime()
	{
		self::assertTrue(Prime::isPrime(2));
		self::assertTrue(Prime::isPrime(997));
		self::assertFalse(Prime::isPrime(998));
	}

	public function testSieve()
	{
		self::assertTrue(Prime::isPrime(Prime::sieveOfEratosthenes(12)[3]));
		self::assertTrue(Prime::isPrime(Prime::sieveOfEratosthenes(51)[7]));
	}

	public function testRabin()
	{
		self::assertTrue(Prime::rabinTest(2));
		self::assertFalse(Prime::rabinTest(4));
		self::assertFalse(Prime::rabinTest(9));
		self::assertTrue(Prime::rabinTest(997));
		self::assertFalse(Prime::rabinTest(998));
	}

	public function testMersenne()
	{
		self::assertEquals(2047, Prime::mersenne(11));
		self::assertTrue(Prime::isMersenne(Prime::mersenne(2)));
		self::assertTrue(Prime::isMersenne(Prime::mersenne(4)));
		self::assertFalse(Prime::isMersenne(2046));
	}
}
