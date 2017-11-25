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

namespace Tests\PHPUnit\Modules\Admin\Models;

use Modules\Admin\Models\Module;
use phpOMS\Module\ModuleStatus;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ModuleTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $module = new Module();
        self::assertEquals(0, $module->getId());
        self::assertInstanceOf('\DateTime', $module->getCreatedAt());
        self::assertEquals('', $module->getName());
        self::assertEquals('', $module->getDescription());
        self::assertEquals(ModuleStatus::INACTIVE, $module->getStatus());
    }

    public function testGetSet()
    {
        $module = new Module();

        $module->setName('Name');
        self::assertEquals('Name', $module->getName());

        $module->setDescription('Desc');
        self::assertEquals('Desc', $module->getDescription());

        $module->setStatus(ModuleStatus::ACTIVE);
        self::assertEquals(ModuleStatus::ACTIVE, $module->getStatus());
    }
}
