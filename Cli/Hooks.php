<?php return [
    '/.*/' => [
        'callback' => [
            0 => '\Modules\Workflow\Controller\CliController:runWorkflowFromHook',
        ],
    ],
];