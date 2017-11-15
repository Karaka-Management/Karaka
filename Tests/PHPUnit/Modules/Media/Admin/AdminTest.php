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

namespace Tests\PHPUnit\Modules\Media\Admin;

use Modules\Media\Admin\Installer;
use Modules\Media\Admin\Uninstall;
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
    protected $dbPool = null;

    protected function setUp()
    {
        $this->dbPool = new DatabasePool();
        /** @var array $CONFIG */
        $this->dbPool->create('core', $GLOBALS['CONFIG']['db']['core']['masters']['admin']);
    }

    /**
     * @group admin
     * @slowThreshold 5000
     */
    public function testModuleIntegration() 
    {
        $app = new class extends ApplicationAbstract {};
        $app->dbPool = $GLOBALS['dbpool'];

        $moduleManager = new ModuleManager($app, __DIR__ . '/../../../../../Modules');
        $moduleManager->install('Media');

        $moduleManager->deactivate('Media');
        self::assertFalse($moduleManager->isActive('Media'));

        $moduleManager->activate('Media');
        self::assertTrue($moduleManager->isActive('Media'));
    }

    public function testRequestLoads()
    {
        $app = new class extends ApplicationAbstract {};
        $app->dbPool = $GLOBALS['dbpool'];
        $app->dispatcher = new Dispatcher($app);
    
        $moduleManager = new ModuleManager($app, __DIR__ . '/../../../../../Modules');

        $request = new Request(new Http('http://127.0.0.1/en/backend/media'));
        $request->createRequestHashs(1);

        $loaded = $moduleManager->getUriLoad($request);
        
        $found = false;
        foreach ($loaded[4] as $module) {
            if ($module['module_load_file'] === 'Media') {
                $found = true;
                break;
            }
        }

        self::assertTrue($found);
        self::assertGreaterThan(0, count($moduleManager->getLanguageFiles($request)));
        self::assertTrue(in_array('Media', $moduleManager->getRoutedModules($request)));

        $moduleManager->initRequestModules($request);
        self::assertTrue(isset(TestUtils::getMember($moduleManager, 'running')['Media']));
    }
}
