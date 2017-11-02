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

use phpOMS\Stdlib\Base\EnumArray;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

final class EnumArrayDemo extends EnumArray
{
    protected static $constants = [
        'ENUM1' => 1,
        'ENUM2' => 'abc',
    ];
}

;

class EnumArrayTest extends \PHPUnit\Framework\TestCase
{
    public function testGetSet()
    {
        self::assertEquals(1, EnumArrayDemo::get('ENUM1'));
        self::assertEquals('abc', EnumArrayDemo::get('ENUM2'));

        self::assertTrue(EnumArrayDemo::isValidName('ENUM1'));
        self::assertFalse(EnumArrayDemo::isValidName('enum1'));

        self::assertEquals(['ENUM1' => 1, 'ENUM2' => 'abc'], EnumArrayDemo::getConstants(), true);

        self::assertTrue(EnumArrayDemo::isValidValue(1));
        self::assertTrue(EnumArrayDemo::isValidValue('abc'));
        self::assertFalse(EnumArrayDemo::isValidValue('e3'));
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testInvalidConstantException()
    {
        EnumArrayDemo::get('enum2');
    }
}
