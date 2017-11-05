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

namespace Tests\PHPUnit\phpOMS\DataStorage\Cache;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Cache\FileCache;

class CachePoolTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $pool = new CachePool();

        self::assertFalse($pool->remove('core'));
        self::assertEquals(null, $pool->get());
    }

    public function testGetSet()
    {
        $pool = new CachePool();

        self::assertTrue($pool->add('test', new FileCache(__DIR__)));
        self::assertFalse($pool->add('test', new FileCache(__DIR__)));
        self::assertInstanceOf('\phpOMS\DataStorage\Cache\CacheInterface', $pool->get('test'));
        self::assertTrue($pool->create('abc', ['type' => 'file', 'path' => __DIR__]));
        self::assertInstanceOf('\phpOMS\DataStorage\Cache\CacheInterface', $pool->get('abc'));
        self::assertTrue($pool->remove('abc'));
        self::assertEquals(null, $pool->get('abc'));
        self::assertInstanceOf('\phpOMS\DataStorage\Cache\CacheInterface', $pool->get('test'));
        self::assertFalse($pool->remove('abc'));
    }
}
