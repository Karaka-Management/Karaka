<?php declare(strict_types=1);
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    tests
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */

namespace phpOMS\tests\phpOMS\Model\Message;

use phpOMS\Model\Message\Redirect;

/**
 * @internal
 */
class RedirectTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes() : void
    {
        $obj = new Redirect('');
        self::assertInstanceOf('\phpOMS\Model\Message\Redirect', $obj);

        /* Testing members */
        self::assertObjectHasAttribute('uri', $obj);
        self::assertObjectHasAttribute('delay', $obj);
        self::assertObjectHasAttribute('new', $obj);
    }

    public function testDefault() : void
    {
        $obj = new Redirect('');

        /* Testing default values */
        self::assertEmpty($obj->toArray()['uri']);
        self::assertEquals(0, $obj->toArray()['time']);
        self::assertFalse($obj->toArray()['new']);
    }

    public function testSetGet() : void
    {
        $obj = new Redirect('url', true);

        self::assertEquals(['type' => 'redirect', 'time' => 0, 'uri' => 'url', 'new' => true], $obj->toArray());
        self::assertEquals(\json_encode(['type' => 'redirect', 'time' => 0, 'uri' => 'url', 'new' => true]), $obj->serialize());
        self::assertEquals(['type' => 'redirect', 'time' => 0, 'uri' => 'url', 'new' => true], $obj->jsonSerialize());

        $obj->setDelay(6);
        $obj->setUri('test');
        self::assertEquals(['type' => 'redirect', 'time' => 6, 'uri' => 'test', 'new' => true], $obj->toArray());

        $obj2 = new Redirect();
        $obj2->unserialize($obj->serialize());
        self::assertEquals($obj, $obj2);
    }
}
