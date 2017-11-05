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

namespace Tests\PHPUnit\phpOMS\System\File\Local;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\System\File\Local\Directory;
use phpOMS\System\File\PathException;

class DirectoryTest extends \PHPUnit\Framework\TestCase
{
    public function testStatic()
    {
        $dirPath = __DIR__ . '/test';
        self::assertTrue(Directory::create($dirPath));
        self::assertTrue(Directory::exists($dirPath));
        self::assertFalse(Directory::create($dirPath));
        self::assertFalse(Directory::create(__DIR__ . '/test/sub/path'));
        self::assertTrue(Directory::create(__DIR__ . '/test/sub/path', 0644, true));
        self::assertTrue(Directory::exists(__DIR__ . '/test/sub/path'));

        self::assertEquals('test', Directory::name($dirPath));
        self::assertEquals('test', Directory::basename($dirPath));
        self::assertEquals('test', Directory::dirname($dirPath));
        self::assertEquals(str_replace('\\', '/', realpath($dirPath . '/../')), Directory::parent($dirPath));
        self::assertEquals($dirPath, Directory::dirpath($dirPath));

        $now = new \DateTime('now');
        self::assertEquals($now->format('Y-m-d'), Directory::created($dirPath)->format('Y-m-d'));
        self::assertEquals($now->format('Y-m-d'), Directory::changed($dirPath)->format('Y-m-d'));

        self::assertTrue(Directory::delete($dirPath));
        self::assertFalse(Directory::exists($dirPath));

        $dirTestPath = __DIR__ . '/dirtest';
        self::assertGreaterThan(0, Directory::size($dirTestPath));
        self::assertGreaterThan(Directory::size($dirTestPath, false), Directory::size($dirTestPath));
        self::assertGreaterThan(0, Directory::permission($dirTestPath));
    }

    public function testStaticMove()
    {
        $dirTestPath = __DIR__ . '/dirtest';
        
        self::assertTrue(Directory::copy($dirTestPath, __DIR__ . '/newdirtest'));
        self::assertTrue(file_exists(__DIR__ . '/newdirtest/sub/path/test3.txt'));
        
        self::assertTrue(Directory::delete($dirTestPath));
        self::assertFalse(Directory::exists($dirTestPath));

        self::assertTrue(Directory::move(__DIR__ . '/newdirtest', $dirTestPath));
        self::assertTrue(file_exists($dirTestPath . '/sub/path/test3.txt'));

        self::assertEquals(4, Directory::count($dirTestPath));
        self::assertEquals(1, Directory::count($dirTestPath, false));

        self::assertEquals(6, count(Directory::list($dirTestPath)));
        self::assertEquals(3, count(Directory::listByExtension($dirTestPath, 'txt')));
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidListPath()
    {
        Directory::list(__DIR__ . '/invalid.txt');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidCopyPath()
    {
        Directory::copy(__DIR__ . '/invalid', __DIR__ . '/invalid2');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidMovePath()
    {
        Directory::move(__DIR__ . '/invalid', __DIR__ . '/invalid2');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidCreatedPath()
    {
        Directory::created(__DIR__ . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidChangedPath()
    {
        Directory::changed(__DIR__ . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidSizePath()
    {
        Directory::size(__DIR__ . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidPermissionPath()
    {
        Directory::permission(__DIR__ . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidOwnerPath()
    {
        Directory::owner(__DIR__ . '/invalid');
    }
}

