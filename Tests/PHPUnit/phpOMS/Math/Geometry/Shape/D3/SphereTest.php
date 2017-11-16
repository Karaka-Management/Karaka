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

namespace Tests\PHPUnit\phpOMS\Math\Geometry\Shape\D3;

require_once __DIR__ . '/../../../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Geometry\Shape\D3\Sphere;

class SphereTest extends \PHPUnit\Framework\TestCase
{
    public function testSphere()
    {
        $sphere = new Sphere(3);
        self::assertEquals(113.1, $sphere->getVolume(), '', 0.1);
        self::assertEquals(113.1, $sphere->getSurface(), '', 0.1);
    }

    public function testGetBy()
    {
        $sphere = Sphere::byRadius(3);
        self::assertEquals(3, $sphere->getRadius(), '', 0.1);

        $sphere = Sphere::byVolume(4);
        self::assertEquals(4, $sphere->getVolume(), '', 0.1);

        $sphere = Sphere::bySurface(5);
        self::assertEquals(5, $sphere->getSurface(), '', 0.1);
    }
}
