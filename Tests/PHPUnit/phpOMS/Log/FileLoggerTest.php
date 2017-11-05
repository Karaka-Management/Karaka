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

namespace Tests\PHPUnit\phpOMS\Log;

use phpOMS\Log\FileLogger;
use phpOMS\Log\LogLevel;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class FileLoggerTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $log = FileLogger::getInstance(__DIR__);
        self::assertObjectHasAttribute('fp', $log);
        self::assertObjectHasAttribute('path', $log);

        if (file_exists(__DIR__ . '/' . date('Y-m-d') . '.log')) {
            unlink(__DIR__ . '/' . date('Y-m-d') . '.log');
        }
    }

    public function testDefault()
    {
        if (file_exists(__DIR__ . '/' . date('Y-m-d') . '.log')) {
            unlink(__DIR__ . '/' . date('Y-m-d') . '.log');
        }

        $log = FileLogger::getInstance(__DIR__);
        self::assertEquals([], $log->countLogs());
        self::assertEquals([], $log->getHighestPerpetrator());
        self::assertEquals([], $log->get());
        self::assertEquals([], $log->getByLine());

        if (file_exists(__DIR__ . '/' . date('Y-m-d') . '.log')) {
            unlink(__DIR__ . '/' . date('Y-m-d') . '.log');
        }
    }

    public function testGetSet()
    {
        if (file_exists(__DIR__ . '/test.log')) {
            unlink(__DIR__ . '/test.log');
        }

        $log = new FileLogger(__DIR__ . '/test.log');

        $log->emergency(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->alert(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->critical(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->error(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->warning(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->notice(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->info(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->debug(FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        $log->log(LogLevel::DEBUG, FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);

        self::assertEquals(1, $log->countLogs()['emergency'] ?? 0);
        self::assertEquals(1, $log->countLogs()['alert'] ?? 0);
        self::assertEquals(1, $log->countLogs()['critical'] ?? 0);
        self::assertEquals(1, $log->countLogs()['error'] ?? 0);
        self::assertEquals(1, $log->countLogs()['warning'] ?? 0);
        self::assertEquals(1, $log->countLogs()['notice'] ?? 0);
        self::assertEquals(1, $log->countLogs()['info'] ?? 0);
        self::assertEquals(2, $log->countLogs()['debug'] ?? 0);

        self::assertEquals(['0.0.0.0' => 9], $log->getHighestPerpetrator());
        self::assertEquals([5, 6, 7, 8, 9], array_keys($log->get(5, 1)));
        self::assertEquals('alert', $log->getByLine(2)['level']);

        ob_start();
        $log->console('test', true);
        $ob = ob_get_clean();
        self::assertEquals(date('[Y-m-d H:i:s] ') . "test\r\n", $ob);

        unlink(__DIR__ . '/test.log');

        if (file_exists(__DIR__ . '/' . date('Y-m-d') . '.log')) {
            unlink(__DIR__ . '/' . date('Y-m-d') . '.log');
        }
    }

    /**
     * @expectedException phpOMS\Stdlib\Base\Exception\InvalidEnumValue
     */
    public function testLogException()
    {
        $log = new FileLogger(__DIR__ . '/test.log');
        $log->log('testException', FileLogger::MSG_FULL, [
            'message' => 'msg',
            'line'    => 11,
            'file'    => FileLoggerTest::class,
        ]);
    }

    public function testTiming()
    {
        self::assertTrue(FileLogger::startTimeLog('test'));
        self::assertFalse(FileLogger::startTimeLog('test'));
        self::assertGreaterThan(0, FileLogger::endTimeLog('test'));
    }

    public static function tearDownAfterClass()
    {
        if (file_exists(__DIR__ . '/test.log')) {
            unlink(__DIR__ . '/test.log');
        }

        if (file_exists(__DIR__ . '/' . date('Y-m-d') . '.log')) {
            unlink(__DIR__ . '/' . date('Y-m-d') . '.log');
        }
    }
    
}
