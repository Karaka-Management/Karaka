<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Jingga
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

\ob_start();

require_once __DIR__ . '/phpOMS/Autoloader.php';

if (!\is_file(__DIR__ . '/config.php')) {
    \header('Location: /Install');
}

/** @var array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]} $config */
$config = require_once __DIR__ . '/config.php';

$App = new \Web\WebApplication($config);

if (\ob_get_level() > 0) {
    \ob_end_flush();
}
