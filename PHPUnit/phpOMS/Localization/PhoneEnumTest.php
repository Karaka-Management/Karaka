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

namespace Tests\PHPUnit\phpOMS\Localization;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Localization\PhoneEnum;

class PhoneEnumTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        $ok = true;

        $countryCodes = PhoneEnum::getConstants();

        foreach ($countryCodes as $code) {
            if (strlen($code) < 0 || $code > 9999) {
                $ok = false;
                break;
            }
        }

        self::assertTrue($ok);
        // phone numbers seem to be not unique (AU, CX)
    }
}
