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

namespace Tests\PHPUnit\Modules\RiskManagement\Models;

use Modules\RiskManagement\Models\Risk;
use Modules\RiskManagement\Models\Cause;
use Modules\RiskManagement\Models\Solution;
use Modules\RiskManagement\Models\Department;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class RiskTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $obj = new Risk();

        self::assertEquals(0, $obj->getId());
        self::assertEquals('', $obj->getName());
        self::assertEquals('', $obj->getDescription());
        self::assertEquals('', $obj->getDescriptionRaw());
        self::assertEquals(1, $obj->getUnit());
        self::assertEquals(null, $obj->getDepartment());
        self::assertEquals(null, $obj->getCategory());
        self::assertEquals(null, $obj->getProcess());
        self::assertEquals(null, $obj->getProject());
        self::assertEquals(null, $obj->getResponsible());
        self::assertEquals(null, $obj->getDeputy());
        self::assertEquals([], $obj->getHistory());
        self::assertEquals([], $obj->getCauses());
        self::assertEquals([], $obj->getSolutions());
        self::assertEquals([], $obj->getRiskObjects());
        self::assertEquals([], $obj->getMedia());
    }

    public function testSetGet()
    {
        $obj = new Risk();

        $obj->setName('Name');
        self::assertEquals('Name', $obj->getName());

        $obj->setDescriptionRaw('Description');
        self::assertEquals('Description', $obj->getDescriptionRaw());

        $obj->setUnit(1);
        self::assertEquals(1, $obj->getUnit());

        $obj->setCategory(3);
        self::assertEquals(3, $obj->getCategory());

        $obj->setProcess(4);
        self::assertEquals(4, $obj->getProcess());

        $department = new Department();
        $department->setDepartment(1);
        $obj->setDepartment($department);

        $obj->setResponsible(1);
        self::assertEquals(1, $obj->getResponsible());

        $obj->setDeputy(1);
        self::assertEquals(1, $obj->getDeputy());

        $obj->addCause(new Cause());
        self::assertEquals(1, count($obj->getCauses()));
        self::assertInstanceOf('\Modules\RiskManagement\Models\Cause', $obj->getCauses()[0]);

        $obj->addSolution(new Solution());
        self::assertEquals(1, count($obj->getSolutions()));
        self::assertInstanceOf('\Modules\RiskManagement\Models\Solution', $obj->getSolutions()[0]);

        $obj->addRiskObject(2);
        self::assertEquals(1, count($obj->getRiskObjects()));

        $obj->addHistory(2);
        self::assertEquals(1, count($obj->getHistory()));

        $obj->addMedia(2);
        self::assertEquals(1, count($obj->getMedia()));
    }
}