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
use phpOMS\Math\Matrix\CholeskyDecomposition;

class CholeskyDecompositionTest extends \PHPUnit\Framework\TestCase
{
	public function testDecomposition()
	{
		$this->B = new Matrix();
        $this->B->setMatrix([
            [25, 15, -5],
            [15, 17, 0],
            [-5, 0, 11],
		]);

		$cholesky = new CholeskyDecomposition($this->B);
		
		self::assertEquals([
			[5, 0, 0],
			[3, 3, 0],
			[-1, 1, 3],
		], $cholesky->getL()->toArray(), '', 0.2);
	}
}
