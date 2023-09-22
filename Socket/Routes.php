<?php return [
    '^.*/testmodule.*$' => [
        1 => [
            'dest' => '\Modules\TestModule\Controller\Controller:testEndpoint',
            'verb' => 1,
            'permission' => [
                'module' => 'TestModule',
                'type' => 1,
                'state' => 2,
            ],
        ],
    ],
];