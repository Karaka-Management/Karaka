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

namespace Tests\PHPUnit\phpOMS\Views;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Uri\Http;
use phpOMS\Views\View;
use phpOMS\Localization\L11nManager;

class ViewTest extends \PHPUnit\Framework\TestCase
{
    protected $dbPool = null;
    protected $app = null;

    public function setUp()
    {
        $this->dbPool = new DatabasePool();
        /** @var array $CONFIG */
        $this->dbPool->create('core', $GLOBALS['CONFIG']['db']['core']['masters']['admin']);

        $this->app         = new class extends ApplicationAbstract
        {
        };

        $this->app->l11nManager = new L11nManager();
        $this->app->dbPool = $this->dbPool;
    }

    public function testDefault()
    {
        $view = new View($this->app, new Request(new Http('')), new Response(new Localization()));

        self::assertEmpty($view->getTemplate());
        self::assertEmpty($view->getViews());
        self::assertTrue(is_array($view->getViews()));
        self::assertFalse($view->getView(0));
        self::assertFalse($view->removeView(0));
        self::assertNull($view->getData(0));
        self::assertFalse($view->removeData(0));
        self::assertEmpty($view->toArray());
    }

    public function testGetText()
    {
        $view = new View($this->app, $request = new Request(new Http('')), $response = new Response(new Localization()));
        $view->setTemplate('/Modules/Admin/Theme/Backend/accounts-list');

        $expected = [
            'en' => [
                'Admin' => [
                    'Test' => '<a href="test">Test</a>'
                ]
            ]
        ];

        $this->app->l11nManager = new L11nManager();
        $this->app->l11nManager->loadLanguage('en', 'Admin', $expected['en']);

        self::assertEquals('<a href="test">Test</a>', $view->getText('Test'));
        self::assertEquals('&lt;a href=&quot;test&quot;&gt;Test&lt;/a&gt;', $view->getHtml('Test'));
    }

    public function testGetSet()
    {
        $view = new View($this->app, $request = new Request(new Http('')), $response = new Response(new Localization()));

        $view->setData('key', 'value');
        self::assertEquals('value', $view->getData('key'));

        self::assertTrue($view->addData('key2', 'valu2'));
        self::assertFalse($view->addData('key2', 'valu3'));
        self::assertEquals('valu2', $view->getData('key2'));

        self::assertTrue($view->removeData('key2'));
        self::assertFalse($view->removeData('key3'));

        self::assertEquals($request, $view->getRequest());
        self::assertEquals($response, $view->getResponse());

        self::assertEquals('&lt;a href=&quot;test&quot;&gt;Test&lt;/a&gt;', $view->printHtml('<a href="test">Test</a>'));
        
        $tView = new View($this->app, $request, $response);
        self::assertTrue($view->addView('test', $tView));
        self::assertEquals($tView, $view->getView('test'));
        self::assertEquals(1, count($view->getViews()));
        self::assertTrue($view->removeView('test'));
        self::assertFalse($view->removeView('test'));
        self::assertFalse($view->getView('test'));
    }

    public function testRender()
    {
        $view = new View($this->app, new Request(), new Response(new Localization()));
        
        $view->setTemplate('/Tests/PHPUnit/phpOMS/Views/testTemplate');
        self::assertEquals('<strong>Test</strong>', $view->render());

        // todo: why is this failing?
        //$view->setTemplate('/Tests/PHPUnit/phpOMS/Views/testArray');
        //self::assertEquals([1, 2, 3], $view->render());
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testRenderException()
    {
        $view = new View($this->app, new Request(new Http('')), new Response(new Localization()));
        $view->setTemplate('something.txt');

        $view->render();
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testSerializeException()
    {
        $view = new View($this->app, new Request(new Http('')), new Response(new Localization()));
        $view->setTemplate('something.txt');

        $view->serialize();
    }
}
