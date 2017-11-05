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

use phpOMS\System\File\Local\LocalStorage;
use phpOMS\System\File\ContentPutMode;
use phpOMS\System\File\PathException;

class LocalStorageTest extends \PHPUnit\Framework\TestCase
{
    public function testFile()
    {
        $testFile = __DIR__ . '/test.txt';
        self::assertFalse(LocalStorage::put($testFile, 'test', ContentPutMode::REPLACE));
        self::assertFalse(LocalStorage::exists($testFile));
        self::assertTrue(LocalStorage::put($testFile, 'test', ContentPutMode::CREATE));
        self::assertTrue(LocalStorage::exists($testFile));

        self::assertFalse(LocalStorage::put($testFile, 'test', ContentPutMode::CREATE));
        self::assertTrue(LocalStorage::put($testFile, 'test2', ContentPutMode::REPLACE));
        
        self::assertEquals('test2', LocalStorage::get($testFile));
        self::assertTrue(LocalStorage::set($testFile, 'test3'));
        self::assertTrue(LocalStorage::append($testFile, 'test4'));
        self::assertEquals('test3test4', LocalStorage::get($testFile));
        self::assertTrue(LocalStorage::prepend($testFile, 'test5'));
        self::assertEquals('test5test3test4', LocalStorage::get($testFile));

        self::assertEquals(str_replace('\\', '/', realpath(dirname($testFile) . '/../')), LocalStorage::parent($testFile));
        self::assertEquals('txt', LocalStorage::extension($testFile));
        self::assertEquals('test', LocalStorage::name($testFile));
        self::assertEquals('test.txt', LocalStorage::basename($testFile));
        self::assertEquals(basename(realpath(__DIR__)), LocalStorage::dirname($testFile));
        self::assertEquals(realpath(__DIR__), LocalStorage::dirpath($testFile));
        self::assertEquals(1, LocalStorage::count($testFile));

        $now = new \DateTime('now');
        self::assertEquals($now->format('Y-m-d'), LocalStorage::created($testFile)->format('Y-m-d'));
        self::assertEquals($now->format('Y-m-d'), LocalStorage::changed($testFile)->format('Y-m-d'));

        self::assertGreaterThan(0, LocalStorage::size($testFile));
        self::assertGreaterThan(0, LocalStorage::permission($testFile));

        $newPath = __DIR__ . '/sub/path/testing.txt';
        self::assertTrue(LocalStorage::copy($testFile, $newPath));
        self::assertTrue(LocalStorage::exists($newPath));
        self::assertFalse(LocalStorage::copy($testFile, $newPath));
        self::assertTrue(LocalStorage::copy($testFile, $newPath, true));
        self::assertEquals('test5test3test4', LocalStorage::get($newPath));

        $newPath2 = __DIR__ . '/sub/path/testing2.txt';
        self::assertTrue(LocalStorage::move($testFile, $newPath2));
        self::assertTrue(LocalStorage::exists($newPath2));
        self::assertFalse(LocalStorage::exists($testFile));
        self::assertEquals('test5test3test4', LocalStorage::get($newPath2));

        self::assertTrue(LocalStorage::delete($newPath2));
        self::assertFalse(LocalStorage::exists($newPath2));
        self::assertFalse(LocalStorage::delete($newPath2));

        unlink($newPath);
        rmdir(__DIR__ . '/sub/path/');
        rmdir(__DIR__ . '/sub/');

        self::assertTrue(LocalStorage::create($testFile));
        self::assertFalse(LocalStorage::create($testFile));
        self::assertEquals('', LocalStorage::get($testFile));

        unlink($testFile);
    }

    public function testDirectory()
    {
        $dirPath = __DIR__ . '/test';
        self::assertTrue(LocalStorage::create($dirPath));
        self::assertTrue(LocalStorage::exists($dirPath));
        self::assertFalse(LocalStorage::create($dirPath));
        self::assertTrue(LocalStorage::create(__DIR__ . '/test/sub/path'));
        self::assertTrue(LocalStorage::exists(__DIR__ . '/test/sub/path'));

        self::assertEquals('test', LocalStorage::name($dirPath));
        self::assertEquals('test', LocalStorage::basename($dirPath));
        self::assertEquals('test', LocalStorage::dirname($dirPath));
        self::assertEquals(str_replace('\\', '/', realpath($dirPath . '/../')), LocalStorage::parent($dirPath));
        self::assertEquals($dirPath, LocalStorage::dirpath($dirPath));

        $now = new \DateTime('now');
        self::assertEquals($now->format('Y-m-d'), LocalStorage::created($dirPath)->format('Y-m-d'));
        self::assertEquals($now->format('Y-m-d'), LocalStorage::changed($dirPath)->format('Y-m-d'));

        self::assertTrue(LocalStorage::delete($dirPath));
        self::assertFalse(LocalStorage::exists($dirPath));

        $dirTestPath = __DIR__ . '/dirtest';
        self::assertGreaterThan(0, LocalStorage::size($dirTestPath));
        self::assertGreaterThan(LocalStorage::size($dirTestPath, false), LocalStorage::size($dirTestPath));
        self::assertGreaterThan(0, LocalStorage::permission($dirTestPath));
    }

    public function testDirectoryMove()
    {
        $dirTestPath = __DIR__ . '/dirtest';
        self::assertTrue(LocalStorage::copy($dirTestPath, __DIR__ . '/newdirtest'));
        self::assertTrue(file_exists(__DIR__ . '/newdirtest/sub/path/test3.txt'));
        
        self::assertTrue(LocalStorage::delete($dirTestPath));
        self::assertFalse(LocalStorage::exists($dirTestPath));
        
        self::assertTrue(LocalStorage::move(__DIR__ . '/newdirtest', $dirTestPath));
        self::assertTrue(file_exists($dirTestPath . '/sub/path/test3.txt'));
        
        self::assertEquals(4, LocalStorage::count($dirTestPath));
        self::assertEquals(1, LocalStorage::count($dirTestPath, false));

        self::assertEquals(6, count(LocalStorage::list($dirTestPath)));
    }

    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidPutPath()
    {
        LocalStorage::put(__DIR__, 'Test');
    }
    
    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidGetPath()
    {
        LocalStorage::get(__DIR__);
    }
    
    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidListPath()
    {
        LocalStorage::list(__DIR__ . '/LocalStorageTest.php');
    }
    
    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidSetPath()
    {
        LocalStorage::set(__DIR__, 'Test');
    }
    
    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidAppendPath()
    {
        LocalStorage::append(__DIR__, 'Test');
    }
    
    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidPrependPath()
    {
        LocalStorage::prepend(__DIR__, 'Test');
    }
    
    /**
     * @expectedException \phpOMS\System\File\PathException
     */
    public function testInvalidExtensionPath()
    {
        LocalStorage::extension(__DIR__);
    }
}

