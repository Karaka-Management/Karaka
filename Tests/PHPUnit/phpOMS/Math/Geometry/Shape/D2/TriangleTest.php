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

use phpOMS\Math\Geometry\Shape\D2\Triangle;

class TriangleTest extends \PHPUnit\Framework\TestCase
{
    public function testTriangle()
    {
        self::assertEquals(3, Triangle::getSurface(2, 3), '', 0.001);
        self::assertEquals(9, Triangle::getPerimeter(2, 3, 4), '', 0.001);
        self::assertEquals(3, Triangle::getHeight(3, 2), '', 0.001);
    }
}
