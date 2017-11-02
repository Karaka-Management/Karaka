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

namespace Tests\PHPUnit\Modules\ProjectManagement\Models;

use Modules\ProjectManagement\Models\Project;
use Modules\ProjectManagement\Models\ProgressType;
use Modules\Tasks\Models\Task;
use phpOMS\Localization\Money;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ProjectTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $project = new Project();

        self::assertEquals(0, $project->getId());
        self::assertInstanceOf('\Modules\Calendar\Models\Calendar', $project->getCalendar());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $project->getCreatedAt()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $project->getStart()->format('Y-m-d'));
        self::assertEquals((new \DateTime('now'))->modify('+1 month')->format('Y-m-d'), $project->getEnd()->format('Y-m-d'));
        self::assertEquals(0, $project->getCreatedBy());
        self::assertEquals('', $project->getName());
        self::assertEquals('', $project->getDescription());
        self::assertEquals(0, $project->getCosts()->getInt());
        self::assertEquals(0, $project->getBudget()->getInt());
        self::assertEquals(0, $project->getEarnings()->getInt());
        self::assertEquals(0, $project->getProgress());
        self::assertEquals(ProgressType::MANUAL, $project->getProgressType());
        self::assertEmpty($project->getTasks());
        self::assertFalse($project->removeTask(2));
        self::assertInstanceOf('\Modules\Tasks\Models\Task', $project->getTask(0));
    }

    public function testSetGet()
    {
        $project = new Project();

        $project->setName('Project');
        self::assertEquals('Project', $project->getName());

        $project->setDescription('Description');
        self::assertEquals('Description', $project->getDescription());

        $project->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $project->getCreatedAt()->format('Y-m-d'));

        $project->setStart($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $project->getStart()->format('Y-m-d'));

        $project->setEnd($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $project->getEnd()->format('Y-m-d'));

        $money = new Money();
        $money->setString('1.23');

        $project->setCosts($money);
        self::assertEquals($money->getAmount(), $project->getCosts()->getAmount());

        $project->setBudget($money);
        self::assertEquals($money->getAmount(), $project->getBudget()->getAmount());

        $project->setEarnings($money);
        self::assertEquals($money->getAmount(), $project->getEarnings()->getAmount());

        $task = new Task();
        $task->setTitle('A');
        $task->setCreatedBy(1);
        
        $project->addTask($task);

        self::assertEquals('A', $project->getTask(0)->getTitle());
        self::assertEquals(1, count($project->getTasks()));
        self::assertTrue($project->removeTask(0));
        self::assertEquals(0, $project->countTasks());

        $project->setProgress(10);
        self::assertEquals(10, $project->getProgress());

        $project->setProgressType(ProgressType::TASKS);
        self::assertEquals(ProgressType::TASKS, $project->getProgressType());
    }
}
