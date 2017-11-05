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
use Modules\Tasks\Models\Task;
use phpOMS\Localization\Money;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class PromotionTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $promotion = new Promotion();

        self::assertEquals(0, $promotion->getId());
        self::assertInstanceOf('\Modules\Calendar\Models\Calendar', $promotion->getCalendar());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $promotion->getCreatedAt()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $promotion->getStart()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->modify('+1 month')->format('Y-m-d'), $promotion->getEnd()->format('Y-m-d'));
        self::assertEquals(0, $promotion->getCreatedBy());
        self::assertEquals('', $promotion->getName());
        self::assertEquals('', $promotion->getDescription());
        self::assertEquals(0, $promotion->getCosts()->getInt());
        self::assertEquals(0, $promotion->getBudget()->getInt());
        self::assertEquals(0, $promotion->getEarnings()->getInt());
        self::assertEmpty($promotion->getTasks());
        self::assertFalse($promotion->removeTask(2));
        self::assertInstanceOf('\Modules\Tasks\Models\Task', $promotion->getTask(0));
    }

    public function testSetGet()
    {
        $promotion = new Promotion();

        $promotion->setName('Promotion');
        self::assertEquals('Promotion', $promotion->getName());

        $promotion->setDescription('Description');
        self::assertEquals('Description', $promotion->getDescription());

        $promotion->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $promotion->getCreatedAt()->format('Y-m-d'));

        $promotion->setStart($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $promotion->getStart()->format('Y-m-d'));

        $promotion->setEnd($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $promotion->getEnd()->format('Y-m-d'));

        $money = new Money();
        $money->setString('1.23');

        $promotion->setCosts($money);
        self::assertEquals($money->getAmount(), $promotion->getCosts()->getAmount());

        $promotion->setBudget($money);
        self::assertEquals($money->getAmount(), $promotion->getBudget()->getAmount());

        $promotion->setEarnings($money);
        self::assertEquals($money->getAmount(), $promotion->getEarnings()->getAmount());

        $task = new Task();
        $task->setTitle('Promo Task A');
        $task->setCreatedBy(1);
        
        $promotion->addTask($task);

        self::assertEquals('Promo Task A', $promotion->getTask(0)->getTitle());
        self::assertEquals(1, count($promotion->getTasks()));
        self::assertTrue($promotion->removeTask(0));
        self::assertEquals(0, $promotion->countTasks());
    }
}
