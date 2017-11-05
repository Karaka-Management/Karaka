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

use Modules\Calendar\Models\EventMapper;
use Modules\Calendar\Models\Event;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Text;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class EventMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $calendarEvent1 = new Event();

        $calendarEvent1->setName('Running test');
        $calendarEvent1->setDescription('Desc1');
        $calendarEvent1->setCreatedBy(1);
        $calendarEvent1->getSchedule()->setCreatedBy(1);
        $calendarEvent1->setCalendar(1);

        $id = EventMapper::create($calendarEvent1);
        self::assertGreaterThan(0, $calendarEvent1->getId());
        self::assertEquals($id, $calendarEvent1->getId());

        $eventR = EventMapper::get($calendarEvent1->getId());
        self::assertEquals($calendarEvent1->getCreatedBy(), $eventR->getCreatedBy());
        self::assertEquals($calendarEvent1->getDescription(), $eventR->getDescription());
    }
}
