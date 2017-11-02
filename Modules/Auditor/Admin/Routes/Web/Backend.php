<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/admin/audit/list.*$' => [
        [
            'dest' => '\Modules\Auditor\Controller:viewAuditorList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/audit/single.*$' => [
        [
            'dest' => '\Modules\Auditor\Controller:viewAuditorSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/audit/module/list.*$' => [
        [
            'dest' => '\Modules\Auditor\Controller:viewAuditorModuleList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/audit/module/single.*$' => [
        [
            'dest' => '\Modules\Auditor\Controller:viewAuditorModuleSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/audit/account/list.*$' => [
        [
            'dest' => '\Modules\Auditor\Controller:viewAuditorAccountList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/audit/account/single.*$' => [
        [
            'dest' => '\Modules\Auditor\Controller:viewAuditorAccountSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
