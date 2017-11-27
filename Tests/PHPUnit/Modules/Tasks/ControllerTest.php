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

namespace Tests\PHPUnit\Modules\Task;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Module\ModuleFactory;
use phpOMS\Router\Router;
use phpOMS\Uri\Http;
use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\DataStorage\Session\HttpSession;
use phpOMS\Utils\TestUtils;
use Modules\Admin\Models\AccountPermission;
use phpOMS\Account\PermissionType;

class ControllerTest extends \PHPUnit\Framework\TestCase
{
    protected $app    = null;
    protected $module = null;

    protected function setUp()
    {
        $this->app = new class extends ApplicationAbstract
        {
        };

        $this->app->dbPool = $GLOBALS['dbpool'];
        $this->app->orgId = 1;
        $this->app->appName = 'backend';
        $this->app->accountManager = new AccountManager($GLOBALS['session']);

        $account = new Account();
        TestUtils::setMember($account, 'id', 1);

        $permission = new AccountPermission();
        $permission->setUnit(1);
        $permission->setApp('backend');
        $permission->setPermission(
            PermissionType::READ
            | PermissionType::CREATE
            | PermissionType::MODIFY
            | PermissionType::DELETE
            | PermissionType::PERMISSION
        );

        $account->addPermission($permission);

        $this->app->accountManager->add($account);
        $this->app->router = new Router();

        $this->module = ModuleFactory::getInstance('Tasks', $this->app);

        TestUtils::setMember($this->module, 'app', $this->app);
    }

    public function testCreateTask()
    {
        $response = new Response();
        $request = new Request(new Http(''));

        $request->getHeader()->setAccount(1);
        $request->setData('title', 'Controller Test Title');
        $request->setData('description', 'Controller Test Description');
        $request->setData('due', (new \DateTime)->format('Y-m-d H:i:s'));

        $this->module->apiTaskCreate($request, $response);

        self::assertEquals('Controller Test Title', $response->get('')['title']);
        self::assertGreaterThan(0, $response->get('')['id']);
    }
}