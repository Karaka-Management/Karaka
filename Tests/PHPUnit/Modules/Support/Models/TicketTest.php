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

namespace Tests\PHPUnit\Modules\Support\Models;

use Modules\Support\Models\Ticket;
use Modules\Tasks\Models\Task;
use Modules\Tasks\Models\TaskType;
use Modules\Tasks\Models\TaskStatus;
use Modules\Tasks\Models\TaskPriority;
use Modules\Tasks\Models\TaskElement;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class TicketTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $ticket = new Ticket();

        self::assertEquals(0, $ticket->getId());
        self::assertInstanceOf('\Modules\Tasks\Models\Task', $ticket->getTask());
        self::assertEquals(TaskType::HIDDEN, $ticket->getTask()->getType());
    }

    public function testSetGet()
    {
        $ticket = new Ticket();

        $ticket->getTask()->setCreatedBy(1);
        self::assertEquals(1, $ticket->getTask()->getCreatedBy());

        $ticket->getTask()->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $ticket->getTask()->getCreatedAt()->format('Y-m-d'));

        $ticket->getTask()->setTitle('Ticket');
        self::assertEquals('Ticket', $ticket->getTask()->getTitle());

        $ticket->getTask()->setDone($date = new \DateTime('2000-05-06'));
        self::assertEquals($date->format('Y-m-d'), $ticket->getTask()->getDone()->format('Y-m-d'));

        $ticket->getTask()->setDue($date = new \DateTime('2000-05-07'));
        self::assertEquals($date->format('Y-m-d'), $ticket->getTask()->getDue()->format('Y-m-d'));

        $ticket->getTask()->setStatus(TaskStatus::DONE);
        self::assertEquals(TaskStatus::DONE, $ticket->getTask()->getStatus());

        $ticket->getTask()->setPriority(TaskPriority::LOW);
        self::assertEquals(TaskPriority::LOW, $ticket->getTask()->getPriority());

        $id = [];
        $id[] = $ticket->getTask()->addElement(new TaskElement());
        $id[] = $ticket->getTask()->addElement(new TaskElement());
        $success = $ticket->getTask()->removeElement(99);

        self::assertFalse($success);

        $success = $ticket->getTask()->removeElement($id[1]);
        self::assertTrue($success);

        self::assertEquals(0, $ticket->getTask()->getTaskElements()[0]->getId());
        self::assertEquals(0, $ticket->getTask()->getTaskElement(0)->getId());

        $ticket->getTask()->setDescription('Ticket Description');
        self::assertEquals('Ticket Description', $ticket->getTask()->getDescription());

        self::assertInstanceOf('\Modules\Tasks\Models\TaskElement', $ticket->getTask()->getTaskElement(1));
    }
}
