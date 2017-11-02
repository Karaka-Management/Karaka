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

namespace Tests\PHPUnit\phpOMS\Math\Shape\D2;

require_once __DIR__ . '/../../../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Geometry\Shape\D2\Rectangle;

class RectangleTest extends \PHPUnit\Framework\TestCase
{
	public function testRectanle()
	{
		self::assertEquals(10, Rectangle::getSurface(5, 2), '', 0.001);
		self::assertEquals(10, Rectangle::getPerimeter(2, 3), '', 0.001);
		self::assertEquals(32.7, Rectangle::getDiagonal(30, 13), '', 0.01);
	}
}
