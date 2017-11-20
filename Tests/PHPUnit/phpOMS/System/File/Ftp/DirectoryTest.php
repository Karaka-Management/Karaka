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

namespace Tests\PHPUnit\phpOMS\System\File\Ftp;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\System\File\Ftp\Directory;
use phpOMS\System\File\PathException;

class DirectoryTest extends \PHPUnit\Framework\TestCase
{
    const TEST = false;
    const BASE = 'ftp://user:password@localhost';

    public function testStatic()
    {
        if (!self::TEST) {
            return;
        }

        $dirPath = self::BASE . '/test';
        self::assertTrue(Directory::create($dirPath));
        self::assertTrue(Directory::exists($dirPath));
        self::assertFalse(Directory::create($dirPath));
        self::assertFalse(Directory::create(self::BASE . '/test/sub/path'));
        self::assertTrue(Directory::create(self::BASE . '/test/sub/path', 0755, true));
        self::assertTrue(Directory::exists(self::BASE . '/test/sub/path'));

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

        $dirTestPath = self::BASE . '/dirtest';
        self::assertGreaterThan(0, Directory::size($dirTestPath));
        self::assertGreaterThan(Directory::size($dirTestPath, false), Directory::size($dirTestPath));
        self::assertGreaterThan(0, Directory::permission($dirTestPath));
    }

    public function testStaticMove()
    {
        if (!self::TEST) {
            return;
        }

        $dirTestPath = self::BASE . '/dirtest';

        self::assertTrue(Directory::copy($dirTestPath, self::BASE . '/newdirtest'));
        self::assertTrue(file_exists(self::BASE . '/newdirtest/sub/path/test3.txt'));

        self::assertTrue(Directory::delete($dirTestPath));
        self::assertFalse(Directory::exists($dirTestPath));

        self::assertTrue(Directory::move(self::BASE . '/newdirtest', $dirTestPath));
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
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::list(self::BASE . '/invalid.txt');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidCopyPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::copy(self::BASE . '/invalid', self::BASE . '/invalid2');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidMovePath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::move(self::BASE . '/invalid', self::BASE . '/invalid2');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidCreatedPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::created(self::BASE . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidChangedPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::changed(self::BASE . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidSizePath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::size(self::BASE . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidPermissionPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::permission(self::BASE . '/invalid');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidOwnerPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        Directory::owner(self::BASE . '/invalid');
    }
}

