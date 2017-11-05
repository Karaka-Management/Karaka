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

namespace Tests\PHPUnit\phpOMS\Business\Finance\Forecasting;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\Business\Finance\Forecasting\SmoothingType;

class SmoothingTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(1, count(SmoothingType::getConstants()));
        self::assertEquals(SmoothingType::getConstants(), array_unique(SmoothingType::getConstants()));

        self::assertEquals(1, SmoothingType::CENTERED_MOVING_AVERAGE);
    }
}
