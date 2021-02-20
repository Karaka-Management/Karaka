<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

// @codeCoverageIgnoreStart
\ob_start();

//<editor-fold desc="Require/Include">
require_once __DIR__ . '/../phpOMS/Autoloader.php';
$config = require_once __DIR__ . '/../config.php';
//</editor-fold>

$App = new \Install\WebApplication($config);

if (\ob_get_level() > 0) {
	\ob_end_flush();
}
// @codeCoverageIgnoreEnd
