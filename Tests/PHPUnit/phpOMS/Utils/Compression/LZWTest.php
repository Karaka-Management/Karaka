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

namespace Tests\PHPUnit\phpOMS\Utils\Compression;

use phpOMS\Utils\Compression\LZW;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

class LZWTest extends \PHPUnit\Framework\TestCase
{
    public function testLZW()
    {
        $expected = 'This is a test';
        $compression = new LZW();
        self::assertEquals($expected, $compression->decompress($compression->compress($expected)));
    }
}
