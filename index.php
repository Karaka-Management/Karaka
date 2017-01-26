<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @author     Dennis Eichhorn <d.eichhorn@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
ob_start();

//<editor-fold desc="Require/Include">
require_once __DIR__ . '/phpOMS/Autoloader.php';
require_once __DIR__ . '/config.php';
//</editor-fold>

$App = new \Web\WebApplication($CONFIG);

ob_end_flush();
