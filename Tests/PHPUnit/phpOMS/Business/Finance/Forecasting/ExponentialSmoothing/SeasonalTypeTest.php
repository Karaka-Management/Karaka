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

namespace Tests\PHPUnit\phpOMS\Business\Finance\Forecasting\ExponentialSmoothing;

require_once __DIR__ . '/../../../../../../../phpOMS/Autoloader.php';

use phpOMS\Business\Finance\Forecasting\ExponentialSmoothing\SeasonalType;

class SeasonalTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(4, count(SeasonalType::getConstants()));
        self::assertEquals(SeasonalType::getConstants(), array_unique(SeasonalType::getConstants()));

        self::assertEquals(0, SeasonalType::ALL);
        self::assertEquals(1, SeasonalType::NONE);
        self::assertEquals(2, SeasonalType::ADDITIVE);
        self::assertEquals(4, SeasonalType::MULTIPLICATIVE);
    }
}
