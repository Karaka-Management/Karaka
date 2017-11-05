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

namespace Tests\PHPUnit\phpOMS\Validation\Finance;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Validation\Finance\IbanEnum;

class IbanEnumTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        $enums = IbanEnum::getConstants();
        $ok = true;

        foreach ($enums as $enum) {
            $temp = substr($enum, 2);

            if (preg_match('/[^kbsxcinm0at\ ]/', $temp) === 1) {
                $ok = false;

                break;
            }
        }

        self::assertTrue($ok);
    }
}
