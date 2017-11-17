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

namespace Tests\PHPUnit\phpOMS\Utils\TaskSchedule;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\TaskSchedule\TaskAbstract;

class TaskAbstractTest extends \PHPUnit\Framework\TestCase
{
    private $class = null;

    protected function setUp()
    {
        $this->class = new class('') extends TaskAbstract {
            public static function createWith(array $jobData) : TaskAbstract {}
        };
    }

    public function testDefault()
    {
        self::assertEquals('', $this->class->getId());
        self::assertEquals('', $this->class->getCommand());
        self::assertEquals('', $this->class->getRun());
        self::assertEquals('', $this->class->getStatus());
        self::assertInstanceOf('\DateTime', $this->class->getNextRunTime());
        self::assertInstanceOf('\DateTime', $this->class->getLastRuntime());
        self::assertEquals('', $this->class->getComment());
    }

    public function testGetSet()
    {
        $this->class->setCommand('Command');
        self::assertEquals('Command', $this->class->getCommand());

        $this->class->setRun('Run');
        self::assertEquals('Run', $this->class->getRun());

        $this->class->setStatus('Status');
        self::assertEquals('Status', $this->class->getStatus());

        $this->class->setComment('Comment');
        self::assertEquals('Comment', $this->class->getComment());

        $date = new \DateTime('now');
        $this->class->setLastRuntime($date);
        self::assertEquals($date->format('Y-m-d'), $this->class->getLastRuntime()->format('Y-m-d'));

        $this->class->setNextRuntime($date);
        self::assertEquals($date->format('Y-m-d'), $this->class->getNextRuntime()->format('Y-m-d'));
    }
}
