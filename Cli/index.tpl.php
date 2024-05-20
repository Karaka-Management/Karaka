<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Template
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

$dispatch = $this->getData('dispatch') ?? [];

echo \PHP_EOL;

/** @var \phpOMS\Views\ViewAbstract $view */
foreach ($dispatch as $view) {
    if (!($view instanceof \phpOMS\Views\NullView)
        && $view instanceof \phpOMS\Contract\RenderableInterface
    ) {
        echo $view->render();
    }
}

echo \PHP_EOL , \PHP_EOL;
