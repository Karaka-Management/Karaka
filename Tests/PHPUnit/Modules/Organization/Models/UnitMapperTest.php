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

use Modules\Organization\Models\Unit;
use Modules\Organization\Models\UnitMapper;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class UnitMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $unit = new Unit();
        $unit->setName('Scrooge Inc.');
        $unit->setDescription('Description');
        $unit->setParent(1);

        $id = UnitMapper::create($unit);

        $unitR = UnitMapper::get($id);
        self::assertEquals($id, $unitR->getId());
        self::assertEquals($unit->getName(), $unitR->getName());
        self::assertEquals($unit->getDescription(), $unitR->getDescription());
        self::assertEquals($unit->getParent(), $unitR->getParent()->getId());
    }
}
