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

namespace Tests\PHPUnit\phpOMS\Validation\Network;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Validation\Network\Hostname;

class HostnameTest extends \PHPUnit\Framework\TestCase
{
	public function testHostname()
	{
		self::assertTrue(Hostname::isValid('test.com'));
		self::assertFalse(Hostname::isValid('http://test.com'));
		self::assertFalse(Hostname::isValid('test.com/test?something=a'));
		self::assertFalse(Hostname::isValid('//somethign/wrong'));
	}
}
