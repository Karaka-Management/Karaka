<?php return [
    '^/* .*?$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\CliController:viewEmptyCommand',
            'verb' => 16,
        ],
    ],
    '^/admin/event( .*$|$)' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\CliController:cliRunEvent',
            'verb' => 16,
        ],
    ],
    '^/admin/encryption/change( .*$|$)' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\CliController:cliEncryptionChange',
            'verb' => 16,
        ],
    ],
    '^/admin/audit/blockchain/create( .*$|$)' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\CliController:cliGenerateBlockchain',
            'verb' => 16,
        ],
    ],
    '^.*/admin/monitoring/log( .*$|$)' => [
        0 => [
            'dest' => '\Modules\Monitoring\Controller\CliController:cliLogReport',
            'verb' => 16,
        ],
    ],
    '^.*/workflow/instance( .*$|$)' => [
        0 => [
            'dest' => '\Modules\Workflow\Controller\CliController:cliWorkflowInstanceCreate',
            'verb' => 16,
        ],
    ],
    '^/billing/bill/purchase/parse( .*$|$)' => [
        0 => [
            'dest' => '\Modules\Billing\Controller\CliController:cliParseSupplierBill',
            'verb' => 16,
        ],
    ],
    '^/purchase/order/suggestion/create( .*$|$)' => [
        0 => [
            'dest' => '\Modules\Purchase\Controller\CliController:cliGenerateOrderSuggestion',
            'verb' => 16,
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