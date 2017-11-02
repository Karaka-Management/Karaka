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

use Modules\Organization\Models\Position;
use Modules\Organization\Models\PositionMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class PositionMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $position = new Position();
        $position->setName('CEO');
        $position->setDescription('Description');

        $id = PositionMapper::create($position);

        $positionR = PositionMapper::get($id);
        self::assertEquals($id, $positionR->getId());
        self::assertEquals($position->getName(), $positionR->getName());
        self::assertEquals($position->getDescription(), $positionR->getDescription());
        self::assertInstanceOf('Modules\Organization\Models\NullPosition', $positionR->getParent());
    }

    /**
     * @group         volume
     * @slowThreshold 15000
     */
    public function testVolume()
    {
        /* 2 */
        $position = new Position();
        $position->setName('CFO');
        $position->setDescription('Description');
        $position->setParent(1);
        PositionMapper::create($position);

        /* 3 */
        $position = new Position();
        $position->setName('Accountant');
        $position->setDescription('Description');
        $position->setParent(2);
        PositionMapper::create($position);

        /* 4 */
        $position = new Position();
        $position->setName('Controller');
        $position->setDescription('Description');
        $position->setParent(2);
        PositionMapper::create($position);

        /* 5 */
        $position = new Position();
        $position->setName('Sales Director');
        $position->setDescription('Description');
        $position->setParent(1);
        PositionMapper::create($position);

        /* 6 */
        $position = new Position();
        $position->setName('Purchase Director');
        $position->setDescription('Description');
        $position->setParent(1);
        PositionMapper::create($position);

        /* 7 */
        $position = new Position();
        $position->setName('Territory Manager');
        $position->setDescription('Description');
        $position->setParent(5);
        PositionMapper::create($position);

        /* 8 */
        $position = new Position();
        $position->setName('Territory Sales Assistant');
        $position->setDescription('Description');
        $position->setParent(7);
        PositionMapper::create($position);

        /* 9 */
        $position = new Position();
        $position->setName('Domestic Sales Manager');
        $position->setDescription('Description');
        $position->setParent(5);
        PositionMapper::create($position);
    }
}
