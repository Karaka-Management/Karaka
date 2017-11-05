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

use phpOMS\Utils\Converter\PressureType;

class PressureTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(13, count(PressureType::getConstants()));
        self::assertEquals(PressureType::getConstants(), array_unique(PressureType::getConstants()));
        
        self::assertEquals('Pa', PressureType::PASCALS);
        self::assertEquals('bar', PressureType::BAR);
        self::assertEquals('psi', PressureType::POUND_PER_SQUARE_INCH);
        self::assertEquals('atm', PressureType::ATMOSPHERES);
        self::assertEquals('inHg', PressureType::INCHES_OF_MERCURY);
        self::assertEquals('inH20', PressureType::INCHES_OF_WATER);
        self::assertEquals('mmH20', PressureType::MILLIMETERS_OF_WATER);
        self::assertEquals('mmHg', PressureType::MILLIMETERS_OF_MERCURY);
        self::assertEquals('mbar', PressureType::MILLIBAR);
        self::assertEquals('kg/m2', PressureType::KILOGRAM_PER_SQUARE_METER);
        self::assertEquals('N/m2', PressureType::NEWTONS_PER_METER_SQUARED);
        self::assertEquals('psf', PressureType::POUNDS_PER_SQUARE_FOOT);
        self::assertEquals('Torr', PressureType::TORRS);
    }
}
