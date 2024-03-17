<?php return [
    'Module:Admin-encryption-change' => [
        'callback' => [
            0 => '\Modules\Admin\Controller\CliController:runEncryptionChangeFromHook',
            1 => '\Modules\Media\Controller\CliController:runEncryptionChangeFromHook',
            2 => '\Modules\Admin\Controller\CliController:runEncryptionChangeFromHook',
            3 => '\Modules\Media\Controller\CliController:runEncryptionChangeFromHook',
            4 => '\Modules\Admin\Controller\CliController:runEncryptionChangeFromHook',
            5 => '\Modules\Media\Controller\CliController:runEncryptionChangeFromHook',
            6 => '\Modules\Media\Controller\CliController:runEncryptionChangeFromHook',
        ],
    ],
    '/.*/' => [
        'callback' => [
            0 => '\Modules\Workflow\Controller\CliController:runWorkflowFromHook',
        ],
    ],
];