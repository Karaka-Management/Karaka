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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\phpOMS\Utils\Converter;

use phpOMS\Utils\Converter\File;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

class FileTest extends \PHPUnit\Framework\TestCase
{
    public function testByteSizeToString()
    {
        self::assertEquals('400b', File::byteSizeToString(400));
        self::assertEquals('5kb', File::byteSizeToString(5000));
        self::assertEquals('7mb', File::byteSizeToString(7000000));
        self::assertEquals('1.5gb', File::byteSizeToString(1500000000));
    }

    public function testKilobyteSizeToString()
    {
        self::assertEquals('500kb', File::kilobyteSizeToString(500));
        self::assertEquals('5mb', File::kilobyteSizeToString(5000));
        self::assertEquals('5.4gb', File::kilobyteSizeToString(5430000));
    }
}
