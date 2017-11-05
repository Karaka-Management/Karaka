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

namespace Tests\PHPUnit\phpOMS\System\File;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\System\File\ExtensionType;

class ExtensionTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(10, count(ExtensionType::getConstants()));
        self::assertEquals(ExtensionType::getConstants(), array_unique(ExtensionType::getConstants()));

        self::assertEquals(1, ExtensionType::UNKNOWN);
        self::assertEquals(2, ExtensionType::CODE);
        self::assertEquals(4, ExtensionType::AUDIO);
        self::assertEquals(8, ExtensionType::VIDEO);
        self::assertEquals(16, ExtensionType::TEXT);
        self::assertEquals(32, ExtensionType::SPREADSHEET);
        self::assertEquals(64, ExtensionType::PDF);
        self::assertEquals(128, ExtensionType::ARCHIVE);
        self::assertEquals(256, ExtensionType::PRESENTATION);
        self::assertEquals(512, ExtensionType::IMAGE);
    }
}
