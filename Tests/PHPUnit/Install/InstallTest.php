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

namespace Tests\PHPUnit\Install;

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../config.php';

use Install\Installer;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

class InstallTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @group admin
     */
    public function testInstall()
    {
        // Getting all modules
        $toInstall = [
            'Admin',
        ];

        $instHOBJ = new Installer($GLOBALS['dbpool']);

        $instHOBJ->cleanupPrevious();

        $result = $instHOBJ->installCore();
        self::assertTrue($result);

        $result = $instHOBJ->installModules($toInstall);
        self::assertTrue($result);

        $result = $instHOBJ->installGroups();
        self::assertTrue($result);

        $result = $instHOBJ->installUsers();
        self::assertTrue($result);

        $result = $instHOBJ->installSettings();
        self::assertTrue($result);

        // todo: implement schema query builder so it's possible to check if table exists. maybe performing a unit test
        // here on the schema is wrong after all and should be done only in the modules after the framework test
    }
}
