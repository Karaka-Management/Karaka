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

use Modules\RiskManagement\Models\Solution;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class SolutionTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $obj = new Solution();

        self::assertEquals(0, $obj->getId());
        self::assertEquals('', $obj->getTitle());
        self::assertEquals('', $obj->getDescription());
        self::assertEquals('', $obj->getDescriptionRaw());
        self::assertEquals(0.0, $obj->getProbability());
        self::assertEquals(0, $obj->getCause());
        self::assertEquals(0, $obj->getRisk());
    }

    public function testSetGet()
    {
        $obj = new Solution();

        $obj->setTitle('Title');
        self::assertEquals('Title', $obj->getTitle());

        $obj->setDescriptionRaw('Description');
        self::assertEquals('Description', $obj->getDescriptionRaw());

        $obj->setProbability(1);
        self::assertEquals(1, $obj->getProbability());

        $obj->setCause(1);
        self::assertEquals(1, $obj->getCause());

        $obj->setRisk(1);
        self::assertEquals(1, $obj->getRisk());
    }
}