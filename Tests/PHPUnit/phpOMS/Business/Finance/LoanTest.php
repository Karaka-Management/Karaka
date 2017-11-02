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

namespace Tests\PHPUnit\phpOMS\Business\Finance;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Business\Finance\Loan;

class LoanTest extends \PHPUnit\Framework\TestCase
{
	public function testRatios()
	{
		self::assertEquals(100 / 50, Loan::getLoanToDepositRatio(100, 50));
		self::assertEquals(100 / 50, Loan::getLoanToValueRatio(100, 50));
	}
}
