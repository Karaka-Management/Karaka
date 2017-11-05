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

namespace Tests\PHPUnit\phpOMS\Message\Http;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Message\Http\RequestMethod;

class RequestMethodTest extends \PHPUnit\Framework\TestCase
{
	public function testEnums()
	{
		self::assertEquals(6, count(RequestMethod::getConstants()));
		self::assertEquals(RequestMethod::getConstants(), array_unique(RequestMethod::getConstants()));
		
		self::assertEquals('GET', RequestMethod::GET);
		self::assertEquals('POST', RequestMethod::POST);
		self::assertEquals('PUT', RequestMethod::PUT);
		self::assertEquals('DELETE', RequestMethod::DELETE);
		self::assertEquals('HEAD', RequestMethod::HEAD);
		self::assertEquals('TRACE', RequestMethod::TRACE);
	}
}
