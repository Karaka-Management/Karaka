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

namespace Tests\PHPUnit\phpOMS\Utils\RnG;

use phpOMS\Utils\RnG\StringUtils;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

class StringUtilsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @slowThreshold 1500
     */
    public function testStrings()
    {
        $haystack = [];
        $outOfBounds = false;
        $randomness = 0;

        for ($i = 0; $i < 10000; $i++) {
            $random = StringUtils::generateString(5, 12, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_?><|;"');

            if (strlen($random) > 12 || strlen($random) < 5) {
                $outOfBounds = true;
            }

            if (in_array($random, $haystack)) {
                $randomness++;
            }

            $haystack[] = $random;
        }

        self::assertFalse($outOfBounds);
        self::assertLessThan(5, $randomness);
    }
}
