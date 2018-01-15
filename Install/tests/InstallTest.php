<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\Install;


require_once __DIR__ . '/../../../config.php';

use phpOMS\ApplicationAbstract;
use Install\Application;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Uri\Http;

class InstallTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @group admin
     */
    public function testInstall()
    {
        $config = include __DIR__ . '/../../../config.php';
        $response = new Response();
        $request = new Request(new Http(''));

        $request->setData('dbhost', $config['db']['core']['masters']['admin']['host']);
        $request->setData('dbtype', $config['db']['core']['masters']['admin']['db']);
        $request->setData('dbport', $config['db']['core']['masters']['admin']['port']);
        $request->setData('dbprefix', $config['db']['core']['masters']['admin']['prefix']);
        $request->setData('dbname', $config['db']['core']['masters']['admin']['database']);
        $request->setData('schemauser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('schemapassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('createuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('createpassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('selectuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('selectpassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('updateuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('updatepassword', $config['db']['core']['masters']['admin']['password']);
        $request->setData('deleteuser', $config['db']['core']['masters']['admin']['login']);
        $request->setData('deletepassword', $config['db']['core']['masters']['admin']['password']);
        
        $request->setData('orgname', 'Orange-Management');
        $request->setData('adminname', 'admin');
        $request->setData('adminpassword', 'orange');
        $request->setData('adminemail', 'admin@oms.com');
        $request->setData('domain', '127.0.0.1');
        $request->setData('websubdir', '/');
        $request->setData('defaultlang', 'en');

        Application::installRequest($request, $response);
    }
}
