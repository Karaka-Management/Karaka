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

namespace Tests\PHPUnit\phpOMS\Uri;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Uri\Http;

class HttpTest extends \PHPUnit\Framework\TestCase
{
	public function testAttributes()
	{
		$obj = new Http('');
		self::assertInstanceOf('\phpOMS\Uri\Http', $obj);

		/* Testing members */
		self::assertObjectHasAttribute('rootPath', $obj);
		self::assertObjectHasAttribute('uri', $obj);
		self::assertObjectHasAttribute('scheme', $obj);
		self::assertObjectHasAttribute('host', $obj);
		self::assertObjectHasAttribute('port', $obj);
		self::assertObjectHasAttribute('user', $obj);
		self::assertObjectHasAttribute('pass', $obj);
		self::assertObjectHasAttribute('path', $obj);
		self::assertObjectHasAttribute('query', $obj);
		self::assertObjectHasAttribute('queryString', $obj);
		self::assertObjectHasAttribute('fragment', $obj);
		self::assertObjectHasAttribute('base', $obj);
	}

	public function testHelper()
	{
		self::assertTrue(Http::isValid('http://www.google.de'));
		self::assertTrue(Http::isValid('http://google.de'));
		self::assertTrue(Http::isValid('https://google.de'));
		self::assertFalse(Http::isValid('https:/google.de'));
	}

	public function testSetGet()
	{
		$obj = new Http($uri = 'https://www.google.com/test/path.php?para1=abc&para2=2#frag');

		self::assertEquals('/', $obj->getRootPath());
		self::assertEquals(0, $obj->getPathOffset());
		self::assertEquals('https', $obj->getScheme());
		self::assertEquals('www.google.com', $obj->getHost());
		self::assertEquals(80, $obj->getPort());
		self::assertEquals('', $obj->getPass());
		self::assertEquals('', $obj->getUser());
		self::assertEquals('test/path', $obj->getPath());
		self::assertEquals('test/path?para1=abc&para2=2', $obj->getRoute());
		self::assertEquals('test', $obj->getPathElement(0));
		self::assertEquals('para1=abc&para2=2', $obj->getQuery());
		self::assertEquals(['para1' => 'abc', 'para2' => '2'], $obj->getQueryArray());
		self::assertEquals('2', $obj->getQuery('para2'));
		self::assertEquals('frag', $obj->getFragment());
		self::assertEquals('https://www.google.com/', $obj->getBase());
		self::assertEquals($uri, $obj->__toString());
		self::assertEquals('www.google.com:80', $obj->getAuthority());
		self::assertEquals('', $obj->getUserInfo());

		$obj->setRootPath('a');
		self::assertEquals('a', $obj->getRootPath());
	}
}
