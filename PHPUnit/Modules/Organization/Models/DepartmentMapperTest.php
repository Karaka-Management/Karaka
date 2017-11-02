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
use Modules\Organization\Models\DepartmentMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class DepartmentMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $department = new Department();
        $department->setName('Management');
        $department->setDescription('Description');
        $department->setUnit(1);

        $id = DepartmentMapper::create($department);

        $departmentR = DepartmentMapper::get($id);
        self::assertEquals($id, $departmentR->getId());
        self::assertEquals($department->getName(), $departmentR->getName());
        self::assertEquals($department->getDescription(), $departmentR->getDescription());
        self::assertInstanceOf('Modules\Organization\Models\NullDepartment', $departmentR->getParent());
        self::assertEquals($department->getUnit(), $departmentR->getUnit()->getId());

    }

    /**
     * @group         volume
     * @slowThreshold 15000
     */
    public function testVolume()
    {
        /* 2 */
        $department = new Department();
        $department->setName('HR');
        $department->setDescription('Description');
        $department->setParent(1);
        $department->setUnit(1);
        DepartmentMapper::create($department);

        /* 3 */
        $department = new Department();
        $department->setName('QM');
        $department->setDescription('Description');
        $department->setParent(1);
        $department->setUnit(1);
        DepartmentMapper::create($department);

        /* 4 */
        $department = new Department();
        $department->setName('Sales');
        $department->setDescription('Description');
        $department->setParent(1);
        $department->setUnit(1);
        DepartmentMapper::create($department);

        /* 5 */
        $department = new Department();
        $department->setName('Shipping');
        $department->setDescription('Description');
        $department->setParent(4);
        $department->setUnit(1);
        DepartmentMapper::create($department);

        /* 6 */
        $department = new Department();
        $department->setName('Purchase');
        $department->setDescription('Description');
        $department->setParent(1);
        $department->setUnit(1);
        DepartmentMapper::create($department);

        /* 7 */
        $department = new Department();
        $department->setName('Arrival');
        $department->setDescription('Description');
        $department->setParent(6);
        $department->setUnit(1);
        DepartmentMapper::create($department);

        /* 8 */
        $department = new Department();
        $department->setName('Accounting');
        $department->setDescription('Description');
        $department->setParent(1);
        $department->setUnit(1);
        DepartmentMapper::create($department);

        /* 9 */
        $department = new Department();
        $department->setName('Production');
        $department->setDescription('Description');
        $department->setParent(1);
        $department->setUnit(1);
        DepartmentMapper::create($department);
    }
}
