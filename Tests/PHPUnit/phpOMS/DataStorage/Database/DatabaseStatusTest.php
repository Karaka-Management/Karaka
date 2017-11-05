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

namespace Tests\PHPUnit\phpOMS\DataStorage\Database;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Database\DatabaseStatus;

class DatabaseStatusTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(6, count(DatabaseStatus::getConstants()));
        self::assertEquals(0, DatabaseStatus::OK);
        self::assertEquals(1, DatabaseStatus::MISSING_DATABASE);
        self::assertEquals(2, DatabaseStatus::MISSING_TABLE);
        self::assertEquals(3, DatabaseStatus::FAILURE);
        self::assertEquals(4, DatabaseStatus::READONLY);
        self::assertEquals(5, DatabaseStatus::CLOSED);
    }
}
