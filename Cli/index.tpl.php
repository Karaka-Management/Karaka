<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Template
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use phpOMS\Contract\RenderableInterface;

$dispatch = $this->getData('dispatch') ?? [];

echo \PHP_EOL;

/** @var \phpOMS\Views\ViewAbstract $view */
foreach ($dispatch as $view) {
    if ($view instanceof RenderableInterface) {
        echo $view->render();
    }
}

if (empty($dispatch)) {
    echo 'Use "get:/help/module/{module_name}" to get help for a specific installed module.';
}

echo \PHP_EOL , \PHP_EOL;
