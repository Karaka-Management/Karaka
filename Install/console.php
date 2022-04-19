<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

// @codeCoverageIgnoreStart
//<editor-fold desc="Require/Include">
require_once __DIR__ . '/../phpOMS/Autoloader.php';
$config = require_once __DIR__ . '/../config.php';
//</editor-fold>

$App = new \Install\ConsoleApplication($config, $argv);
// @codeCoverageIgnoreEnd
