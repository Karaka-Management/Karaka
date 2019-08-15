<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package    OrangeManagement
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */
//<editor-fold desc="Require/Include">
require_once __DIR__ . '/phpOMS/Autoloader.php';
$config = require_once __DIR__ . '/config.php';
//</editor-fold>

$App = new \Console\ConsoleApplication($argv, $config);
