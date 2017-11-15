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

use phpOMS\Math\Geometry\Shape\D2\Polygon;

class PolygonTest extends \PHPUnit\Framework\TestCase
{
    public function testPoint()
    {
        self::assertEquals(-1, Polygon::isPointInPolygon(
            ['x' => 1.5, 'y' => 1.5], 
            [
                ['x' => 1, 'y' => 1], 
                ['x' => 1, 'y' => 2], 
                ['x' => 2, 'y' => 2], 
                ['x' => 2, 'y' => 1], 
                ['x' => 1, 'y' => 1]
            ])
        );

        self::assertEquals(1, Polygon::isPointInPolygon(
            ['x' => 4.9, 'y' => 1.2], 
            [
                ['x' => 1, 'y' => 1], 
                ['x' => 1, 'y' => 2], 
                ['x' => 2, 'y' => 2], 
                ['x' => 2, 'y' => 1], 
                ['x' => 1, 'y' => 1]
            ])
        );

        self::assertEquals(-1, Polygon::isPointInPolygon(
            ['x' => 1.8, 'y' => 1.1], 
            [
                ['x' => 1, 'y' => 1], 
                ['x' => 1, 'y' => 2], 
                ['x' => 2, 'y' => 2], 
                ['x' => 2, 'y' => 1], 
                ['x' => 1, 'y' => 1]
            ])
        );
    }

    public function testAngle()
    {
        $polygon = new Polygon();
        
        $polygon->setCoordinates([[1, 2], [2, 3], [3, 4]]);
        self::assertEquals(180, $polygon->getInteriorAngleSum());

        $polygon->setCoordinates([[1, 2], [2, 3], [3, 4], [4, 5]]);
        self::assertEquals(360, $polygon->getInteriorAngleSum());

        $polygon->setCoordinates([[1, 2], [2, 3], [3, 4], [4, 5], [5, 6]]);
        self::assertEquals(540, $polygon->getInteriorAngleSum());

        $polygon->setCoordinates([[1, 2], [2, 3], [3, 4], [4, 5], [5, 6], [6, 7]]);
        self::assertEquals(720, $polygon->getInteriorAngleSum());

        $polygon->setCoordinates([[1, 2], [2, 3], [3, 4], [4, 5], [5, 6], [6, 7], [7, 8]]);
        self::assertEquals(900, $polygon->getInteriorAngleSum());

        $polygon->setCoordinates([[1, 2], [2, 3], [3, 4], [4, 5], [5, 6], [6, 7], [7, 8], [8, 9]]);
        self::assertEquals(1080, $polygon->getInteriorAngleSum());

        self::assertEquals(360, $polygon->getExteriorAngleSum());
    }

    public function testPerimeter() 
    {
        $polygon = new Polygon();
        $polygon->setCoordinates([
            ['x' => 2, 'y' => 1], 
            ['x' => 2, 'y' => 2], 
            ['x' => 3, 'y' => 3], 
            ['x' => 4, 'y' => 3], 
            ['x' => 5, 'y' => 2], 
            ['x' => 5, 'y' => 1], 
            ['x' => 4, 'y' => 0], 
            ['x' => 3, 'y' => 0],
        ]);
        self::assertEquals(9.6568, $polygon->getPerimeter(), '', 0.1);
    }

    public function testArea()
    {
        $polygon = new Polygon();
        $polygon->setCoordinates([
            ['x' => 2, 'y' => 1], 
            ['x' => 2, 'y' => 2], 
            ['x' => 3, 'y' => 3], 
            ['x' => 4, 'y' => 3], 
            ['x' => 5, 'y' => 2], 
            ['x' => 5, 'y' => 1], 
            ['x' => 4, 'y' => 0], 
            ['x' => 3, 'y' => 0],
        ]);
        self::assertEquals(7, $polygon->getSurface());
    }

    public function testBarycenter()
    {
        $polygon = new Polygon();
        $polygon->setCoordinates([
            ['x' => 2, 'y' => 1], 
            ['x' => 2, 'y' => 2], 
            ['x' => 3, 'y' => 3], 
            ['x' => 4, 'y' => 3], 
            ['x' => 5, 'y' => 2], 
            ['x' => 5, 'y' => 1], 
            ['x' => 4, 'y' => 0], 
            ['x' => 3, 'y' => 0],
        ]);
        self::assertEquals(['x' => 3.5, 'y' => 1.5], $polygon->getBarycenter(), '', 0.5);
    }
}
