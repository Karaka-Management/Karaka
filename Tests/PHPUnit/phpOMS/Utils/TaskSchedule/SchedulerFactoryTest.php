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

use phpOMS\Utils\TaskSchedule\SchedulerFactory;
use phpOMS\Utils\TaskSchedule\TaskScheduler;
use phpOMS\Utils\TaskSchedule\Cron;

class SchedulerFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testFactory()
    {
        self::assertTrue((SchedulerFactory::create('') instanceof Cron) || (SchedulerFactory::create('') instanceof TaskScheduler));
        
        // todo: make full test here by defining schtask or crontab path
        // todo: create task
        // todo: get task
        // todo: remove task
    }
}
