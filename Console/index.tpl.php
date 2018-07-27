<?php
$dispatch = $this->getData('dispatch') ?? [];

echo PHP_EOL;
foreach ($dispatch as $view) {
    if ($view instanceOf \Serializable) {
        echo $view->render();
    }
}

if (empty($dispatch)) {
    echo 'Use "get:/help/module/{module_name}" to get help for a specific installed module.';
}

echo PHP_EOL , PHP_EOL;