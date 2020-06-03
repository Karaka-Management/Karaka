<?php declare(strict_types=1);

/** @var array $dispatch */
$dispatch = $this->getData('dispatch') ?? [];

foreach ($dispatch as $view) {
    if ($view instanceof \phpOMS\Contract\RenderableInterface) {
        echo $view->render();
    }
}
