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

namespace Tests\PHPUnit\Modules;

use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Module\ModuleFactory;
use phpOMS\Module\ModuleManager;
use phpOMS\Module\NullModule;
use phpOMS\Router\Router;
use phpOMS\Version\Version;

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../config.php';

class ModuleTest extends \PHPUnit\Framework\TestCase
{
    protected $app = null;

    protected function setUp()
    {
        $this->app = new class extends ApplicationAbstract
        {
        };

        $this->app->dbPool     = $GLOBALS['dbpool'];
        $this->app->router     = new Router();
        $this->app->dispatcher = new Dispatcher($this->app);
    }

    public function testMembers()
    {
        $moduleManager = new ModuleManager($this->app, __DIR__ . '/../../../Modules');
        $allModules    = $moduleManager->getAllModules();

        foreach ($allModules as $name => $module) {
            $module = $moduleManager->get($name);

            if (!($module instanceof NullModule)) {
                self::assertEquals($name, $module::MODULE_NAME);
                self::assertEquals(realpath(__DIR__ . '/../../../Modules/' . $module::MODULE_NAME), $module::MODULE_PATH);
                $version = Version::compare($module::MODULE_VERSION, '1.0.0');
                self::assertGreaterThanOrEqual(0, $version);

                // todo: test routes
                // todo: test dependencies
                // todo: test providings
            }
        }
    }
}
