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

namespace Tests\PHPUnit\Modules\Organization\Models;

use Modules\Organization\Models\Position;
use Modules\Organization\Models\NullDepartment;
use Modules\Organization\Models\Status;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class PositionTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $position = new Position();

        self::assertEquals(0, $position->getId());
        self::assertEquals('', $position->getName());
        self::assertEquals('', $position->getDescription());
        self::assertInstanceOf('Modules\Organization\Models\NullPosition', $position->getParent());
        self::assertEquals(Status::INACTIVE, $position->getStatus());
        self::assertInstanceOf('\Modules\Organization\Models\NullDepartment', $position->getDepartment());
    }

    public function testSetGet()
    {
        $position = new Position();

        $position->setName('Name');
        self::assertEquals('Name', $position->getName());

        $position->setStatus(Status::ACTIVE);
        self::assertEquals(Status::ACTIVE, $position->getStatus());

        $position->setDepartment(1);
        self::assertEquals(1, $position->getDepartment());

        $position->setDescription('Description');
        self::assertEquals('Description', $position->getDescription());

        $position->setParent(1);
        self::assertEquals(1, $position->getParent());
    }
}
