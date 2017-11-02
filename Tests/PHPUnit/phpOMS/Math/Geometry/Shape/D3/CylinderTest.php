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

namespace Tests\PHPUnit\phpOMS\Math\Geometry\Shape\D3;

require_once __DIR__ . '/../../../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Geometry\Shape\D3\Cylinder;

class CylinderTest extends \PHPUnit\Framework\TestCase
{
	public function testCylinder()
	{
		self::assertEquals(37.7, Cylinder::getVolume(2, 3), '', 0.01);
		self::assertEquals(62.83, Cylinder::getSurface(2, 3), '', 0.01);
		self::assertEquals(37.7, Cylinder::getLateralSurface(2, 3), '', 0.01);
	}
}
