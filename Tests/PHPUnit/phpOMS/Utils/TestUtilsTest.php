<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Utils;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\TestUtils;

class TestUtilsTest extends \PHPUnit\Framework\TestCase
{
    public function testGet()
    {
        $class = new class {
            private $a = 1;
            protected $b = 2;
            public $c = 3;
        };

        self::assertEquals(1, TestUtils::getMember($class, 'a'));
        self::assertEquals(2, TestUtils::getMember($class, 'b'));
        self::assertEquals(3, TestUtils::getMember($class, 'c'));

        self::assertNull(TestUtils::getMember($class, 'd'));
    }

    public function testSet()
    {
        $class = new class {
            private $a = 1;
            protected $b = 2;
            public $c = 3;
        };

        self::assertTrue(TestUtils::setMember($class, 'a', 4));
        self::assertTrue(TestUtils::setMember($class, 'b', 5));
        self::assertTrue(TestUtils::setMember($class, 'c', 6));

        self::assertEquals(4, TestUtils::getMember($class, 'a'));
        self::assertEquals(5, TestUtils::getMember($class, 'b'));
        self::assertEquals(6, TestUtils::getMember($class, 'c'));

        self::assertFalse(TestUtils::setMember($class, 'd', 7));
    }
}
