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

namespace Tests\PHPUnit\phpOMS\Module;

use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\Router;
use phpOMS\Security\Encryption\Encryption;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class ModuleManagerTest extends \PHPUnit\Framework\TestCase
{
    protected $app = null;

    protected function setUp()
    {
        $this->app = new class extends ApplicationAbstract {};
        $this->app->dbPool = $GLOBALS['dbpool'];
        $this->app->dispatcher = new Dispatcher($this->app);
    }

    public function testAttributes()
    {
        $moduleManager = new ModuleManager($this->app, __DIR__ . '/../../../../Modules');
        self::assertInstanceOf('\phpOMS\Module\ModuleManager', $moduleManager);

        self::assertObjectHasAttribute('running', $moduleManager);
        self::assertObjectHasAttribute('installed', $moduleManager);
        self::assertObjectHasAttribute('active', $moduleManager);
        self::assertObjectHasAttribute('all', $moduleManager);
        self::assertObjectHasAttribute('uriLoad', $moduleManager);
    }

    public function testUnknownModuleInit()
    {
        $moduleManager = new ModuleManager($this->app, __DIR__ . '/../../../../Modules');
        $moduleManager->initModule('doesNotExist');
        self::assertInstanceOf('\phpOMS\Module\NullModule', $moduleManager->get('doesNotExist'));
    }

    public function testUnknownModuleGet()
    {
        $moduleManager = new ModuleManager($this->app, __DIR__ . '/../../../../Modules');
        self::assertInstanceOf('\phpOMS\Module\NullModule', $moduleManager->get('doesNotExist2'));
    }

    public function testGetSet()
    {
        $this->app->router = new Router();
        $this->app->dispatcher = new Dispatcher($this->app);

        $moduleManager = new ModuleManager($this->app, __DIR__ . '/../../../../Modules');

        $active    = $moduleManager->getActiveModules();
        $all       = $moduleManager->getAllModules();
        $installed = $moduleManager->getInstalledModules();

        self::assertNotEmpty($active);
        self::assertNotEmpty($all);
        self::assertNotEmpty($installed);

        self::assertInstanceOf('\phpOMS\Module\ModuleAbstract', $moduleManager->get('Admin'));
        self::assertInstanceOf('\Modules\Admin\Controller', $moduleManager->get('Admin'));
    }
}
