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

use phpOMS\Message\Http\Response;
use phpOMS\Localization\Localization;

class ResponseTest extends \PHPUnit\Framework\TestCase
{
	public function testDefault()
	{
		$response = new Response(new Localization());
		self::assertEquals('', $response->getBody());
		self::assertEquals('', $response->render());
		self::assertEquals([], $response->toArray());
		self::assertInstanceOf('\phpOMS\Localization\Localization', $response->getHeader()->getL11n());
		self::assertInstanceOf('\phpOMS\Message\Http\Header', $response->getHeader());
	}

	public function testSetGet()
	{
		$response = new Response(new Localization());

		$response->setResponse(['a' => 1]);
		self::assertTrue($response->remove('a'));
		self::assertFalse($response->remove('a'));
	}
}
