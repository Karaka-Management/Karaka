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

namespace Tests\PHPUnit\Modules\RiskManagement\Models;

use Modules\RiskManagement\Models\Department;
use Modules\RiskManagement\Models\DepartmentMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class DepartmentMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $obj = new Department();
        $obj->setDepartment(1);
        $obj->setResponsible(1);
        $obj->setDeputy(1);

        DepartmentMapper::create($obj);

        $objR = DepartmentMapper::get($obj->getId());
        self::assertEquals($obj->getDepartment(), $objR->getDepartment()->getId());
        self::assertEquals($obj->getResponsible(), $objR->getResponsible());
        self::assertEquals($obj->getDeputy(), $objR->getDeputy());
    }
}