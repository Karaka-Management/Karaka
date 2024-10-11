<?php return [
    'Module:Admin-encryption-change' => [
        'callback' => [
            0 => '\Modules\Admin\Controller\CliController:runEncryptionChangeFromHook',
            1 => '\Modules\Media\Controller\CliController:runEncryptionChangeFromHook',
        ],
    ],
    '/.*/' => [
        'callback' => [
            0 => '\Modules\Workflow\Controller\CliController:runWorkflowFromHook',
        ],
    ],
];