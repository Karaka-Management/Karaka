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

namespace Tests\PHPUnit\Modules\Reporter;

use Modules\Media\Models\UploadStatus;
use Modules\Reporter\Models\TemplateDataType;
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

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

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

        $this->module = ModuleFactory::getInstance('Reporter', $this->app);

        TestUtils::setMember($this->module, 'app', $this->app);
    }

    /**
     * @group admin
     */
    public function testCreateTemplate()
    {
        $media = ModuleFactory::getInstance('Media', $this->app);

        $status = [
            [
                'status' => UploadStatus::OK,
                'extension' => 'php',
                'filename' => 'EventCourse.lang.php',
                'name' => 'EventCourse',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'php',
                'filename' => 'EventCourse.pdf.php',
                'name' => 'EventCourse',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'php',
                'filename' => 'EventCourse.tpl.php',
                'name' => 'EventCourse',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'php',
                'filename' => 'EventCourse.xlsx.php',
                'name' => 'EventCourse',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'php',
                'filename' => 'Worker.php',
                'name' => 'Worker',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
        ];

        $mediaFiles = $media->createDbEntries($status, 1);
        
        $ids = [];
        foreach ($mediaFiles as $file) {
            $ids[] = $file->getId();
        }

        $request = new Request(new Http(''));

        $request->setData('name', 'Test template');
        $request->setData('description', 'Template description');
        $request->setData('datatype', TemplateDataType::OTHER);
        $request->setData('files', json_encode($ids));
        $request->getHeader()->setAccount(1);

        $response = new Response(new Localization());
        $this->module->apiTemplateCreate($request, $response);

        self::assertEquals('Test template', $response->get('')['name']);
        self::assertGreaterThan(0, $response->get('')['id']);
    }

    /**
     * @group admin
     */
    public function testCreateReport()
    {
        $media = ModuleFactory::getInstance('Media', $this->app);

        $status = [
            [
                'status' => UploadStatus::OK,
                'extension' => 'csv',
                'filename' => 'accounts.csv',
                'name' => 'accounts',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'csv',
                'filename' => 'costcenters.csv',
                'name' => 'costcenters',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'csv',
                'filename' => 'costobjects.csv',
                'name' => 'costobjects',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'csv',
                'filename' => 'crm.csv',
                'name' => 'crm',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'csv',
                'filename' => 'entries.csv',
                'name' => 'entries',
                'path' => 'Demo/Modules/Reporter/EventCourse',
                'size' => 1,
            ],
        ];

        $mediaFiles = $media->createDbEntries($status, 1);

        $ids = [];
        foreach ($mediaFiles as $file) {
            $ids[] = $file->getId();
        }
 
        $request = new Request(new Http(''));
        $request->setData('name', 'Test report');
        $request->setData('template', 1);
        $request->setData('files', json_encode($ids));
        $request->getHeader()->setAccount(1);

        $response = new Response(new Localization());
        $this->module->apiReportCreate($request, $response);
    }

}
