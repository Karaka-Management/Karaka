<?php return [
    '^$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\CliController:viewEmptyCommand',
            'verb' => 16,
        ],
    ],
    '^/admin/event.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\CliController:cliRunEvent',
            'verb' => 16,
        ],
    ],
];