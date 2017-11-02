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

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Stdlib\Base\PhoneType;

class PhoneTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(4, count(PhoneType::getConstants()));
        self::assertEquals(1, PhoneType::HOME);
        self::assertEquals(2, PhoneType::BUSINESS);
        self::assertEquals(3, PhoneType::MOBILE);
        self::assertEquals(4, PhoneType::WORK);
    }
}
