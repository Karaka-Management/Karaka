<?php return [
    'POST:Module:.*?\-create' => [
        'callback' => [
            0 => '\Modules\Auditor\Controller\ApiController:apiLogCreate',
        ],
    ],
    'POST:Module:.*?\-update' => [
        'callback' => [
            0 => '\Modules\Auditor\Controller\ApiController:apiLogUpdate',
        ],
    ],
    'POST:Module:.*?\-delete' => [
        'callback' => [
            0 => '\Modules\Auditor\Controller\ApiController:apiLogDelete',
        ],
    ],
];