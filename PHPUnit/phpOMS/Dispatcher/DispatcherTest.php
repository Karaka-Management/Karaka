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

namespace Tests\PHPUnit\phpOMS\Dispatcher;

use phpOMS\ApplicationAbstract;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\L11nManager;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Router\Router;
use phpOMS\Uri\Http;
use phpOMS\System\File\PathException;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class DispatcherTest extends \PHPUnit\Framework\TestCase
{
    protected $app = null;

    protected function setUp()
    {
        $this->app = new class extends ApplicationAbstract {};
        $this->app->router = new Router();
        $this->app->dispatcher = new Dispatcher($this->app);
    }

    public function testAttributes()
    {
        self::assertObjectHasAttribute('controllers', $this->app->dispatcher);
    }

    public function testClosure()
    {
        $l11nManager = new L11nManager();
        $localization = new Localization($l11nManager);

        self::assertTrue(
            !empty(
                $this->app->dispatcher->dispatch(
                    function($req, $resp, $data = null) { return true; }, 
                    new Request(new Http(''), $localization), 
                    new Response($localization)
                )
            )
        );
    }

    public function testPathMethod()
    {
        $l11nManager = new L11nManager();
        $localization = new Localization($l11nManager);

        self::assertTrue(
            !empty(
                $this->app->dispatcher->dispatch(
                    'Tests\PHPUnit\phpOMS\Dispatcher\TestController:testFunction', 
                    new Request(new Http(''), $localization), 
                    new Response($localization)
                )
            )
        );
    }

    public function testPathStatic()
    {
        $l11nManager = new L11nManager();
        $localization = new Localization($l11nManager);

        self::assertTrue(
            !empty(
                $this->app->dispatcher->dispatch(
                    'Tests\PHPUnit\phpOMS\Dispatcher\TestController::testFunctionStatic', 
                    new Request(new Http(''), $localization), 
                    new Response($localization)
                )
            )
        );
    }

    public function testArray()
    {
        $l11nManager = new L11nManager();
        $localization = new Localization($l11nManager);

        self::assertTrue(
            !empty(
                $this->app->dispatcher->dispatch(
                    [
                        function($req, $resp, $data = null) { return true; },
                        'Tests\PHPUnit\phpOMS\Dispatcher\TestController:testFunction',
                        'Tests\PHPUnit\phpOMS\Dispatcher\TestController::testFunctionStatic', 
                    ], 
                    new Request(new Http(''), $localization), 
                    new Response($localization)
                )
            )
        );
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testInvalidDestination()
    {
        $this->app->dispatcher->dispatch(true);
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidControllerPath()
    {
        $this->app->dispatcher->dispatch('Tests\PHPUnit\phpOMS\Dispatcher\TestControllers::testFunctionStatic');
    }
}
