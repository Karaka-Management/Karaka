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

use Modules\Tasks\Models\TaskElement;
use Modules\Tasks\Models\TaskStatus;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class TaskElementTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $task = new TaskElement();

        self::assertEquals(0, $task->getId());
        self::assertEquals(0, $task->getCreatedBy());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->modify('+1 day'), $task->getDue());
        self::assertEquals(TaskStatus::OPEN, $task->getStatus());
        self::assertEquals('', $task->getDescription());
        self::assertEquals(0, $task->getForwarded());
        self::assertEquals(0, $task->getTask());
    }

    public function testSetGet()
    {
        $task = new TaskElement();

        $task->setCreatedBy(1);
        self::assertEquals(1, $task->getCreatedBy());

        $task->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $task->getCreatedAt()->format('Y-m-d'));

        $task->setDue($date = new \DateTime('2000-05-07'));
        self::assertEquals($date->format('Y-m-d'), $task->getDue()->format('Y-m-d'));

        $task->setStatus(TaskStatus::DONE);
        self::assertEquals(TaskStatus::DONE, $task->getStatus());

        $task->setDescription('Description');
        self::assertEquals('Description', $task->getDescription());

        $task->setTask(2);
        self::assertEquals(2, $task->getTask());

        $task->setForwarded(3);
        self::assertEquals(3, $task->getForwarded());
    }

    /**
     * @expectedException \phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testInvalidStatus()
    {
        $task = new TaskElement();
        $task->setStatus(9999);
    }
}
