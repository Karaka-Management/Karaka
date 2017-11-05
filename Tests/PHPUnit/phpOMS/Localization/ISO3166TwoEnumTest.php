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

namespace Tests\PHPUnit\phpOMS\Localization;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Localization\ISO3166TwoEnum;

class ISO3166TwoEnumTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        $ok = true;

        $countryCodes = ISO3166TwoEnum::getConstants();

        foreach ($countryCodes as $code) {
            if (strlen($code) !== 2) {
                $ok = false;
                break;
            }
        }

        self::assertTrue($ok);
        self::assertEquals(count($countryCodes), count(array_unique($countryCodes)));
    }
}
