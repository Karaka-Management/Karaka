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

namespace Tests\PHPUnit\phpOMS\Math\Matrix;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Matrix\Matrix;
use phpOMS\Math\Matrix\LUDecomposition;

class LUDecompositionTest extends \PHPUnit\Framework\TestCase
{
	public function testDecomposition()
	{
		$this->B = new Matrix();
        $this->B->setMatrix([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9],
		]);

        $lu = new LUDecomposition($this->B);
        
/*		self::assertEquals([
			[1, 0, 0],
			[4, 1, 0],
			[7, 2, 1],
        ], $lu->getL()->toArray(), '', 0.2);
        
        self::assertEquals([
			[1, 2, 3],
			[0, -3, -6],
			[0, 0, 0],
		], $lu->getU()->toArray(), '', 0.2);*/
	}
}
