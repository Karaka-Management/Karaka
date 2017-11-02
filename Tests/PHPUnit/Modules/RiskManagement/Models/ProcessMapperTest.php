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

use Modules\RiskManagement\Models\Process;
use Modules\RiskManagement\Models\ProcessMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ProcessMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $obj = new Process();
        $obj->setTitle('Name');
        $obj->setDescriptionRaw('Description');
        $obj->setDepartment(1);
        $obj->setResponsible(1);
        $obj->setDeputy(1);
        $obj->setUnit(1);

        ProcessMapper::create($obj);

        $objR = ProcessMapper::get($obj->getId());
        self::assertEquals($obj->getTitle(), $objR->getTitle());
        self::assertEquals($obj->getDescriptionRaw(), $objR->getDescriptionRaw());
        self::assertEquals($obj->getResponsible(), $objR->getResponsible());
        self::assertEquals($obj->getDeputy(), $objR->getDeputy());
        self::assertEquals($obj->getDepartment(), $objR->getDepartment()->getId());
        self::assertEquals($obj->getUnit(), $objR->getUnit()->getId());
    }
}