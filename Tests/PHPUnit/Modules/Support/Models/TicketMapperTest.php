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

namespace Tests\PHPUnit\Modules\Support\Models;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

use Modules\Support\Models\Ticket;
use Modules\Support\Models\TicketMapper;
use Modules\Tasks\Models\Task;
use Modules\Tasks\Models\TaskElement;
use Modules\Tasks\Models\TaskStatus;
use Modules\Tasks\Models\TaskPriority;
use Modules\Tasks\Models\TaskType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\StringUtils;
use phpOMS\Utils\RnG\Text;

class TicketMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $ticket = new Ticket();

        $ticket->getTask()->setCreatedBy(1);
        $ticket->getTask()->getSchedule()->setCreatedBy(1);
        $ticket->getTask()->setTitle('Ticket Title');
        $ticket->getTask()->setStatus(TaskStatus::DONE);
        $ticket->getTask()->setType(TaskType::HIDDEN);
        $ticket->getTask()->setPriority(TaskPriority::HIGH);
        $ticket->getTask()->setDescription('Ticket Description');
        $ticket->getTask()->setDone(new \DateTime('2000-05-06'));
        $ticket->getTask()->setDue(new \DateTime('2000-05-05'));

        $taskElement1 = new TaskElement();
        $taskElement1->setDescription('Desc1');
        $taskElement1->setCreatedBy(1);
        $ticket->getTask()->addElement($taskElement1);

        $taskElement2 = new TaskElement();
        $taskElement2->setDescription('Desc2');
        $taskElement2->setCreatedBy(1);
        $ticket->getTask()->addElement($taskElement2);

        $id = TicketMapper::create($ticket);
        self::assertGreaterThan(0, $ticket->getId());
        self::assertEquals($id, $ticket->getId());

        $ticketR = TicketMapper::get($ticket->getId());
        self::assertEquals($ticket->getTask()->getCreatedAt()->format('Y-m-d'), $ticketR->getTask()->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($ticket->getTask()->getCreatedBy(), $ticketR->getTask()->getCreatedBy()->getId());
        self::assertEquals($ticket->getTask()->getDescription(), $ticketR->getTask()->getDescription());
        self::assertEquals($ticket->getTask()->getTitle(), $ticketR->getTask()->getTitle());
        self::assertEquals($ticket->getTask()->getStatus(), $ticketR->getTask()->getStatus());
        self::assertEquals($ticket->getTask()->getType(), $ticketR->getTask()->getType());
        self::assertEquals($ticket->getTask()->getDone()->format('Y-m-d'), $ticketR->getTask()->getDone()->format('Y-m-d'));
        self::assertEquals($ticket->getTask()->getDue()->format('Y-m-d'), $ticketR->getTask()->getDue()->format('Y-m-d'));

        $expected = $ticket->getTask()->getTaskElements();
        $actual   = $ticketR->getTask()->getTaskElements();
        self::assertEquals(end($expected)->getDescription(), end($actual)->getDescription());
    }

    public function testNewest()
    {
        $newest = TicketMapper::getNewest(1);

        self::assertEquals(1, count($newest));
    }

    /**
     * @group volume
     */
    public function testCreatedByMeForMe()
    {
        $text = new Text();

        $taskStatus = TaskStatus::getConstants();

        foreach ($taskStatus as $status) {
            $ticket = new Ticket();

            $ticket->getTask()->setCreatedBy(1);
            $ticket->getTask()->getSchedule()->setCreatedBy(1);
            $ticket->getTask()->setTitle($text->generateText(mt_rand(1, 5)));
            $ticket->getTask()->setStatus($status);
            $ticket->getTask()->setType(TaskType::HIDDEN);
            $ticket->getTask()->setDescription($text->generateText(mt_rand(10, 30)));
            $ticket->getTask()->setDone(new \DateTime('2000-05-06'));
            $ticket->getTask()->setDue(new \DateTime('2000-05-05'));

            $taskElement1 = new TaskElement();
            $taskElement1->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement1->setCreatedBy(1);
            $ticket->getTask()->addElement($taskElement1);

            $taskElement2 = new TaskElement();
            $taskElement2->setDescription('Desc2');
            $taskElement2->setCreatedBy(1);
            $ticket->getTask()->addElement($taskElement2);

            $id = TicketMapper::create($ticket);
        }
    }

    /**
     * @group volume
     */
    public function testCreatedByMeForOther()
    {
        $text = new Text();

        $taskStatus = TaskStatus::getConstants();

        foreach ($taskStatus as $status) {
            $ticket = new Ticket();

            $ticket->getTask()->setCreatedBy(1);
            $ticket->getTask()->getSchedule()->setCreatedBy(1);
            $ticket->getTask()->setTitle($text->generateText(mt_rand(1, 5)));
            $ticket->getTask()->setStatus($status);
            $ticket->getTask()->setType(TaskType::HIDDEN);
            $ticket->getTask()->setDescription($text->generateText(mt_rand(10, 30)));
            $ticket->getTask()->setDone(new \DateTime('2000-05-06'));
            $ticket->getTask()->setDue(new \DateTime('2000-05-05'));

            $taskElement1 = new TaskElement();
            $taskElement1->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement1->setCreatedBy(2);
            $ticket->getTask()->addElement($taskElement1);

            $taskElement2 = new TaskElement();
            $taskElement2->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement2->setCreatedBy(1);
            $ticket->getTask()->addElement($taskElement2);

            $id = TicketMapper::create($ticket);
        }
    }

    /**
     * @group volume
     */
    public function testCreatedByOtherForMe()
    {
        $text = new Text();

        $taskStatus = TaskStatus::getConstants();

        foreach ($taskStatus as $status) {
            $ticket = new Ticket();

            $ticket->getTask()->setCreatedBy(2);
            $ticket->getTask()->getSchedule()->setCreatedBy(2);
            $ticket->getTask()->setTitle($text->generateText(mt_rand(1, 5)));
            $ticket->getTask()->setStatus($status);
            $ticket->getTask()->setType(TaskType::HIDDEN);
            $ticket->getTask()->setDescription($text->generateText(mt_rand(10, 30)));
            $ticket->getTask()->setDone(new \DateTime('2000-05-06'));
            $ticket->getTask()->setDue(new \DateTime('2000-05-05'));

            $taskElement1 = new TaskElement();
            $taskElement1->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement1->setCreatedBy(1);
            $ticket->getTask()->addElement($taskElement1);

            $taskElement2 = new TaskElement();
            $taskElement2->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement2->setCreatedBy(2);
            $ticket->getTask()->addElement($taskElement2);

            $id = TicketMapper::create($ticket);
        }
    }
}
