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
        $response = new Response();
        $request = new Request(new Http(''));

        $request->setData('', '');

        Application::installRequest($request, $response);
    }
}
