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

use phpOMS\Utils\Converter\AngleType;

class AngleTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(10, count(AngleType::getConstants()));
        self::assertEquals(AngleType::getConstants(), array_unique(AngleType::getConstants()));
        
        self::assertEquals('deg', AngleType::DEGREE);
        self::assertEquals('rad', AngleType::RADIAN);
        self::assertEquals('arcsec', AngleType::SECOND);
        self::assertEquals('arcmin', AngleType::MINUTE);
        self::assertEquals('mil (us ww2)', AngleType::MILLIRADIAN_US);
        self::assertEquals('mil (uk)', AngleType::MILLIRADIAN_UK);
        self::assertEquals('mil (ussr)', AngleType::MILLIRADIAN_USSR);
        self::assertEquals('mil (nato)', AngleType::MILLIRADIAN_NATO);
        self::assertEquals('g', AngleType::GRADIAN);
        self::assertEquals('crad', AngleType::CENTRAD);
    }
}
