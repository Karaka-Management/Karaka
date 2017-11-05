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

use Modules\RiskManagement\Models\Process;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ProcessTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $obj = new Process();

        self::assertEquals(0, $obj->getId());
        self::assertEquals('', $obj->getTitle());
        self::assertEquals('', $obj->getDescription());
        self::assertEquals('', $obj->getDescriptionRaw());
        self::assertEquals(null, $obj->getDepartment());
        self::assertEquals(1, $obj->getUnit());
        self::assertEquals(null, $obj->getResponsible());
        self::assertEquals(null, $obj->getDeputy());
    }

    public function testSetGet()
    {
        $obj = new Process();

        $obj->setTitle('Name');
        self::assertEquals('Name', $obj->getTitle());

        $obj->setDescriptionRaw('Description');
        self::assertEquals('Description', $obj->getDescriptionRaw());

        $obj->setResponsible(1);
        self::assertEquals(1, $obj->getResponsible());

        $obj->setDeputy(1);
        self::assertEquals(1, $obj->getDeputy());

        $obj->setUnit(1);
        self::assertEquals(1, $obj->getUnit());

        $obj->setDepartment(2);
        self::assertEquals(2, $obj->getDepartment());
    }
}