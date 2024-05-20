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

// @codeCoverageIgnoreStart
\ob_start();

//<editor-fold desc="Require/Include">
require_once __DIR__ . '/../phpOMS/Autoloader.php';
//</editor-fold>

$App = new \Install\WebApplication();

if (\ob_get_level() > 0) {
    \ob_end_flush();
}
// @codeCoverageIgnoreEnd
