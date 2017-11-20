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

use phpOMS\System\File\Ftp\FtpStorage;
use phpOMS\System\File\ContentPutMode;
use phpOMS\System\File\PathException;

class FtpStorageTest extends \PHPUnit\Framework\TestCase
{
    const TEST = false;

    public function testFile()
    {
        if (!self::TEST) {
            return;
        }

        $testFile = __DIR__ . '/test.txt';
        self::assertFalse(FtpStorage::put($testFile, 'test', ContentPutMode::REPLACE));
        self::assertFalse(FtpStorage::exists($testFile));
        self::assertTrue(FtpStorage::put($testFile, 'test', ContentPutMode::CREATE));
        self::assertTrue(FtpStorage::exists($testFile));

        self::assertFalse(FtpStorage::put($testFile, 'test', ContentPutMode::CREATE));
        self::assertTrue(FtpStorage::put($testFile, 'test2', ContentPutMode::REPLACE));

        self::assertEquals('test2', FtpStorage::get($testFile));
        self::assertTrue(FtpStorage::set($testFile, 'test3'));
        self::assertTrue(FtpStorage::append($testFile, 'test4'));
        self::assertEquals('test3test4', FtpStorage::get($testFile));
        self::assertTrue(FtpStorage::prepend($testFile, 'test5'));
        self::assertEquals('test5test3test4', FtpStorage::get($testFile));

        self::assertEquals(str_replace('\\', '/', realpath(dirname($testFile) . '/../')), FtpStorage::parent($testFile));
        self::assertEquals('txt', FtpStorage::extension($testFile));
        self::assertEquals('test', FtpStorage::name($testFile));
        self::assertEquals('test.txt', FtpStorage::basename($testFile));
        self::assertEquals(basename(realpath(__DIR__)), FtpStorage::dirname($testFile));
        self::assertEquals(realpath(__DIR__), FtpStorage::dirpath($testFile));
        self::assertEquals(1, FtpStorage::count($testFile));

        $now = new \DateTime('now');
        self::assertEquals($now->format('Y-m-d'), FtpStorage::created($testFile)->format('Y-m-d'));
        self::assertEquals($now->format('Y-m-d'), FtpStorage::changed($testFile)->format('Y-m-d'));

        self::assertGreaterThan(0, FtpStorage::size($testFile));
        self::assertGreaterThan(0, FtpStorage::permission($testFile));

        $newPath = __DIR__ . '/sub/path/testing.txt';
        self::assertTrue(FtpStorage::copy($testFile, $newPath));
        self::assertTrue(FtpStorage::exists($newPath));
        self::assertFalse(FtpStorage::copy($testFile, $newPath));
        self::assertTrue(FtpStorage::copy($testFile, $newPath, true));
        self::assertEquals('test5test3test4', FtpStorage::get($newPath));

        $newPath2 = __DIR__ . '/sub/path/testing2.txt';
        self::assertTrue(FtpStorage::move($testFile, $newPath2));
        self::assertTrue(FtpStorage::exists($newPath2));
        self::assertFalse(FtpStorage::exists($testFile));
        self::assertEquals('test5test3test4', FtpStorage::get($newPath2));

        self::assertTrue(FtpStorage::delete($newPath2));
        self::assertFalse(FtpStorage::exists($newPath2));
        self::assertFalse(FtpStorage::delete($newPath2));

        unlink($newPath);
        rmdir(__DIR__ . '/sub/path/');
        rmdir(__DIR__ . '/sub/');

        self::assertTrue(FtpStorage::create($testFile));
        self::assertFalse(FtpStorage::create($testFile));
        self::assertEquals('', FtpStorage::get($testFile));

        unlink($testFile);
    }

    public function testDirectory()
    {
        if (!self::TEST) {
            return;
        }

        $dirPath = __DIR__ . '/test';
        self::assertTrue(FtpStorage::create($dirPath));
        self::assertTrue(FtpStorage::exists($dirPath));
        self::assertFalse(FtpStorage::create($dirPath));
        self::assertTrue(FtpStorage::create(__DIR__ . '/test/sub/path'));
        self::assertTrue(FtpStorage::exists(__DIR__ . '/test/sub/path'));

        self::assertEquals('test', FtpStorage::name($dirPath));
        self::assertEquals('test', FtpStorage::basename($dirPath));
        self::assertEquals('test', FtpStorage::dirname($dirPath));
        self::assertEquals(str_replace('\\', '/', realpath($dirPath . '/../')), FtpStorage::parent($dirPath));
        self::assertEquals($dirPath, FtpStorage::dirpath($dirPath));

        $now = new \DateTime('now');
        self::assertEquals($now->format('Y-m-d'), FtpStorage::created($dirPath)->format('Y-m-d'));
        self::assertEquals($now->format('Y-m-d'), FtpStorage::changed($dirPath)->format('Y-m-d'));

        self::assertTrue(FtpStorage::delete($dirPath));
        self::assertFalse(FtpStorage::exists($dirPath));

        $dirTestPath = __DIR__ . '/dirtest';
        self::assertGreaterThan(0, FtpStorage::size($dirTestPath));
        self::assertGreaterThan(FtpStorage::size($dirTestPath, false), FtpStorage::size($dirTestPath));
        self::assertGreaterThan(0, FtpStorage::permission($dirTestPath));
    }

    public function testDirectoryMove()
    {
        if (!self::TEST) {
            return;
        }

        $dirTestPath = __DIR__ . '/dirtest';
        self::assertTrue(FtpStorage::copy($dirTestPath, __DIR__ . '/newdirtest'));
        self::assertTrue(file_exists(__DIR__ . '/newdirtest/sub/path/test3.txt'));

        self::assertTrue(FtpStorage::delete($dirTestPath));
        self::assertFalse(FtpStorage::exists($dirTestPath));

        self::assertTrue(FtpStorage::move(__DIR__ . '/newdirtest', $dirTestPath));
        self::assertTrue(file_exists($dirTestPath . '/sub/path/test3.txt'));

        self::assertEquals(4, FtpStorage::count($dirTestPath));
        self::assertEquals(1, FtpStorage::count($dirTestPath, false));

        self::assertEquals(6, count(FtpStorage::list($dirTestPath)));
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidPutPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        FtpStorage::put(__DIR__, 'Test');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidGetPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        FtpStorage::get(__DIR__);
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidListPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        FtpStorage::list(__DIR__ . '/FtpStorageTest.php');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidSetPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        FtpStorage::set(__DIR__, 'Test');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidAppendPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        FtpStorage::append(__DIR__, 'Test');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidPrependPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        FtpStorage::prepend(__DIR__, 'Test');
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidExtensionPath()
    {
        if (!self::TEST) {
            throw new PathException('');
        }

        FtpStorage::extension(__DIR__);
    }
}

