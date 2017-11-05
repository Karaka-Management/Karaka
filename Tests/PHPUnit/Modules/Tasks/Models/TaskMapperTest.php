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

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

use Modules\Tasks\Models\Task;
use Modules\Tasks\Models\TaskElement;
use Modules\Tasks\Models\TaskMapper;
use Modules\Tasks\Models\TaskStatus;
use Modules\Tasks\Models\TaskPriority;
use Modules\Tasks\Models\TaskType;
use Modules\Media\Models\Media;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\StringUtils;
use phpOMS\Utils\RnG\Text;

class TaskMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $task = new Task();

        $task->setCreatedBy(1);
        $task->getSchedule()->setCreatedBy(1);
        $task->setCreatedAt(new \DateTime('2000-05-05'));
        $task->setStart(new \DateTime('2005-05-05'));
        $task->setTitle('Task Test');
        $task->setStatus(TaskStatus::DONE);
        $task->setClosable(false);
        $task->setPriority(TaskPriority::HIGH);
        $task->setDescription('Description');
        $task->setDone(new \DateTime('2000-05-06'));
        $task->setDue(new \DateTime('2000-05-05'));

        $taskElement1 = new TaskElement();
        $taskElement1->setDescription('Desc1');
        $taskElement1->setCreatedBy(1);
        $task->addElement($taskElement1);

        $media = new Media();
        $media->setCreatedAt($data = new \DateTime('now'));
        $media->setCreatedBy(1);
        $media->setDescription('desc');
        $media->setPath('some/path');
        $media->setSize(11);
        $media->setExtension('png');
        $media->setName('Task Element Media');
        $taskElement1->addMedia($media);

        $taskElement2 = new TaskElement();
        $taskElement2->setDescription('Desc2');
        $taskElement2->setCreatedBy(1);
        $task->addElement($taskElement2);

        $media = new Media();
        $media->setCreatedAt($data = new \DateTime('now'));
        $media->setCreatedBy(1);
        $media->setDescription('desc');
        $media->setPath('some/path');
        $media->setSize(11);
        $media->setExtension('png');
        $media->setName('Task Media');
        $task->addMedia($media);

        $id = TaskMapper::create($task);
        self::assertGreaterThan(0, $task->getId());
        self::assertEquals($id, $task->getId());

        $taskR = TaskMapper::get($task->getId());
        self::assertEquals($task->getCreatedAt()->format('Y-m-d'), $taskR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($task->getStart()->format('Y-m-d'), $taskR->getStart()->format('Y-m-d'));
        self::assertEquals($task->getCreatedBy(), $taskR->getCreatedBy()->getId());
        self::assertEquals($task->getDescription(), $taskR->getDescription());
        self::assertEquals($task->getTitle(), $taskR->getTitle());
        self::assertEquals($task->getStatus(), $taskR->getStatus());
        self::assertEquals($task->isClosable(), $taskR->isClosable());
        self::assertEquals($task->getType(), $taskR->getType());
        self::assertEquals($task->getDone()->format('Y-m-d'), $taskR->getDone()->format('Y-m-d'));
        self::assertEquals($task->getDue()->format('Y-m-d'), $taskR->getDue()->format('Y-m-d'));

        $expected = $task->getMedia();
        $actual = $taskR->getMedia();
        self::assertEquals(end($expected)->getName(), end($actual)->getName());

        $expected = $task->getTaskElements();
        $actual   = $taskR->getTaskElements();

        $expectedMedia = reset($expected)->getMedia();
        $actualMedia = reset($actual)->getMedia();

        self::assertEquals(end($expected)->getDescription(), end($actual)->getDescription());
        self::assertEquals(end($expectedMedia)->getName(), end($actualMedia)->getName());
    }

    public function testNewest()
    {
        $newest = TaskMapper::getNewest(1);

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
            $task = new Task();

            $task->setCreatedBy(1);
            $task->getSchedule()->setCreatedBy(1);
            $task->setCreatedAt(new \DateTime('2000-05-05'));
            $task->setStart(new \DateTime('2005-05-05'));
            $task->setTitle($text->generateText(mt_rand(1, 5)));
            $task->setStatus($status);
            $task->setDescription($text->generateText(mt_rand(10, 30)));
            $task->setDone(new \DateTime('2000-05-06'));
            $task->setDue(new \DateTime('2000-05-05'));

            $taskElement1 = new TaskElement();
            $taskElement1->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement1->setCreatedBy(1);
            $task->addElement($taskElement1);

            $taskElement2 = new TaskElement();
            $taskElement2->setDescription('Desc2');
            $taskElement2->setCreatedBy(1);
            $task->addElement($taskElement2);

            $id = TaskMapper::create($task);
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
            $task = new Task();

            $task->setCreatedBy(1);
            $task->getSchedule()->setCreatedBy(1);
            $task->setCreatedAt(new \DateTime('2000-05-05'));
            $task->setTitle($text->generateText(mt_rand(1, 5)));
            $task->setStatus($status);
            $task->setClosable($status);
            $task->setDescription($text->generateText(mt_rand(10, 30)));
            $task->setDone(new \DateTime('2000-05-06'));
            $task->setDue(new \DateTime('2000-05-05'));

            $taskElement1 = new TaskElement();
            $taskElement1->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement1->setCreatedBy(2);
            $task->addElement($taskElement1);

            $taskElement2 = new TaskElement();
            $taskElement2->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement2->setCreatedBy(1);
            $task->addElement($taskElement2);

            $id = TaskMapper::create($task);
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
            $task = new Task();

            $task->setCreatedBy(2);
            $task->getSchedule()->setCreatedBy(2);
            $task->setCreatedAt(new \DateTime('2000-05-05'));
            $task->setTitle($text->generateText(mt_rand(1, 5)));
            $task->setStatus($status);
            $task->setClosable(true);
            $task->setDescription($text->generateText(mt_rand(10, 30)));
            $task->setDone(new \DateTime('2000-05-06'));
            $task->setDue(new \DateTime('2000-05-05'));

            $taskElement1 = new TaskElement();
            $taskElement1->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement1->setCreatedBy(1);
            $task->addElement($taskElement1);

            $taskElement2 = new TaskElement();
            $taskElement2->setDescription($text->generateText(mt_rand(3, 20)));
            $taskElement2->setCreatedBy(2);
            $task->addElement($taskElement2);

            $id = TaskMapper::create($task);
        }
    }
}
