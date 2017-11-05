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

namespace Tests\PHPUnit\phpOMS\Math\Optimization\TSP;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Optimization\TSP\City;

class CityTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $obj = new City();
        self::assertEquals('', $obj->getName());
        self::assertEquals((float) 0, $obj->getLatitude());
        self::assertEquals((float) 0, $obj->getLongitude());
        self::assertTrue($obj->equals(new City()));
        self::assertEquals(0, $obj->getDistanceTo(new City()));
    }

    public function testGetSet()
    {
        $obj = new City(10, 20, 'A');
        self::assertEquals('A', $obj->getName());
        self::assertEquals((float) 10, $obj->getLatitude());
        self::assertEquals((float) 20, $obj->getLongitude());
        self::assertTrue(abs(2476171 - $obj->getDistanceTo(new City())) < 1);
        self::assertFalse($obj->equals(new City()));
    }
}
