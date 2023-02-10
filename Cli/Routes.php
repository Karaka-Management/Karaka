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
    '^/admin/audit/blockchain/create.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\CliController:cliGenerateBlockchain',
            'verb' => 16,
        ],
    ],
    '^.*/admin/monitoring/log.*$' => [
        0 => [
            'dest' => '\Modules\Monitoring\Controller\CliController:cliLogReport',
            'verb' => 2,
        ],
    ],
    '^.*/workflow/instance.*$' => [
        0 => [
            'dest' => '\Modules\Workflow\Controller\CliController:cliWorkflowInstanceCreate',
            'verb' => 2,
        ],
    ],
    '^.*/orw/check -i all*$' => [
        0 => [
            'dest' => '\Modules\OnlineResourceWatcher\Controller\ApiController:apiCheckResources',
            'permission' => [
                'module' => 'OnlineResourceWatcher',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
];