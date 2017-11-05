<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\Model\Message;

use Model\Message\Notify;
use Model\Message\NotifyType;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

class NotifyTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes()
    {
        $obj = new Notify();
        self::assertInstanceOf('\Model\Message\Notify', $obj);

        /* Testing members */
        self::assertObjectHasAttribute('delay', $obj);
        self::assertObjectHasAttribute('title', $obj);
        self::assertObjectHasAttribute('stay', $obj);
        self::assertObjectHasAttribute('message', $obj);
        self::assertObjectHasAttribute('level', $obj);
    }

    public function testDefault()
    {
        $obj = new Notify();

        /* Testing default values */
        self::assertEquals(0, $obj->toArray()['time']);
        self::assertEquals('', $obj->toArray()['title']);
        self::assertEquals('', $obj->toArray()['msg']);
        self::assertEquals(0, $obj->toArray()['stay']);
        self::assertEquals(NotifyType::INFO, $obj->toArray()['level']);
    }

    public function testSetGet()
    {
        $obj = new Notify('message', NotifyType::WARNING);
        $obj->setDelay(3);
        $obj->setStay(5);
        $obj->setLevel(NotifyType::ERROR);
        $obj->setMessage('msg');
        $obj->setTitle('title');

        self::assertEquals([
            'type' => 'notify', 
            'time' => 3, 
            'stay' => 5, 
            'msg' => 'msg', 
            'title' => 'title', 
            'level' => NotifyType::ERROR
        ], $obj->toArray());

        self::assertEquals(json_encode([
            'type' => 'notify', 
            'time' => 3, 
            'stay' => 5, 
            'msg' => 'msg', 
            'title' => 'title', 
            'level' => NotifyType::ERROR
        ]), $obj->serialize());

        self::assertEquals([
            'type' => 'notify', 
            'time' => 3, 
            'stay' => 5, 
            'msg' => 'msg', 
            'title' => 'title', 
            'level' => NotifyType::ERROR
        ], $obj->jsonSerialize());
    }
}