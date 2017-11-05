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

use phpOMS\Validation\Finance\BIC;

class BICTest extends \PHPUnit\Framework\TestCase
{
    public function testBic()
    {
        self::assertTrue(BIC::isValid('ASPKAT2LXXX'));
        self::assertTrue(BIC::isValid('ASPKAT2L'));
        self::assertTrue(BIC::isValid('DSBACNBXSHA'));
        self::assertTrue(BIC::isValid('UNCRIT2B912'));
        self::assertTrue(BIC::isValid('DABADKKK'));
        self::assertTrue(BIC::isValid('RZOOAT2L303'));

        self::assertFalse(BIC::isValid('ASPKAT2LXX'));
        self::assertFalse(BIC::isValid('ASPKAT2LX'));
        self::assertFalse(BIC::isValid('ASPKAT2LXXX1'));
        self::assertFalse(BIC::isValid('DABADKK'));
        self::assertFalse(BIC::isValid('RZ00AT2L303'));
        self::assertFalse(BIC::isValid('1SBACNBXSHA'));
        self::assertFalse(BIC::isValid('D2BACNBXSHA'));
        self::assertFalse(BIC::isValid('DS3ACNBXSHA'));
        self::assertFalse(BIC::isValid('DSB4CNBXSHA'));
        self::assertFalse(BIC::isValid('DSBA5NBXSHA'));
        self::assertFalse(BIC::isValid('DSBAC6BXSHA'));
        self::assertFalse(BIC::isValid('1S3AC6BXSHA'));
    }
}
