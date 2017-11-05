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

use phpOMS\Math\Optimization\TSP\Tour;
use phpOMS\Math\Optimization\TSP\CityPool;
use phpOMS\Math\Optimization\TSP\City;

class TourTest extends \PHPUnit\Framework\TestCase
{
	public function testDefault()
	{
		$obj = new Tour(new cityPool(), false);
		self::assertEquals(null, $obj->getCity(1));
		self::assertEquals(0.0, $obj->getFitness());
		self::assertEquals(0.0, $obj->getDistance());
		self::assertFalse($obj->hasCity(new City()));
		self::assertEquals(0, $obj->count());
	}
}
