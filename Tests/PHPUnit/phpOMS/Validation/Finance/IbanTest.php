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

namespace Tests\PHPUnit\phpOMS\Validation\Finance;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Validation\Finance\Iban;

class IbanTest extends \PHPUnit\Framework\TestCase
{
    public function testValid()
    {
        self::assertTrue(Iban::isValid('DE22 6008 0000 0960 0280 00'));
        self::assertFalse(Iban::isValid('DE22 6008 0000 0960 0280 0'));
        self::assertFalse(Iban::isValid('QQ22 6008 0000 0960 0280 00'));
        self::assertFalse(Iban::isValid('MU22 6118 1111 1961 1281 1281 0111 23'));
        self::assertFalse(Iban::isValid('DZ22 6118 1111 1961 1281 2211'));
    }
}
