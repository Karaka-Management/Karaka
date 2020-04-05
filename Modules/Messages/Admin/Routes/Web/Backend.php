<?php declare(strict_types=1);

use Modules\Messages\Controller\BackendController;
use Modules\Messages\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/messages/dashboard.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageInbox',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
    '^.*/messages/outbox.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageOutbox',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
    '^.*/messages/trash.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageTrash',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
    '^.*/messages/spam.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageSpam',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
    '^.*/messages/settings.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageSettings',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
    '^.*/messages/mail/create.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageCreate',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::CREATE,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
    '^.*/messages/mail/single.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageView',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
    '^.*/messages/mail/single.*$' => [
        [
            'dest' => '\Modules\Messages\Controller\BackendController:viewMessageView',
            'verb' => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::MODULE_NAME,
                'type'  => PermissionType::READ,
                'state' => PermissionState::MESSAGE,
            ],
        ],
    ],
];
