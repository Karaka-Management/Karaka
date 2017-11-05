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

use phpOMS\Utils\Converter\LengthType;

class LengthTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(21, count(LengthType::getConstants()));
        self::assertEquals(LengthType::getConstants(), array_unique(LengthType::getConstants()));
        
        self::assertEquals('mi', LengthType::MILES);
        self::assertEquals('m', LengthType::METERS);
        self::assertEquals('micron', LengthType::MICROMETER);
        self::assertEquals('cm', LengthType::CENTIMETERS);
        self::assertEquals('mm', LengthType::MILLIMETERS);
        self::assertEquals('km', LengthType::KILOMETERS);
        self::assertEquals('ch', LengthType::CHAINS);
        self::assertEquals('ft', LengthType::FEET);
        self::assertEquals('fur', LengthType::FURLONGS);
        self::assertEquals('muin', LengthType::MICROINCH);
        self::assertEquals('in', LengthType::INCHES);
        self::assertEquals('yd', LengthType::YARDS);
        self::assertEquals('pc', LengthType::PARSECS);
        self::assertEquals('uk nmi', LengthType::UK_NAUTICAL_MILES);
        self::assertEquals('us nmi', LengthType::US_NAUTICAL_MILES);
        self::assertEquals('uk nl', LengthType::UK_NAUTICAL_LEAGUES);
        self::assertEquals('nl', LengthType::NAUTICAL_LEAGUES);
        self::assertEquals('uk lg', LengthType::UK_LEAGUES);
        self::assertEquals('us lg', LengthType::US_LEAGUES);
        self::assertEquals('ly', LengthType::LIGHTYEARS);
        self::assertEquals('dm', LengthType::DECIMETERS);
    }
}
