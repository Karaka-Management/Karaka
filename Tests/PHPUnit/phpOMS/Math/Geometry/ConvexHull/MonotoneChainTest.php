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

namespace Tests\PHPUnit\phpOMS\Math\Geometry\ConvexHull;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Geometry\ConvexHull\MonotoneChain;

class MonotoneChainTest extends \PHPUnit\Framework\TestCase
{
	public function testMonotoneChain()
	{
		self::assertEquals([['x' => 9, 'y' => 0]], MonotoneChain::createConvexHull([['x' => 9, 'y' => 0]]));

		$points = [];
		for($i = 0; $i < 10; $i++) {
			for($j = 0; $j < 10; $j++) {
				$points[] = ['x' => $i, 'y' => $j];
			}
		}

		self::assertEquals([
				['x' => 0, 'y' => 0],
				['x' => 9, 'y' => 0],
				['x' => 9, 'y' => 9],
				['x' => 0, 'y' => 9], 
			], 
			MonotoneChain::createConvexHull($points)
		);
	}
}
