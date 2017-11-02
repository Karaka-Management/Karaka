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

namespace Tests\PHPUnit\phpOMS\Utils\Converter;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Converter\EnergyPowerType;

class EnergyPowerTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(9, count(EnergyPowerType::getConstants()));
        self::assertEquals(EnergyPowerType::getConstants(), array_unique(EnergyPowerType::getConstants()));
        
        self::assertEquals('kWh', EnergyPowerType::KILOWATT_HOUERS);
        self::assertEquals('MWh', EnergyPowerType::MEGAWATT_HOUERS);
        self::assertEquals('kt', EnergyPowerType::KILOTONS);
        self::assertEquals('J', EnergyPowerType::JOULS);
        self::assertEquals('Cal', EnergyPowerType::CALORIES);
        self::assertEquals('BTU', EnergyPowerType::BTU);
        self::assertEquals('kJ', EnergyPowerType::KILOJOULS);
        self::assertEquals('thmEC', EnergyPowerType::THERMEC);
        self::assertEquals('Nm', EnergyPowerType::NEWTON_METERS);
    }
}
