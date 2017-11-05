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

namespace Tests\PHPUnit\phpOMS\Validation\Base;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Validation\Base\DateTime;

class DateTimeTest extends \PHPUnit\Framework\TestCase
{
    public function testDateTime()
    {
        self::assertTrue(DateTime::isValid('now'));
        self::assertTrue(DateTime::isValid('10 September 2000'));
        self::assertTrue(DateTime::isValid('2012-05-16'));
        self::assertTrue(DateTime::isValid('2012-05-16 22:13:01'));

        self::assertFalse(DateTime::isValid('2012-05-16 22:66:01'));
        self::assertFalse(DateTime::isValid('201M-05-16 22:66:01'));
        self::assertFalse(DateTime::isValid('2'));
        self::assertFalse(DateTime::isValid('String'));
    }
}

