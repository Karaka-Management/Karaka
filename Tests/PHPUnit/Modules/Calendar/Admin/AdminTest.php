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

namespace Tests\PHPUnit\Modules\Calendar\Admin;

use Modules\Calendar\Admin\Installer;
use Modules\Calendar\Admin\Uninstall;
use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\ModuleManager;
use phpOMS\Message\Http\Request;
use phpOMS\Uri\Http;
use phpOMS\Utils\TestUtils;
use phpOMS\Dispatcher\Dispatcher;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class AdminTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @group admin
     * @slowThreshold 5000
     */
    public function testModuleIntegration() 
    {
        $app = new class extends ApplicationAbstract {};
        $app->dbPool = $GLOBALS['dbpool'];

        $moduleManager = new ModuleManager($app, __DIR__ . '/../../../../../Modules');
        $moduleManager->install('Calendar');

        $moduleManager->deactivate('Calendar');
        self::assertFalse($moduleManager->isActive('Calendar'));

        $moduleManager->activate('Calendar');
        self::assertTrue($moduleManager->isActive('Calendar'));
    }

    public function testRequestLoads()
    {
        $app = new class extends ApplicationAbstract {};
        $app->dbPool = $GLOBALS['dbpool'];
        $app->dispatcher = new Dispatcher($app);
    
        $moduleManager = new ModuleManager($app, __DIR__ . '/../../../../../Modules');

        $request = new Request(new Http('http://127.0.0.1/en/backend/calendar'));
        $request->createRequestHashs(1);

        $loaded = $moduleManager->getUriLoad($request);
        
        $found = false;
        foreach ($loaded[4] as $module) {
            if ($module['module_load_file'] === 'Calendar') {
                $found = true;
                break;
            }
        }

        self::assertTrue($found);
        self::assertGreaterThan(0, count($moduleManager->getLanguageFiles($request)));
        self::assertTrue(in_array('Calendar', $moduleManager->getRoutedModules($request)));

        $moduleManager->initRequestModules($request);
        self::assertTrue(isset(TestUtils::getMember($moduleManager, 'running')['Calendar']));
    }
}
