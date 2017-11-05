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

namespace Tests\PHPUnit\phpOMS\Utils\Converter;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Converter\Ip;

class IpTest extends \PHPUnit\Framework\TestCase
{
    public function testIp()
    {
        self::assertTrue(abs(1527532998.0 - Ip::ip2Float('91.12.77.198')) < 1);
    }
}
