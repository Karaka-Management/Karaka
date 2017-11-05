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

use phpOMS\Math\Geometry\Shape\D2\Circle;

class CircleTest extends \PHPUnit\Framework\TestCase
{
    public function testCircle()
    {
        self::assertEquals(12.57, Circle::getSurface(2), '', 0.01);
        self::assertEquals(12.57, Circle::getPerimeter(2), '', 0.01);
        self::assertEquals(2.0, Circle::getRadiusBySurface(Circle::getSurface(2)), '', 0.001);
        self::assertEquals(2.0, Circle::getRadiusByPerimeter(Circle::getPerimeter(2)), '', 0.001);
    }
}
