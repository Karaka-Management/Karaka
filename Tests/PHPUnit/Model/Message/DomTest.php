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

use Model\Message\Dom;
use Model\Message\DomAction;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

class DomTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes()
    {
        $obj = new Dom();
        self::assertInstanceOf('\Model\Message\Dom', $obj);

        /* Testing members */
        self::assertObjectHasAttribute('delay', $obj);
        self::assertObjectHasAttribute('content', $obj);
        self::assertObjectHasAttribute('selector', $obj);
        self::assertObjectHasAttribute('action', $obj);
    }

    public function testDefault()
    {
        $obj = new Dom();

        /* Testing default values */
        self::assertEquals(0, $obj->toArray()['time']);
        self::assertEquals('', $obj->toArray()['selector']);
        self::assertEquals('', $obj->toArray()['content']);
        self::assertEquals(DomAction::MODIFY, $obj->toArray()['action']);
    }

    public function testSetGet()
    {
        $obj = new Dom('message');
        $obj->setDelay(3);
        $obj->setAction(DomAction::SHOW);
        $obj->setContent('msg');
        $obj->setSelector('#sel');

        self::assertEquals([
            'type' => 'dom', 
            'time' => 3, 
            'selector' => '#sel', 
            'action' => DomAction::SHOW,
            'content' => 'msg', 
        ], $obj->toArray());

        self::assertEquals(json_encode([
            'type' => 'dom', 
            'time' => 3, 
            'selector' => '#sel', 
            'action' => DomAction::SHOW,
            'content' => 'msg', 
        ]), $obj->serialize());

        self::assertEquals([
            'type' => 'dom', 
            'time' => 3, 
            'selector' => '#sel', 
            'action' => DomAction::SHOW,
            'content' => 'msg', 
        ], $obj->jsonSerialize());
    }
}