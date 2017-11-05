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

namespace Tests\PHPUnit\phpOMS\Stdlib\Map;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Stdlib\Map\KeyType;

class KeyTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(2, count(KeyType::getConstants()));
        self::assertEquals(0, KeyType::SINGLE);
        self::assertEquals(1, KeyType::MULTIPLE);
    }
}
