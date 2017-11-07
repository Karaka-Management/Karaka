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

namespace Tests\PHPUnit\Modules\Tasks\Models;

use Modules\Tasks\Models\Task;
use Modules\Tasks\Models\TaskElement;
use Modules\Tasks\Models\TaskStatus;
use Modules\Tasks\Models\TaskPriority;
use Modules\Tasks\Models\TaskType;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class TaskTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $task = new Task();

        self::assertEquals(0, $task->getId());
        self::assertEquals(0, $task->getCreatedBy());
        self::assertEquals('', $task->getTitle());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $task->getStart()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $task->getDone()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->modify('+1 day')->format('Y-m-d'), $task->getDue()->format('Y-m-d'));
        self::assertEquals(TaskStatus::OPEN, $task->getStatus());
        self::assertTrue($task->isClosable());
        self::assertEquals(TaskPriority::MEDIUM, $task->getPriority());
        self::assertEquals(TaskType::SINGLE, $task->getType());
        self::assertEquals([], $task->getTaskElements());
        self::assertEquals('', $task->getDescription());
        self::assertInstanceOf('\Modules\Tasks\Models\NullTaskElement', $task->getTaskElement(1));
    }

    public function testSetGet()
    {
        $task = new Task();

        $task->setCreatedBy(1);
        self::assertEquals(1, $task->getCreatedBy());

        $task->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));

        $task->setStart($date = new \DateTime('2005-05-05'));
        self::assertEquals($date->format('Y-m-d'), $task->getStart()->format('Y-m-d'));

        $task->setTitle('Title');
        self::assertEquals('Title', $task->getTitle());

        $task->setDone($date = new \DateTime('2000-05-06'));
        self::assertEquals($date->format('Y-m-d'), $task->getDone()->format('Y-m-d'));

        $task->setDue($date = new \DateTime('2000-05-07'));
        self::assertEquals($date->format('Y-m-d'), $task->getDue()->format('Y-m-d'));

        $task->setStatus(TaskStatus::DONE);
        self::assertEquals(TaskStatus::DONE, $task->getStatus());

        $task->setClosable(false);
        self::assertFalse($task->isClosable());

        $task->setPriority(TaskPriority::LOW);
        self::assertEquals(TaskPriority::LOW, $task->getPriority());

        $id = [];
        $id[] = $task->addElement(new TaskElement());
        $id[] = $task->addElement(new TaskElement());
        $success = $task->removeElement(99);

        self::assertFalse($success);

        $success = $task->removeElement($id[1]);
        self::assertTrue($success);

        self::assertEquals(0, $task->getTaskElements()[0]->getId());
        self::assertEquals(0, $task->getTaskElement(0)->getId());

        $task->setDescription('Description');
        self::assertEquals('Description', $task->getDescription());

        self::assertInstanceOf('\Modules\Tasks\Models\TaskElement', $task->getTaskElement(1));

        $arr = [
            'id' => 0,
            'createdBy' => $task->getCreatedBy(),
            'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            'title' => $task->getTitle(),
            'description' => $task->getDescription(),
            'status' => $task->getStatus(),
            'type' => $task->getType(),
            'priority' => $task->getPriority(),
            'due' => $task->getDue()->format('Y-m-d H:i:s'),
            'done' => $task->getDone()->format('Y-m-d H:i:s'),
        ];
        self::assertEquals($arr, $task->toArray());
        self::assertEquals($arr, $task->jsonSerialize());
    }

    /**
     * @expectedException \phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testInvalidStatus()
    {
        $task = new Task();
        $task->setStatus(9999);
    }
    
    /**
     * @expectedException \phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testInvalidPriority()
    {
        $task = new Task();
        $task->setPriority(9999);
    }
}
