<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Orange-Management
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

\ob_start();

//<editor-fold desc="Require/Include">
require_once __DIR__ . '/phpOMS/Autoloader.php';

/** @var array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[]} $config */
$config = require_once __DIR__ . '/config.php';
//</editor-fold>

$App = new \Web\WebApplication($config);

\ob_end_flush();
