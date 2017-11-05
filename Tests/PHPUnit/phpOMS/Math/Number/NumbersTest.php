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

namespace Tests\PHPUnit\phpOMS\Math\Number;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Number\Numbers;

class NumbersTest extends \PHPUnit\Framework\TestCase
{
    public function testPerfect()
    {
        self::assertTrue(Numbers::isPerfect(496));
        self::assertTrue(Numbers::isPerfect(8128));
        self::assertFalse(Numbers::isPerfect(7));
        self::assertFalse(Numbers::isPerfect(100));
    }

    public function testSelfdescribing()
    {
        self::assertFalse(Numbers::isSelfdescribing(2029));
        self::assertTrue(Numbers::isSelfdescribing(21200));
        self::assertTrue(Numbers::isSelfdescribing(3211000));
    }

    public function testSquare()
    {
        self::assertTrue(Numbers::isSquare(81));
        self::assertTrue(Numbers::isSquare(6561));
        self::assertFalse(Numbers::isSquare(5545348));

        self::assertEquals(3, Numbers::countTrailingZeros(1000));
        self::assertEquals(5, Numbers::countTrailingZeros(12300000));
    }
}
