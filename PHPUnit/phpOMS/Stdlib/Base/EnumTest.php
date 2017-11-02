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

use phpOMS\Stdlib\Base\Enum;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

final class EnumDemo extends Enum
{
    const ENUM1 = 1;
    const ENUM2 = ';l';
};

class EnumTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSet()
    {
        self::assertTrue(EnumDemo::isValidName('ENUM1'));
        self::assertFalse(EnumDemo::isValidName('enum1'));

        self::assertEquals(['ENUM1' => 1, 'ENUM2' => ';l'], EnumDemo::getConstants(), true);

        self::assertTrue(EnumDemo::isValidValue(1));
        self::assertTrue(EnumDemo::isValidValue(';l'));
        self::assertFalse(EnumDemo::isValidValue('e3'));
        self::assertTrue(EnumDemo::isValidValue(EnumDemo::getRandom()));
        self::assertEquals(EnumDemo::ENUM2, EnumDemo::getByName('ENUM2'));
        self::assertEquals(EnumDemo::ENUM2, EnumDemo::getByName('ENUM2'));
        self::assertEquals(2, EnumDemo::count());
        self::assertEquals('ENUM1', EnumDemo::getName('1'));
        self::assertEquals('ENUM2', EnumDemo::getName(';l'));
    }

    /**
     * @expectedException \Exception
     */
    public function testEmailException()
    {
        EnumDemo::getByName('ENUM3');
    }
}
