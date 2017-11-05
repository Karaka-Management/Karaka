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

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Log\LogLevel;

class LogLevelTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(8, count(LogLevel::getConstants()));
        self::assertEquals('emergency', LogLevel::EMERGENCY);
        self::assertEquals('alert', LogLevel::ALERT);
        self::assertEquals('critical', LogLevel::CRITICAL);
        self::assertEquals('error', LogLevel::ERROR);
        self::assertEquals('warning', LogLevel::WARNING);
        self::assertEquals('notice', LogLevel::NOTICE);
        self::assertEquals('info', LogLevel::INFO);
        self::assertEquals('debug', LogLevel::DEBUG);
    }
}
