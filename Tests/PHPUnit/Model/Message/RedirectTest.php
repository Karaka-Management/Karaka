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

use Model\Message\Redirect;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

class RedirectTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes()
    {
        $obj = new Redirect('');
        self::assertInstanceOf('\Model\Message\Redirect', $obj);

        /* Testing members */
        self::assertObjectHasAttribute('uri', $obj);
        self::assertObjectHasAttribute('delay', $obj);
        self::assertObjectHasAttribute('new', $obj);
    }

    public function testDefault()
    {
        $obj = new Redirect('');

        /* Testing default values */
        self::assertEmpty($obj->toArray()['uri']);
        self::assertEquals(0, $obj->toArray()['time']);
        self::assertEquals(false, $obj->toArray()['new']);
    }

    public function testSetGet()
    {
        $obj = new Redirect('url', true);

        self::assertEquals(['type' => 'redirect', 'time' => 0, 'uri' => 'url', 'new' => true], $obj->toArray());
        self::assertEquals(json_encode(['type' => 'redirect', 'time' => 0, 'uri' => 'url', 'new' => true]), $obj->serialize());
        self::assertEquals(['type' => 'redirect', 'time' => 0, 'uri' => 'url', 'new' => true], $obj->jsonSerialize());

        $obj->setDelay(6);
        $obj->setUri('test');
        self::assertEquals(['type' => 'redirect', 'time' => 6, 'uri' => 'test', 'new' => true], $obj->toArray());
    }
}