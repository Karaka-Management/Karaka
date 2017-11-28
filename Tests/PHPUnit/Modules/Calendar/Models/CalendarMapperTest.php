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

namespace Tests\PHPUnit\Modules\Calendar\Models;

use Modules\Calendar\Models\Calendar;
use Modules\Calendar\Models\CalendarMapper;
use Modules\Calendar\Models\Event;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class CalendarMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $calendar = new Calendar();

        $calendar->setName('Title');
        $calendar->setDescription('Description');

        $calendarEvent1 = new Event();
        $calendarEvent1->setName('Running test');
        $calendarEvent1->setDescription('Desc1');
        $calendarEvent1->setCreatedBy(1);
        $calendarEvent1->getSchedule()->setCreatedBy(1);
        $calendar->addEvent($calendarEvent1);

        $calendarEvent2 = new Event();
        $calendarEvent2->setName('Running test2');
        $calendarEvent2->setDescription('Desc2');
        $calendarEvent2->setCreatedBy(1);
        $calendarEvent2->getSchedule()->setCreatedBy(1);
        $calendar->addEvent($calendarEvent2);

        $id = CalendarMapper::create($calendar);
        self::assertGreaterThan(0, $calendar->getId());
        self::assertEquals($id, $calendar->getId());

        $calendarR = CalendarMapper::get($calendar->getId());
        self::assertEquals($calendar->getCreatedAt()->format('Y-m-d'), $calendarR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($calendar->getDescription(), $calendarR->getDescription());
        self::assertEquals($calendar->getName(), $calendarR->getName());

        $expected = $calendar->getEvents();
        $actual   = $calendarR->getEvents();

        self::assertEquals(end($expected)->getDescription(), end($actual)->getDescription());
    }
}
