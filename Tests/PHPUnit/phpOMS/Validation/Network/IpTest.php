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

namespace Tests\PHPUnit\phpOMS\Validation\Network;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Validation\Network\Ip;

class IpTest extends \PHPUnit\Framework\TestCase
{
    public function testValid()
    {
        self::assertTrue(IP::isValid('192.168.178.1'));
        self::assertTrue(IP::isValid('2001:0db8:85a3:0000:0000:8a2e:0370:7334'));
        self::assertFalse(IP::isValid('192.168.178.257'));
        self::assertFalse(IP::isValid('localhost'));

        self::assertFalse(IP::isValidIpv6('192.168.178.1'));
        self::assertTrue(IP::isValidIpv6('2001:0db8:85a3:0000:0000:8a2e:0370:7334'));

        self::assertTrue(IP::isValidIpv4('192.168.178.1'));
        self::assertFalse(IP::isValidIpv4('2001:0db8:85a3:0000:0000:8a2e:0370:7334'));
    }
}
