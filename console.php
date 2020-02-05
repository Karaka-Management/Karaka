<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   OrangeManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

//<editor-fold desc="Require/Include">
require_once __DIR__ . '/phpOMS/Autoloader.php';

/** @var array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string, prefix:string}, insert:array{db:string, database:string, prefix:string}, select:array{db:string, database:string, prefix:string}, update:array{db:string, database:string, prefix:string}, delete:array{db:string, database:string, prefix:string}, schema:array{db:string, database:string, prefix:string}}}}} $config */
$config = require_once __DIR__ . '/config.php';
//</editor-fold>

$App = new \Console\ConsoleApplication($argv, $config);
