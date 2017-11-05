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

use phpOMS\Math\Functions\Fibunacci;

class FibunacciTest extends \PHPUnit\Framework\TestCase
{
	public function testFibunacci()
	{
		self::assertTrue(Fibunacci::isFibunacci(13));
		self::assertTrue(Fibunacci::isFibunacci(55));
		self::assertTrue(Fibunacci::isFibunacci(89));
		self::assertFalse(Fibunacci::isFibunacci(6));
		self::assertFalse(Fibunacci::isFibunacci(87));

		self::assertEquals(1, Fibunacci::fibunacci(1));
		self::assertTrue(Fibunacci::isFibunacci(Fibunacci::binet(3)));
		self::assertTrue(Fibunacci::isFibunacci(Fibunacci::binet(6)));

		self::assertEquals(Fibunacci::binet(6), Fibunacci::fibunacci(6));
		self::assertEquals(Fibunacci::binet(8), Fibunacci::fibunacci(8));
	}
}
