<?php return [
    '^/* .*?$' => [
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
    '^.*/admin/monitoring/log.*$' => [
        0 => [
            'dest' => '\Modules\Monitoring\Controller\CliController:cliLogReport',
            'verb' => 2,
        ],
    ],
];