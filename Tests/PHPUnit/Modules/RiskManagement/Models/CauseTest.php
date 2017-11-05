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

use Modules\RiskManagement\Models\Cause;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class CauseTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $obj = new Cause();

        self::assertEquals(0, $obj->getId());
        self::assertEquals('', $obj->getTitle());
        self::assertEquals('', $obj->getDescription());
        self::assertEquals('', $obj->getDescriptionRaw());
        self::assertEquals(0, $obj->getProbability());
        self::assertEquals(null, $obj->getDepartment());
        self::assertEquals(null, $obj->getRisk());
        self::assertEquals(null, $obj->getCategory());
    }

    public function testSetGet()
    {
        $obj = new Cause();

        $obj->setTitle('Name');
        self::assertEquals('Name', $obj->getTitle());

        $obj->setDescriptionRaw('Description');
        self::assertEquals('Description', $obj->getDescriptionRaw());

        $obj->setProbability(1);
        self::assertEquals(1, $obj->getProbability());

        $obj->setCategory(2);
        self::assertEquals(2, $obj->getCategory());

        $obj->setRisk(1);
        self::assertEquals(1, $obj->getRisk());

        $obj->setDepartment(1);
        self::assertEquals(1, $obj->getDepartment());
    }
}