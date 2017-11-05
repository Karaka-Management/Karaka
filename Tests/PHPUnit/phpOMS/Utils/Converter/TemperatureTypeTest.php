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

namespace Tests\PHPUnit\phpOMS\Utils\Converter;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Converter\TemperatureType;

class TemperatureTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(8, count(TemperatureType::getConstants()));
        self::assertEquals(TemperatureType::getConstants(), array_unique(TemperatureType::getConstants()));
        
        self::assertEquals('celsius', TemperatureType::CELSIUS);
        self::assertEquals('fahrenheit', TemperatureType::FAHRENHEIT);
        self::assertEquals('kelvin', TemperatureType::KELVIN);
        self::assertEquals('reaumur', TemperatureType::REAUMUR);
        self::assertEquals('rankine', TemperatureType::RANKINE);
        self::assertEquals('delisle', TemperatureType::DELISLE);
        self::assertEquals('newton', TemperatureType::NEWTON);
        self::assertEquals('romer', TemperatureType::ROMER);
    }
}
