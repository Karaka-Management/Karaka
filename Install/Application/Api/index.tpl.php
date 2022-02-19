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

/** @var array $dispatch */
$dispatch = $this->getData('dispatch') ?? [];

foreach ($dispatch as $view) {
    if ($view instanceof \phpOMS\Contract\RenderableInterface) {
        echo $view->render();
    }
}
