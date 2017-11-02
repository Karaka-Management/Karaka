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

namespace Tests\PHPUnit\phpOMS\Message\Http;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Message\Http\Header;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\RequestStatusCode;

class HeaderTest extends \PHPUnit\Framework\TestCase
{
	public function testDefaults()
	{
		$header = new Header();
		self::assertFalse($header->isLocked());
		self::assertEquals(0, $header->getStatusCode());
		self::assertEquals('HTTP/1.1', $header->getProtocolVersion());
		self::assertEmpty(Header::getAllHeaders());
		self::assertEquals('', $header->getReasonPhrase());
		self::assertEquals([], $header->get('key'));
		self::assertFalse($header->has('key'));
		self::assertInstanceOf(Localization::class, $header->getL11n());
		self::assertEquals(0, $header->getAccount());
	}

	public function testSecurityHeader()
	{
		self::assertTrue(Header::isSecurityHeader('content-security-policy'));
		self::assertTrue(Header::isSecurityHeader('X-xss-protection'));
		self::assertTrue(Header::isSecurityHeader('x-conTent-tYpe-options'));
		self::assertTrue(Header::isSecurityHeader('x-frame-options'));

		self::assertFalse(Header::isSecurityHeader('x-frame-optionss'));
	}

	public function testGetSet()
	{
		$header = new Header();

		self::assertTrue($header->set('key', 'header'));
		self::assertEquals(['header'], $header->get('key'));
		self::assertTrue($header->has('key'));
		
		self::assertFalse($header->set('key', 'header2'));
		self::assertEquals(['header'], $header->get('key'));

		self::assertTrue($header->set('key', 'header3', true));
		self::assertEquals(['header3'], $header->get('key'));

		self::assertTrue($header->remove('key'));
		self::assertFalse($header->has('key'));
		self::assertFalse($header->remove('key'));

		$header->setAccount(2);
		self::AssertEquals(2, $header->getAccount(2));
	}

	public function testGeneration()
	{
		$header = new Header();

		$header->generate(RequestStatusCode::R_403);
		self::assertEquals(403, \http_response_code());

		$header->generate(RequestStatusCode::R_404);
		self::assertEquals(404, \http_response_code());

		$header->generate(RequestStatusCode::R_406);
		self::assertEquals(406, \http_response_code());

		$header->generate(RequestStatusCode::R_407);
		self::assertEquals(407, \http_response_code());

		$header->generate(RequestStatusCode::R_503);
		self::assertEquals(503, \http_response_code());

		$header->generate(RequestStatusCode::R_500);
		self::assertEquals(500, \http_response_code());
	}

	/**
     * @expectedException \Exception
     */
	public function testOverwriteSecurityHeader()
	{
		$header = new Header();
		self::assertTrue($header->set('content-security-policy', 'header'));
		$header->set('content-security-policy', 'header', true);
	}
}
