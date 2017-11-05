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

namespace Tests\PHPUnit\phpOMS\Router;

use phpOMS\Message\Http\RequestMethod;
use phpOMS\Router\Router;
use phpOMS\Router\RouteVerb;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\Request;
use phpOMS\Uri\Http;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class RouterTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $router = new Router();
        self::assertInstanceOf('\phpOMS\Router\Router', $router);
        self::assertObjectHasAttribute('routes', $router);
    }

    public function testDefault()
    {
        $router = new Router();
        self::assertEmpty($router->route(new Request(new Http('http://test.com'))));
        self::assertEmpty($router->route('http://test.com'));
    }

    public function testGetSet()
    {
        $router = new Router();
        self::assertFalse($router->importFromFile(__Dir__ . '/invalidFile.php'));
        self::assertTrue($router->importFromFile(__Dir__ . '/routerTestFile.php'));

        self::assertEquals(
            [['dest' => '\Modules\Admin\Controller:viewSettingsGeneral']], 
            $router->route('http://test.com/backend/admin/settings/general/something?test')
        );

        self::assertNotEquals(
            [['dest' => '\Modules\Admin\Controller:viewSettingsGeneral']], 
            $router->route('http://test.com/backend/admin/settings/general/something?test', RouteVerb::PUT)
        );

        self::assertNotEquals(
            [['dest' => '\Modules\Admin\Controller:viewSettingsGeneral']], 
            $router->route('http://test.com/backends/admin/settings/general/something?test')
        );

        $router->add('^.*/backends/admin/settings/general.*$', 'Controller:test', RouteVerb::GET | RouteVerb::SET);
        self::assertEquals(
            [['dest' => 'Controller:test']], 
            $router->route('http://test.com/backends/admin/settings/general/something?test', RouteVerb::ANY)
        );

        self::assertEquals(
            [['dest' => 'Controller:test']], 
            $router->route('http://test.com/backends/admin/settings/general/something?test', RouteVerb::SET)
        );

        self::assertEquals(
            [['dest' => 'Controller:test']], 
            $router->route('http://test.com/backends/admin/settings/general/something?test', RouteVerb::GET)
        );
    }
}
