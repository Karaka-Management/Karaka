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

namespace Tests\PHPUnit\Modules\Marketing\Models;

use Modules\Marketing\Models\Promotion;
use Modules\Marketing\Models\PromotionMapper;
use Modules\Tasks\Models\Task;
use Modules\Media\Models\Media;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Localization\Money;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class PromotionMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $promotion = new Promotion();

        $promotion->setName('Promotionname');
        $promotion->setDescription('Description');
        $promotion->setCreatedBy(1);
        $promotion->setStart(new \DateTime('2000-05-05'));
        $promotion->setEnd(new \DateTime('2005-05-05'));

        $money = new Money();
        $money->setString('1.23');

        $promotion->setCosts($money);
        $promotion->setBudget($money);
        $promotion->setEarnings($money);

        $task = new Task();
        $task->setTitle('PromotionTask 1');
        $task->setCreatedBy(1);

        $task2 = new Task();
        $task2->setTitle('PromotionTask 2');
        $task2->setCreatedBy(1);

        $promotion->addTask($task);
        $promotion->addTask($task2);

        $media = new Media();
        $media->setCreatedBy(1);
        $media->setDescription('desc');
        $media->setPath('some/path');
        $media->setSize(11);
        $media->setExtension('png');
        $media->setName('Promotion Media');
        $promotion->addMedia($media);

        $id = PromotionMapper::create($promotion);
        self::assertGreaterThan(0, $promotion->getId());
        self::assertEquals($id, $promotion->getId());

        $promotionR = PromotionMapper::get($promotion->getId());

        self::assertEquals($promotion->getName(), $promotionR->getName());
        self::assertEquals($promotion->getDescription(), $promotionR->getDescription());
        self::assertEquals($promotion->countTasks(), $promotionR->countTasks());
        self::assertEquals($promotion->getCosts()->getAmount(), $promotionR->getCosts()->getAmount());
        self::assertEquals($promotion->getBudget()->getAmount(), $promotionR->getBudget()->getAmount());
        self::assertEquals($promotion->getEarnings()->getAmount(), $promotionR->getEarnings()->getAmount());
        self::assertEquals($promotion->getCreatedAt()->format('Y-m-d'), $promotionR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($promotion->getStart()->format('Y-m-d'), $promotionR->getStart()->format('Y-m-d'));
        self::assertEquals($promotion->getEnd()->format('Y-m-d'), $promotionR->getEnd()->format('Y-m-d'));

        $expected = $promotion->getMedia();
        $actual = $promotionR->getMedia();

        self::assertEquals(end($expected)->getName(), end($actual)->getName());   
    }

    public function testNewest()
    {
        $newest = PromotionMapper::getNewest(1);

        self::assertEquals(1, count($newest));
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 100; $i++) {
            $text = new Text();

            $promotion = new Promotion();

            $promotion->setName($text->generateText(mt_rand(3, 7)));
            $promotion->setDescription($text->generateText(mt_rand(20, 100)));
            $promotion->setCreatedBy(1);
            $promotion->setStart(new \DateTime('2000-05-05'));
            $promotion->setEnd(new \DateTime('2005-05-05'));

            $money = new Money();
            $money->setString('1.23');

            $promotion->setCosts($money);
            $promotion->setBudget($money);
            $promotion->setEarnings($money);

            $id = PromotionMapper::create($promotion);
        }
    }
}
