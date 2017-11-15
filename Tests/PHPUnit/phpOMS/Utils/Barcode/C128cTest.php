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

namespace Tests\PHPUnit\phpOMS\Utils\Barcode;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Barcode\C128c;

class C128cTest extends \PHPUnit\Framework\TestCase
{
    public function testImage()
    {
        $path = __DIR__ . '/c128c.png';
        if(file_exists($path)) {
            unlink($path);
        }

        $img = new C128c('412163', 200, 50);
        $img->saveToPngFile($path);

        self::assertTrue(file_exists($path));
    }
}
