<?php return [
    'Module:Admin-encryption-change' => [
        'callback' => [
            0 => '\Modules\Admin\Controller\CliController:runEncryptionChangeFromHook',
            1 => '\Modules\Media\Controller\CliController:runEncryptionChangeFromHook',
        ],
    ],
];