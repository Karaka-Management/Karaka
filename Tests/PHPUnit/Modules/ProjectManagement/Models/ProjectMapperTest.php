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

namespace Tests\PHPUnit\Modules\ProjectManagement\Models;

use Modules\ProjectManagement\Models\Project;
use Modules\ProjectManagement\Models\ProgressType;
use Modules\ProjectManagement\Models\ProgressStatus;
use Modules\ProjectManagement\Models\ProjectMapper;
use Modules\Tasks\Models\Task;
use Modules\Media\Models\Media;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Localization\Money;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ProjectMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $project = new Project();

        $project->setName('Projectname');
        $project->setDescription('Description');
        $project->setCreatedAt(new \DateTime('2000-05-05'));
        $project->setCreatedBy(1);
        $project->setStart(new \DateTime('2000-05-05'));
        $project->setEnd(new \DateTime('2005-05-05'));

        $money = new Money();
        $money->setString('1.23');

        $project->setCosts($money);
        $project->setBudget($money);
        $project->setEarnings($money);

        $task = new Task();
        $task->setTitle('ProjectTask 1');
        $task->setCreatedBy(1);

        $task2 = new Task();
        $task2->setTitle('ProjectTask 2');
        $task2->setCreatedBy(1);

        $project->addTask($task);
        $project->addTask($task2);

        $project->setProgress(10);
        $project->setProgressType(ProgressType::TASKS);

        $media = new Media();
        $media->setCreatedAt($data = new \DateTime('now'));
        $media->setCreatedBy(1);
        $media->setDescription('desc');
        $media->setPath('some/path');
        $media->setSize(11);
        $media->setExtension('png');
        $media->setName('Project Media');
        $project->addMedia($media);

        $id = ProjectMapper::create($project);
        self::assertGreaterThan(0, $project->getId());
        self::assertEquals($id, $project->getId());

        $projectR = ProjectMapper::get($project->getId());

        self::assertEquals($project->getName(), $projectR->getName());
        self::assertEquals($project->getDescription(), $projectR->getDescription());
        self::assertEquals($project->countTasks(), $projectR->countTasks());
        self::assertEquals($project->getCosts()->getAmount(), $projectR->getCosts()->getAmount());
        self::assertEquals($project->getBudget()->getAmount(), $projectR->getBudget()->getAmount());
        self::assertEquals($project->getEarnings()->getAmount(), $projectR->getEarnings()->getAmount());
        self::assertEquals($project->getCreatedAt()->format('Y-m-d'), $projectR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($project->getStart()->format('Y-m-d'), $projectR->getStart()->format('Y-m-d'));
        self::assertEquals($project->getEnd()->format('Y-m-d'), $projectR->getEnd()->format('Y-m-d'));
        self::assertEquals($project->getProgress(), $projectR->getProgress());
        self::assertEquals($project->getProgressType(), $projectR->getProgressType());

        $expected = $project->getMedia();
        $actual = $projectR->getMedia();

        self::assertEquals(end($expected)->getName(), end($actual)->getName());        
    }

    public function testNewest()
    {
        $newest = ProjectMapper::getNewest(1);

        self::assertEquals(1, count($newest));
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 100; $i++) {
            $text = new Text();

            $project = new Project();

            $project->setName($text->generateText(mt_rand(3, 7)));
            $project->setDescription($text->generateText(mt_rand(20, 100)));
            $project->setCreatedAt(new \DateTime('2000-05-05'));
            $project->setCreatedBy(1);
            $project->setStart(new \DateTime('2000-05-05'));
            $project->setEnd(new \DateTime('2005-05-05'));
            $project->setProgress(mt_rand(0, 100));
            $project->setProgressType(mt_rand(0, 4));

            $money = new Money();
            $money->setString('1.23');

            $project->setCosts($money);
            $project->setBudget($money);
            $project->setEarnings($money);

            $id = ProjectMapper::create($project);
        }
    }
}
