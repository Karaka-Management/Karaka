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

namespace Tests\PHPUnit\phpOMS\Config;

use phpOMS\Config\OptionsTrait;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class OptionsTraitTest extends \PHPUnit\Framework\TestCase
{

    public function testOptionTrait()
    {
        $class = new class {
            use OptionsTrait;
        };

        /* Testing members */
        self::assertObjectHasAttribute('options', $class);
    }

    public function testDefault()
    {
        $class = new class {
            use OptionsTrait;
        };

        self::assertFalse($class->exists('someKey'));
        self::assertNull($class->getOption('someKey'));
    }

    public function testSetGet()
    {
        $class = new class {
            use OptionsTrait;
        };

        self::assertTrue($class->setOption('a', 'value1'));
        self::assertTrue($class->exists('a'));
        self::assertEquals('value1', $class->getOption('a'));

        self::assertTrue($class->setOption('a', 'value2'));
        self::assertTrue($class->exists('a'));
        self::assertEquals('value2', $class->getOption('a'));

        self::assertTrue($class->setOption('a', 'value3', true));
        self::assertTrue($class->exists('a'));
        self::assertEquals('value3', $class->getOption('a'));

        self::assertFalse($class->setOption('a', 'value4', false));
        self::assertTrue($class->exists('a'));
        self::assertEquals('value3', $class->getOption('a'));

        self::assertTrue($class->setOptions(['b' => 2, 'c' => '3'], true));
        self::assertFalse($class->setOptions(['b' => 4, 'c' => '5'], false));
        self::assertTrue($class->exists('a'));
        self::assertTrue($class->exists('b'));
        self::assertTrue($class->exists('c'));
        self::assertEquals('value3', $class->getOption('a'));
        self::assertEquals(2, $class->getOption('b'));
        self::assertEquals(3, $class->getOption('c'));
    }
}
