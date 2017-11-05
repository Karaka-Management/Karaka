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

use phpOMS\Math\Number\Natural;

class NaturalTest extends \PHPUnit\Framework\TestCase
{
    public function testNatural()
    {
        self::assertTrue(Natural::isNatural(1235));
        self::assertTrue(Natural::isNatural(0));
        self::assertFalse(Natural::isNatural(-1235));
        self::assertFalse(Natural::isNatural('123'));
        self::assertFalse(Natural::isNatural(1.23));
    }
}
