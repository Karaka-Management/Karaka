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

use phpOMS\Utils\Converter\SpeedType;

class SpeedTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(34, count(SpeedType::getConstants()));
        self::assertEquals(SpeedType::getConstants(), array_unique(SpeedType::getConstants()));
        
        self::assertEquals('mpd', SpeedType::MILES_PER_DAY);
        self::assertEquals('mph', SpeedType::MILES_PER_HOUR);
        self::assertEquals('mpm', SpeedType::MILES_PER_MINUTE);
        self::assertEquals('mps', SpeedType::MILES_PER_SECOND);
        self::assertEquals('kpd', SpeedType::KILOMETERS_PER_DAY);
        self::assertEquals('kph', SpeedType::KILOMETERS_PER_HOUR);
        self::assertEquals('kpm', SpeedType::KILOMETERS_PER_MINUTE);
        self::assertEquals('kps', SpeedType::KILOMETERS_PER_SECOND);
        self::assertEquals('md', SpeedType::METERS_PER_DAY);
        self::assertEquals('mh', SpeedType::METERS_PER_HOUR);
        self::assertEquals('mm', SpeedType::METERS_PER_MINUTE);
        self::assertEquals('ms', SpeedType::METERS_PER_SECOND);
        self::assertEquals('cpd', SpeedType::CENTIMETERS_PER_DAY);
        self::assertEquals('cph', SpeedType::CENTIMETERS_PER_HOUR);
        self::assertEquals('cpm', SpeedType::CENTIMETERS_PER_MINUTES);
        self::assertEquals('cps', SpeedType::CENTIMETERS_PER_SECOND);
        self::assertEquals('mmpd', SpeedType::MILLIMETERS_PER_DAY);
        self::assertEquals('mmph', SpeedType::MILLIMETERS_PER_HOUR);
        self::assertEquals('mmpm', SpeedType::MILLIMETERS_PER_MINUTE);
        self::assertEquals('mmps', SpeedType::MILLIMETERS_PER_SECOND);
        self::assertEquals('ypd', SpeedType::YARDS_PER_DAY);
        self::assertEquals('yph', SpeedType::YARDS_PER_HOUR);
        self::assertEquals('ypm', SpeedType::YARDS_PER_MINUTE);
        self::assertEquals('yps', SpeedType::YARDS_PER_SECOND);
        self::assertEquals('ind', SpeedType::INCHES_PER_DAY);
        self::assertEquals('inh', SpeedType::INCHES_PER_HOUR);
        self::assertEquals('inm', SpeedType::INCHES_PER_MINUTE);
        self::assertEquals('ins', SpeedType::INCHES_PER_SECOND);
        self::assertEquals('ftd', SpeedType::FEET_PER_DAY);
        self::assertEquals('fth', SpeedType::FEET_PER_HOUR);
        self::assertEquals('ftm', SpeedType::FEET_PER_MINUTE);
        self::assertEquals('fts', SpeedType::FEET_PER_SECOND);
        self::assertEquals('mach', SpeedType::MACH);
        self::assertEquals('knots', SpeedType::KNOTS);
    }
}
