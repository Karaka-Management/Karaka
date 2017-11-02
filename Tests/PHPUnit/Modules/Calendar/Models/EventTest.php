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

namespace Tests\PHPUnit\Modules\Calendar\Models;

use Modules\Calendar\Models\Event;
use phpOMS\Account\Account;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class EventTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $event = new Event();

        self::assertEquals(0, $event->getId());
        self::assertEquals(0, $event->getCreatedBy());
        self::assertEquals('', $event->getName());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $event->getCreatedAt()->format('Y-m-d'));
        self::assertEquals('', $event->getDescription());
        self::assertEquals([], $event->getPeople());
        self::assertInstanceOf('\phpOMS\Account\NullAccount', $event->getPerson(1));
        self::assertInstanceOf('\phpOMS\Stdlib\Base\Location', $event->getLocation());
    }

    public function testSetGet()
    {
        $event = new Event();

        $event->setCreatedBy(1);
        self::assertEquals(1, $event->getCreatedBy());

        $event->setName('Name');
        self::assertEquals('Name', $event->getName());

        $event->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $event->getCreatedAt()->format('Y-m-d'));

        $event->setDescription('Description');
        self::assertEquals('Description', $event->getDescription());

        $id = [];
        $id[] = $event->addPerson(new Account());
        $id[] = $event->addPerson(new Account());
        $success = $event->removePerson(99);

        self::assertFalse($success);

        $success = $event->removePerson($id[1]);
        self::assertTrue($success);

        self::assertEquals(0, $event->getPeople()[0]->getId());
        self::assertEquals(0, $event->getPerson(0)->getId());
    }
}
