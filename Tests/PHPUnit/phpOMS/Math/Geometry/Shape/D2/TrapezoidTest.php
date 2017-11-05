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

namespace Tests\PHPUnit\phpOMS\Math\Shape\D2;

require_once __DIR__ . '/../../../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Geometry\Shape\D2\Trapezoid;

class TrapezoidTest extends \PHPUnit\Framework\TestCase
{
	public function testTrapezoid()
	{
		self::assertEquals(10, Trapezoid::getSurface(2, 3, 4), '', 0.001);
		self::assertEquals(14, Trapezoid::getPerimeter(2, 3, 4, 5), '', 0.001);
		self::assertEquals(4, Trapezoid::getHeight(10, 2, 3), '', 0.001);

		self::assertEquals(2, Trapezoid::getA(10, 4, 3), '', 0.001);
		self::assertEquals(3, Trapezoid::getB(10, 4, 2), '', 0.001);
		self::assertEquals(4, Trapezoid::getC(14, 2, 3, 5), '', 0.001);
		self::assertEquals(5, Trapezoid::getD(14, 2, 3, 4), '', 0.001);
	}
}
