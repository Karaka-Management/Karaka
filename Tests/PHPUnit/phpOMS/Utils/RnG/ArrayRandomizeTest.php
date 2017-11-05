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

namespace Tests\PHPUnit\phpOMS\Utils\RnG;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\RnG\ArrayRandomize;

class ArrayRandomizeTest extends \PHPUnit\Framework\TestCase
{
	public function testRandomize()
	{
		$orig = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20];

		self::assertNotEquals($orig, ArrayRandomize::yates($orig));
		self::assertNotEquals($orig, ArrayRandomize::knuth($orig));
	}
}
