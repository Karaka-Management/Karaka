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

use phpOMS\Utils\Converter\AreaType;

class AreaTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(13, count(AreaType::getConstants()));
        self::assertEquals(AreaType::getConstants(), array_unique(AreaType::getConstants()));
       
        self::assertEquals('ft', AreaType::SQUARE_FEET);
        self::assertEquals('m', AreaType::SQUARE_METERS);
        self::assertEquals('km', AreaType::SQUARE_KILOMETERS);
        self::assertEquals('mi', AreaType::SQUARE_MILES);
        self::assertEquals('yd', AreaType::SQUARE_YARDS);
        self::assertEquals('in', AreaType::SQUARE_INCHES);
        self::assertEquals('muin', AreaType::SQUARE_MICROINCHES);
        self::assertEquals('cm', AreaType::SQUARE_CENTIMETERS);
        self::assertEquals('mm', AreaType::SQUARE_MILIMETERS);
        self::assertEquals('micron', AreaType::SQUARE_MICROMETERS);
        self::assertEquals('dm', AreaType::SQUARE_DECIMETERS);
        self::assertEquals('ha', AreaType::HECTARES);
        self::assertEquals('ac', AreaType::ACRES);
    }
}
