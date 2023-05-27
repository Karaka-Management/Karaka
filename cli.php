<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Karaka
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

\ob_start();

require_once __DIR__ . '/phpOMS/Autoloader.php';

/** @var array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]} $config */
$config = require_once __DIR__ . '/config.php';

$App = new \Cli\CliApplication($config);
$App->run($argv);

if (\ob_get_level() > 0) {
    \ob_end_flush();
}
