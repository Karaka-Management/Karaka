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

use phpOMS\DataStorage\Database\DatabaseType;

class DatabaseTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(5, count(DatabaseType::getConstants()));
        self::assertEquals('mysql', DatabaseType::MYSQL);
        self::assertEquals('sqlite', DatabaseType::SQLITE);
        self::assertEquals('mssql', DatabaseType::SQLSRV);
    }
}
