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

namespace Tests\PHPUnit\Modules\Organization\Models;

use Modules\Organization\Models\Department;
use Modules\Organization\Models\Status;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class DepartmentTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $department = new Department();

        self::assertEquals(0, $department->getId());
        self::assertEquals('', $department->getName());
        self::assertEquals('', $department->getDescription());
        self::assertInstanceOf('Modules\Organization\Models\NullDepartment', $department->getParent());
        self::assertEquals(1, $department->getUnit());
        self::assertEquals(Status::INACTIVE, $department->getStatus());
    }

    public function testSetGet()
    {
        $department = new Department();

        $department->setName('Name');
        self::assertEquals('Name', $department->getName());

        $department->setStatus(Status::ACTIVE);
        self::assertEquals(Status::ACTIVE, $department->getStatus());

        $department->setDescription('Description');
        self::assertEquals('Description', $department->getDescription());

        $department->setParent(1);
        self::assertEquals(1, $department->getParent());

        $department->setUnit(1);
        self::assertEquals(1, $department->getUnit());
    }
}
