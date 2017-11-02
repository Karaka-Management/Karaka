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

namespace Tests\PHPUnit\phpOMS\Utils\RnG;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\RnG\LinearCongruentialGenerator;

class LinearCongruentialGeneratorTest extends \PHPUnit\Framework\TestCase
{
	public function testBsdRng()
	{
		self::assertEquals(12345, LinearCongruentialGenerator::bsd());

		if (PHP_INT_SIZE > 4) {
			self::assertEquals(1406932606, LinearCongruentialGenerator::bsd());
			self::assertEquals(654583775, LinearCongruentialGenerator::bsd());
			self::assertEquals(1449466924, LinearCongruentialGenerator::bsd());
		}
	}

	public function testMsRng()
	{
		self::assertEquals(38, LinearCongruentialGenerator::msvcrt());
		self::assertEquals(7719, LinearCongruentialGenerator::msvcrt());

		if (PHP_INT_SIZE > 4) {
			self::assertEquals(21238, LinearCongruentialGenerator::msvcrt());
			self::assertEquals(2437, LinearCongruentialGenerator::msvcrt());
		}
	}
}
