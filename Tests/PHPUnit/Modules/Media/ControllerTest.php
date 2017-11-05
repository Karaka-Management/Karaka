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

namespace Tests\PHPUnit\Modules\Media;

use Modules\Media\Models\UploadStatus;
use phpOMS\ApplicationAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\ModuleFactory;
use phpOMS\Router\Router;

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

        $this->app->dbPool = new DatabasePool();
        /** @var array $CONFIG */
        $this->app->dbPool->create('core', $GLOBALS['CONFIG']['db']['core']['masters']['admin']);

        $this->app->router = new Router();

        $this->module = ModuleFactory::getInstance('Media', $this->app);
    }

    public function testCreateDbEntries()
    {
        $status = [
            [
                'status' => UploadStatus::OK,
                'extension' => 'png',
                'filename' => 'logo.png',
                'name' => 'logo.png',
                'path' => 'Tests/PHPUnit/Modules/Media/Files/',
                'size' => 90210,
            ],
            [
                'status' => UploadStatus::FAILED_HASHING,
                'extension' => 'png',
                'filename' => 'logo.png',
                'name' => 'logo.png',
                'path' => 'Tests/PHPUnit/Modules/Media/Files/',
                'size' => 90210,
            ],
            [
                'status' => UploadStatus::OK,
                'extension' => 'png',
                'filename' => 'logo2.png',
                'name' => 'logo2.png',
                'path' => 'Tests/PHPUnit/Modules/Media/Files/',
                'size' => 90210,
            ],
        ];

        $ids = $this->module->createDbEntries($status, 1);
        self::assertEquals(2, count($ids));
    }

}
