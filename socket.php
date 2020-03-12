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

//<editor-fold desc="Require/Include">
require_once __DIR__ . '/phpOMS/Autoloader.php';

/** @var array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}, socket:array{master:array}} $config */
$config = require_once __DIR__ . '/config.php';
//</editor-fold>

$App = new \Socket\SocketApplication($config, $argv[1] ?? 'Socketclient');
