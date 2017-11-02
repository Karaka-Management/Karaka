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

namespace Tests\PHPUnit\phpOMS\Stdlib\Base;

use phpOMS\Stdlib\Base\Iban;
use phpOMS\Localization\ISO3166TwoEnum;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

class IbanTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $iban = new Iban('DE22 6008 0000 0960 0280 00');
        self::assertObjectHasAttribute('iban', $iban);
    }

    public function testMethods()
    {
        $strRepresentation = 'DE22 6008 0000 0960 0280 00';
        $iban              = new Iban($strRepresentation);

        self::assertEquals(ISO3166TwoEnum::_DEU, $iban->getCountry());
        self::assertEquals('22', $iban->getChecksum());
        self::assertEquals('60080000', $iban->getBankCode());
        self::assertEquals('0960028000', $iban->getAccount());
        self::assertEquals($strRepresentation, $iban->prettyPrint());
        self::assertEquals($strRepresentation, $iban->serialize());

        $iban->unserialize('dE226008000009600280 00');
        self::assertEquals('DE22 6008 0000 0960 0280 00', $iban->serialize());

        self::assertEquals('', $iban->getAccountType());
        self::assertEquals('', $iban->getBicCode());
        self::assertEquals('', $iban->getBranchCode());
        self::assertEquals('', $iban->getCurrency());
        self::assertEquals('', $iban->getHoldersKennital());
        self::assertEquals('', $iban->getNationalChecksum());
        self::assertEquals('', $iban->getOwnerAccountNumber());
        self::assertEquals(22, $iban->getLength());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidIbanCountry()
    {
        $iban = new Iban('ZZ22 6008 0000 0960 0280 00');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidIbanLength()
    {
        $iban = new Iban('DE22 6008 0000 0960 0280 0');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidIbanChecksum()
    {
        $iban = new Iban('DEA9 6008 0000 0960 0280 00');
    }
}
