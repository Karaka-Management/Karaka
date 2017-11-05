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

namespace Tests\PHPUnit\phpOMS\Utils;

use phpOMS\Stdlib\Map\MultiMap;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

class MultiMapTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $map = new MultiMap();
        self::assertInstanceOf('\phpOMS\Stdlib\Map\MultiMap', $map);

        /* Testing members */
        self::assertObjectHasAttribute('values', $map);
        self::assertObjectHasAttribute('keys', $map);
    }

    public function testDefault()
    {
        $map = new MultiMap();

        /* Testing default values */
        self::assertNull($map->get('someKey'));
        self::assertEquals(0, $map->count());

        self::assertEmpty($map->keys());
        self::assertEmpty($map->values());
        self::assertEmpty($map->getSiblings('someKey'));
        self::assertFalse($map->removeKey('someKey'));
        self::assertFalse($map->remap('old', 'new'));
        self::assertFalse($map->remove('someKey'));
    }

    public function testBasicAdd()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val1');
        self::assertEquals(1, $map->count());
        self::assertTrue($inserted);
        self::assertEquals('val1', $map->get('a'));
        self::assertEquals('val1', $map->get('b'));
    }

    public function testOverwrite()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val1');
        $inserted = $map->add(['a', 'b'], 'val2');
        self::assertEquals(1, $map->count());
        self::assertTrue($inserted);
        self::assertEquals('val2', $map->get('a'));
        self::assertEquals('val2', $map->get('b'));
    }

    public function testOverwritePartialFalse()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val2');
        $inserted = $map->add(['a', 'c'], 'val3', false);
        self::assertEquals(2, $map->count());
        self::assertTrue($inserted);
        self::assertEquals('val2', $map->get('a'));
        self::assertEquals('val2', $map->get('b'));
        self::assertEquals('val3', $map->get('c'));
    }

    public function testOverwriteFalseFalse()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val2');
        $inserted = $map->add(['a', 'c'], 'val3', false);
        $inserted = $map->add(['a', 'c'], 'val4', false);
        self::assertEquals(2, $map->count());
        self::assertFalse($inserted);
        self::assertEquals('val2', $map->get('a'));
        self::assertEquals('val2', $map->get('b'));
        self::assertEquals('val3', $map->get('c'));
    }

    public function testSet()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val2');
        $inserted = $map->add(['a', 'c'], 'val3', false);

        $set = $map->set('d', 'val4');
        self::assertFalse($set);
        self::assertEquals(2, $map->count());

        $set = $map->set('b', 'val4');
        self::assertEquals(2, $map->count());
        self::assertTrue($set);
        self::assertEquals('val4', $map->get('b'));
        self::assertEquals('val4', $map->get('a'));
        self::assertEquals('val3', $map->get('c'));
    }

    public function testRemap()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val2');
        $inserted = $map->add(['a', 'c'], 'val3', false);
        $set = $map->set('d', 'val4');
        $set = $map->set('b', 'val4');

        $remap = $map->remap('b', 'd');
        self::assertEquals(2, $map->count());
        self::assertFalse($remap);

        $remap = $map->remap('d', 'b');
        self::assertEquals(2, $map->count());
        self::assertFalse($remap);

        $remap = $map->remap('d', 'e');
        self::assertEquals(2, $map->count());
        self::assertFalse($remap);

        $remap = $map->remap('b', 'c');
        self::assertEquals(2, $map->count());
        self::assertTrue($remap);
        self::assertEquals('val3', $map->get('b'));
        self::assertEquals('val4', $map->get('a'));
        self::assertEquals('val3', $map->get('c'));
    }

    public function testMapInfo()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val2');
        $inserted = $map->add(['a', 'c'], 'val3', false);
        $set = $map->set('d', 'val4');
        $set = $map->set('b', 'val4');

        self::assertEquals(3, count($map->keys()));
        self::assertEquals(2, count($map->values()));

        self::assertTrue(is_array($map->keys()));
        self::assertTrue(is_array($map->values()));
    }

    public function testSiblings()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val2');
        $set = $map->set('d', 'val4');
        $set = $map->set('b', 'val4');

        $siblings = $map->getSiblings('d');
        self::assertEmpty($siblings);
        self::assertEquals(0, count($siblings));

        $siblings = $map->getSiblings('b');
        self::assertEquals(1, count($siblings));
        self::assertEquals(['a'], $siblings);
    }

    public function testRemove()
    {
        $map = new MultiMap();

        $inserted = $map->add(['a', 'b'], 'val2');
        $inserted = $map->add(['a', 'c'], 'val3', false);
        $set = $map->set('d', 'val4');
        $set = $map->set('b', 'val4');

        $removed = $map->remove('d');
        self::assertFalse($removed);

        $removed = $map->remove('d');
        self::assertFalse($removed);

        $removed = $map->remove('c');
        self::assertTrue($removed);
        self::assertEquals(2, count($map->keys()));
        self::assertEquals(1, count($map->values()));

        $removed = $map->removeKey('d');
        self::assertFalse($removed);

        $removed = $map->removeKey('a');
        self::assertTrue($removed);
        self::assertEquals(1, count($map->keys()));
        self::assertEquals(1, count($map->values()));
    }
}
