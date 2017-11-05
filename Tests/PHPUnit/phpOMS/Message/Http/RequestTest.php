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

use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Header;
use phpOMS\Message\Http\OSType;
use phpOMS\Message\Http\BrowserType;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\RequestSource;
use phpOMS\Localization\Localization;
use phpOMS\Router\RouteVerb;
use phpOMS\Uri\Http;

class RequestTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $request = new Request();

        self::assertEquals('en', $request->getHeader()->getL11n()->getLanguage());
        self::assertFalse($request->isMobile());
        self::assertEquals(BrowserType::CHROME, $request->getBrowser());
        self::assertEquals(OSType::LINUX, $request->getOS());
        self::assertEquals('127.0.0.1', $request->getOrigin());
        self::assertFalse($request->isHttps());
        self::assertEquals([], $request->getHash());
        self::assertEmpty($request->getBody());
        self::assertEquals('/', $request->getRequestTarget());
        self::assertEmpty([], $request->getFiles());
        self::assertEquals(RouteVerb::GET, $request->getRouteVerb());
        self::assertEquals(RequestMethod::GET, $request->getMethod());
        self::assertEquals(RequestSource::WEB, $request->getRequestSource());
        self::assertInstanceOf('\phpOMS\Message\Http\Header', $request->getHeader());
        self::assertInstanceOf('\phpOMS\Message\Http\Request', Request::createFromSuperglobals());
        self::assertEquals('http://', $request->__toString());
    }

    public function testSetGet()
    {
        $request = new Request(new Http('http://www.google.com/test/path'), $l11n = new Localization());

        $request->setOS(OSType::WINDOWS_XP);
        self::assertEquals(OSType::WINDOWS_XP, $request->getOS());

        $request->setBrowser(BrowserType::EDGE);
        self::assertEquals(BrowserType::EDGE, $request->getBrowser());
        self::assertEquals(['browser' => BrowserType::EDGE, 'os' => OSType::WINDOWS_XP], $request->getRequestInfo());

        $request->setMethod(RequestMethod::PUT);
        self::assertEquals(RequestMethod::PUT, $request->getMethod());
        self::assertEquals(RouteVerb::PUT, $request->getRouteVerb());

        $request->setMethod(RequestMethod::DELETE);
        self::assertEquals(RequestMethod::DELETE, $request->getMethod());
        self::assertEquals(RouteVerb::DELETE, $request->getRouteVerb());

        $request->setMethod(RequestMethod::POST);
        self::assertEquals(RequestMethod::POST, $request->getMethod());
        self::assertEquals(RouteVerb::SET, $request->getRouteVerb());

        self::assertEquals('http://www.google.com/test/path', $request->getUri()->__toString());

        $request->createRequestHashs(0);
        self::assertEquals('http://www.google.com/test/path', $request->__toString());

        self::assertEquals([
            'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3',
            '328413d996ab9b79af9d4098af3a65b885c4ca64'
            ], $request->getHash());
        self::assertEquals($l11n, $request->getHeader()->getL11n());

        self::assertTrue($request->setData('key', 'value'));
        self::assertFalse($request->setData('key', 'value2', false));
        self::assertEquals('value', $request->getData('key'));
        self::assertEquals(['key' => 'value'], $request->getData());

        $request->setRequestSource(RequestSource::SOCKET);
        self::assertEquals(RequestSource::SOCKET, $request->getRequestSource());

        $request->setUri(new Http('http://www.google.com/test/path2'));
        $request->createRequestHashs(0);

        self::assertEquals('http://www.google.com/test/path2', $request->__toString());
    }

    /**
     * @expectedException \phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testInvalidRequestSource()
    {
        $request = new Request(new Http('http://www.google.com/test/path'));
        $request->setRequestSource(999);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testInvalidHttpsPort()
    {
        $request = new Request(new Http('http://www.google.com/test/path'));
        $request->isHttps(-1);
    }
}
