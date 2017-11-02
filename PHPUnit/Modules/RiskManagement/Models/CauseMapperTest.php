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

use Modules\RiskManagement\Models\Risk;
use Modules\RiskManagement\Models\Department;
use Modules\RiskManagement\Models\Category;
use Modules\RiskManagement\Models\Cause;
use Modules\RiskManagement\Models\CauseMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class CauseMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $obj = new Cause();
        $obj->setTitle('Cause Test');
        $obj->setDescriptionRaw('Description');
        $obj->setProbability(1);

        $department = new Department();
        $department->setDepartment(1);
        $obj->setDepartment($department);

        $category = new Category();
        $category->setTitle('Test Cat');
        $obj->setCategory($category);

        $risk = new Risk();
        $risk->setName('Cause Test Risk');
        $risk->setUnit(1);
        $obj->setRisk($risk);

        CauseMapper::create($obj);

        $objR = CauseMapper::get($obj->getId());
        self::assertEquals($obj->getTitle(), $objR->getTitle());
        self::assertEquals($obj->getDescriptionRaw(), $objR->getDescriptionRaw());
        self::assertEquals($obj->getDepartment()->getDepartment(), $objR->getDepartment()->getDepartment()->getId());
        self::assertEquals($obj->getCategory()->getTitle(), $objR->getCategory()->getTitle());
        self::assertEquals($obj->getRisk()->getName(), $objR->getRisk()->getName());
    }
}