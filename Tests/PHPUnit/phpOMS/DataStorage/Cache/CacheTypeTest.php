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

namespace Tests\PHPUnit\phpOMS\DataStorage\Cache;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Cache\CacheType;

class CacheTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(7, count(CacheType::getConstants()));
        self::assertEquals(0, CacheType::_INT);
        self::assertEquals(1, CacheType::_STRING);
        self::assertEquals(2, CacheType::_ARRAY);
        self::assertEquals(3, CacheType::_SERIALIZABLE);
        self::assertEquals(4, CacheType::_FLOAT);
        self::assertEquals(5, CacheType::_BOOL);
        self::assertEquals(6, CacheType::_JSONSERIALIZABLE);
    }
}
