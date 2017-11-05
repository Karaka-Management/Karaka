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

namespace Tests\PHPUnit\phpOMS\Localization;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Localization\ISO4217SymbolEnum;
use phpOMS\Localization\Money;

class MoneyTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $money = new Money(0);

        self::assertObjectHasAttribute('thousands', $money);
        self::assertObjectHasAttribute('decimal', $money);
        self::assertObjectHasAttribute('value', $money);

        self::assertGreaterThan(0, Money::MAX_DECIMALS);
        
        self::assertEquals(0, $money->getInt());
    }

    public function testMoney() 
    {
        $money = new Money(12345678);

        self::assertEquals('1,234.57', $money->getAmount());
        self::assertEquals('1,234.5678', $money->getAmount(4));
        self::assertEquals('1,234.5678', $money->getAmount(7));

        self::assertEquals(12345678, Money::toInt('1234.5678'));
        self::assertEquals(12345600, Money::toInt('1,234.56'));
        self::assertEquals(12345600, Money::toInt('1234,56', '.', ','));
    }

    public function testMoneySetters() 
    {
        $money = new Money(12345678);
        self::assertEquals('999.13', $money->setString('999.13')->getAmount());
        self::assertEquals('999.23', $money->setInt(9992300)->getAmount());

        self::assertEquals('€9.992,30', $money->setInt(99923000)->setLocalization('.', ',', ISO4217SymbolEnum::_EUR, 0)->getCurrency());
    }

    public function testMoneySerialization() 
    {
        $money = new Money('999.23');
        self::assertEquals(9992300, $money->serialize());

        $money->unserialize(3331234);
        self::assertEquals('333.12', $money->getAmount());
    }

    public function testMoneyAddSub()
    {
        $money = new Money(10000);

        self::assertEquals('1.0001', $money->add('0.0001')->getAmount(4));
        self::assertEquals('1.0000', $money->sub('0.0001')->getAmount(4));

        self::assertEquals('2.0000', $money->add(1.0)->getAmount(4));
        self::assertEquals('1.0000', $money->sub(1.0)->getAmount(4));

        self::assertEquals('1.0001', $money->add(1)->getAmount(4));
        self::assertEquals('1.0000', $money->sub(1)->getAmount(4));

        self::assertEquals('2.0000', $money->add(new Money(1.0))->getAmount(4));
        self::assertEquals('1.0000', $money->sub(new Money(10000))->getAmount(4));
    }

    public function testMoneyMultDiv()
    {
        $money = new Money(19100);

        self::assertEquals('3.8200', $money->mult(2.0)->getAmount(4));
        self::assertEquals('1.9100', $money->div(2.0)->getAmount(4));
    }

    public function testMoneyOtherOperations()
    {
        $money = new Money(-38200);

        self::assertEquals('3.8200', $money->mult(-1)->abs()->getAmount(4));
        self::assertEquals('800.0000', $money->setInt(200)->pow(3)->getAmount(4));
    }
}
