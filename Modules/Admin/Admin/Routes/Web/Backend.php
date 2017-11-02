<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/admin/settings/general.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewSettingsGeneral', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/account/list.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewAccountList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/account/settings.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewAccountSettings', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/account/create.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewAccountCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/group/list.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewGroupList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/group/settings.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewGroupSettings', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/group/create.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewGroupCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/module/list.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewModuleList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/module/settings.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:viewModuleProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
