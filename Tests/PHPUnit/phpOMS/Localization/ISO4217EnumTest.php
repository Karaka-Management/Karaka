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

use phpOMS\Localization\ISO4217Enum;

class ISO4217EnumTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        $enum = ISO4217Enum::getConstants();
        self::assertEquals(count($enum), count(array_unique($enum)));
    }
}
