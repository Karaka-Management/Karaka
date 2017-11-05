<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Account;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Account\PermissionType;

class PermissionTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(6, count(PermissionType::getConstants()));
        self::assertEquals(PermissionType::getConstants(), array_unique(PermissionType::getConstants()));
        
        self::assertEquals(1, PermissionType::NONE);
        self::assertEquals(2, PermissionType::READ);
        self::assertEquals(4, PermissionType::CREATE);
        self::assertEquals(8, PermissionType::MODIFY);
        self::assertEquals(16, PermissionType::DELETE);
        self::assertEquals(32, PermissionType::PERMISSION);
    }
}
