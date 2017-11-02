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

namespace Tests\PHPUnit\Modules\ItemManagement\Models;

use Modules\ItemManagement\Models\Item;
use Modules\ItemManagement\Models\ItemMapper;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Name;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ItemMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $item = new Item();

        $item->setNumber(1);
        $item->setArticleGroup(2);
        $item->setProductGroup(3);
        $item->setSegment(4);
        $item->setSalesGroup(6);
        $item->setSuccessor(5);
        $item->setInfo('info text');

        $id = ItemMapper::create($item);
        self::assertGreaterThan(0, $item->getId());
        self::assertEquals($id, $item->getId());

        $itemR = ItemMapper::get($item->getId());
        self::assertEquals($item->getNumber(), $itemR->getNumber());
        self::assertEquals($item->getSegment(), $itemR->getSegment());
        self::assertEquals($item->getArticleGroup(), $itemR->getArticleGroup());
        self::assertEquals($item->getProductGroup(), $itemR->getProductGroup());
        self::assertEquals($item->getSalesGroup(), $itemR->getSalesGroup());
        self::assertEquals($item->getInfo(), $itemR->getInfo());
        self::assertEquals($item->getSuccessor(), $itemR->getSuccessor());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 1000; $i++) {
            $item = new Item();

            $item->setNumber($i+1);
            $item->setArticleGroup(mt_rand(1000, 3000));
            $item->setProductGroup(mt_rand(11, 30));
            $item->setSegment(mt_rand(1, 9));
            $item->setSalesGroup(mt_rand(100, 300));
            $item->setSuccessor(5);
            $item->setInfo('info text');

            $id = ItemMapper::create($item);
        }
    }
}
