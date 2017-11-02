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

namespace Tests\PHPUnit\phpOMS\System\File;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\System\File\FileUtils;
use phpOMS\System\File\ExtensionType;

class FileUtilsTest extends \PHPUnit\Framework\TestCase
{
    public function testExtension()
    {
        self::assertEquals(ExtensionType::UNKNOWN, FileUtils::getExtensionType('test'));
        self::assertEquals(ExtensionType::CODE, FileUtils::getExtensionType('php'));
        self::assertEquals(ExtensionType::TEXT, FileUtils::getExtensionType('md'));
        self::assertEquals(ExtensionType::PRESENTATION, FileUtils::getExtensionType('pptx'));
        self::assertEquals(ExtensionType::PDF, FileUtils::getExtensionType('pdf'));
        self::assertEquals(ExtensionType::ARCHIVE, FileUtils::getExtensionType('rar'));
        self::assertEquals(ExtensionType::AUDIO, FileUtils::getExtensionType('mp3'));
        self::assertEquals(ExtensionType::VIDEO, FileUtils::getExtensionType('mp4'));
        self::assertEquals(ExtensionType::SPREADSHEET, FileUtils::getExtensionType('xls'));
        self::assertEquals(ExtensionType::IMAGE, FileUtils::getExtensionType('png'));
    }

    public function testAbsolute()
    {
        self::assertEquals('/test/ative', FileUtils::absolute('/test/path/for/../rel/../../ative'));
    }
}
