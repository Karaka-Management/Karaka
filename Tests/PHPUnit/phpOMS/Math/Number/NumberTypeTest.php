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

namespace Tests\PHPUnit\phpOMS\Math\Number;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Math\Number\NumberType;

class NumberTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(9, count(NumberType::getConstants()));
        self::assertEquals(NumberType::getConstants(), array_unique(NumberType::getConstants()));

        self::assertEquals(0, NumberType::N_INTEGER);
        self::assertEquals(1, NumberType::N_NATURAL);
        self::assertEquals(2, NumberType::N_EVEN);
        self::assertEquals(4, NumberType::N_UNEVEN);
        self::assertEquals(8, NumberType::N_PRIME);
        self::assertEquals(16, NumberType::N_REAL);
        self::assertEquals(32, NumberType::N_RATIONAL);
        self::assertEquals(64, NumberType::N_IRRATIONAL);
        self::assertEquals(128, NumberType::N_COMPLEX);
    }
}
