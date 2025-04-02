<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Install\WebApplication;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestMethod;

\ini_set('memory_limit', '2048M');
\ini_set('display_errors', '1');
\ini_set('display_startup_errors', '1');
\error_reporting(\E_ALL);

require_once __DIR__ . '/../phpOMS/Autoloader.php';

/////////////////////////////////////////////////////////////////
//
// START OF DATA TO MODIFY
//
// Change the following data:
//      Data inside of config.php
//      The variables below
/////////////////////////////////////////////////////////////////

$config = require_once __DIR__ . '/config.php';

$orgname        = 'Jingga';
$adminname      = 'admin';
$adminpassword  = 'orange';
$adminemail     = 'admin@demo.app';
$domain         = '127.0.0.1';
$websubdir      = $config['page']['root'];
$defaultlang    = 'en';
$defaultcountry = 'US';

/////////////////////////////////////////////////////////////////
//
// END OF DATA TO MODIFY
//
/////////////////////////////////////////////////////////////////

// Check writing permissions
if (!\is_writable(__DIR__ . '/../Modules')
    || !\is_writable(__DIR__ . '/../Install')
    || !\is_writable(__DIR__ . '/../Web')
    || !\is_writable(__DIR__ . '/../Cli')
    || !\is_writable('/tmp')
) {
    echo "Not sufficient permissions.\n";

    exit(-1);
}

if (!\extension_loaded('pdo')) {
    echo "One or multiple of the following required extensions is not installed (pdo)\n";

    exit(-1);
}

if (!\extension_loaded('imap')
    || !\extension_loaded('curl')
    || !\extension_loaded('ftp')
    || !\extension_loaded('dom')
    || !\extension_loaded('xml')
    || !\extension_loaded('bcmath')
    || !\extension_loaded('mbstring')
    || !\extension_loaded('zip')
    || !\extension_loaded('zlib')
    || !\extension_loaded('gd')
) {
    echo "One or multiple of the following optional extensions is not installed,\n";
    echo "the installation will still continue: (pdo, imap, curl, ftp, dom, xml, bcmath, mbstring, zip, zlib, gd).\n";
}

$dbname = $config['db']['core']['masters']['admin']['database'];

$con = new \PDO($config['db']['core']['masters']['admin']['db'] . ':host=' .
    $config['db']['core']['masters']['admin']['host'],
    $config['db']['core']['masters']['admin']['login'],
    $config['db']['core']['masters']['admin']['password']
);

\exec('crontab -r');

\mkdir(__DIR__ . '/../Modules/OnlineResourceWatcher/Files', 0755);
\mkdir(__DIR__ . '/../Modules/Media/Files', 0755);

// Reset database
$con = new \PDO($config['db']['core']['masters']['admin']['db'] . ':host=' .
$config['db']['core']['masters']['admin']['host'],
$config['db']['core']['masters']['admin']['login'],
$config['db']['core']['masters']['admin']['password']
);
$con->exec('DROP DATABASE IF EXISTS ' . $config['db']['core']['masters']['admin']['database']);

$con->exec('CREATE DATABASE IF NOT EXISTS ' . $config['db']['core']['masters']['admin']['database']);

$response = new HttpResponse();
$request  = new HttpRequest();
$request->setMethod(RequestMethod::POST);

$request->setData('dbhost', $config['db']['core']['masters']['admin']['host']);
$request->setData('dbtype', $config['db']['core']['masters']['admin']['db']);
$request->setData('dbport', $config['db']['core']['masters']['admin']['port']);
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

$request->setData('orgname', $orgname);
$request->setData('adminname', $adminname);
$request->setData('adminpassword', $adminpassword);
$request->setData('adminemail', $adminemail);
$request->setData('domain', $domain);
$request->setData('websubdir', $websubdir);
$request->setData('defaultlang', $defaultlang);
$request->setData('defaultcountry', $defaultcountry);

$request->setData(
    'apps',
    'Install/Application/Api, '
    . 'Install/Application/Backend, '
    . 'Install/Application/E404, '
    . 'Install/Application/E500, '
    . 'Install/Application/E503'
);

WebApplication::installRequest($request, $response);
