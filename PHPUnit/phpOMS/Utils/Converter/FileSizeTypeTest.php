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

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Converter\FileSizeType;

class FileSizeTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(10, count(FileSizeType::getConstants()));
        self::assertEquals('TB', FileSizeType::TERRABYTE);
        self::assertEquals('GB', FileSizeType::GIGABYTE);
        self::assertEquals('MB', FileSizeType::MEGABYTE);
        self::assertEquals('KB', FileSizeType::KILOBYTE);
        self::assertEquals('B', FileSizeType::BYTE);
        self::assertEquals('tbit', FileSizeType::TERRABIT);
        self::assertEquals('gbit', FileSizeType::GIGABIT);
        self::assertEquals('mbit', FileSizeType::MEGABIT);
        self::assertEquals('kbit', FileSizeType::KILOBIT);
        self::assertEquals('bit', FileSizeType::BIT);
    }
}
