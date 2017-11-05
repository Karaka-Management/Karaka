<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\Modules\ItemManagement\Models;

use Modules\ItemManagement\Models\Item;
use Modules\Media\Models\Media;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ItemTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $item = new Item();

        self::assertEquals(0, $item->getId());
        self::assertEmpty(0, $item->getNumber());
        self::assertEquals(0, $item->getArticleGroup());
        self::assertEquals(0, $item->getProductGroup());
        self::assertEquals(0, $item->getSegment());
        self::assertEquals(0, $item->getSuccessor());
        self::assertEmpty($item->getMedia());
        self::assertEmpty($item->getInfo());
        self::assertInstanceOf('\DateTime', $item->getCreatedAt());
    }

    public function testSetGet()
    {
        $item = new Item();

        $item->setNumber(1);
        self::assertEquals(1, $item->getNumber());

        $item->setArticleGroup(2);
        self::assertEquals(2, $item->getArticleGroup());

        $item->setProductGroup(3);
        self::assertEquals(3, $item->getProductGroup());

        $item->setSegment(4);
        self::assertEquals(4, $item->getSegment());

        $item->setSuccessor(5);
        self::assertEquals(5, $item->getSuccessor());

        $item->setInfo('info text');
        self::assertEquals('info text', $item->getInfo());

        $item->addMedia(new Media());
        self::assertInstanceOf('\Modules\Media\Models\Media', $item->getMedia()[0]);
    }
}
