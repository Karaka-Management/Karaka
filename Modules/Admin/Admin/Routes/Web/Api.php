<?php

use phpOMS\Router\RouteVerb;

return [

    '^.*/api/admin/settings.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:apiSettingsSet',
            'verb' => RouteVerb::SET,
        ],
        [
            'dest' => '\Modules\Admin\Controller:apiSettingsGet',
            'verb' => RouteVerb::GET,
        ],
    ],

    '^.*/api/admin/group.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:apiGroupCreate',
            'verb' => RouteVerb::PUT,
        ],
        [
            'dest' => '\Modules\Admin\Controller:apiGroupUpdate',
            'verb' => RouteVerb::SET,
        ],
        [
            'dest' => '\Modules\Admin\Controller:apiGroupDelete',
            'verb' => RouteVerb::DELETE,
        ],
        [
            'dest' => '\Modules\Admin\Controller:apiGroupGet',
            'verb' => RouteVerb::GET,
        ],
    ],

    // todo: the order of find and account is bad but needed for now. otherwise the admin/account.* also matches and we match two routes = bad
    '^.*/api/admin/find/account.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:apiAccountFind',
            'verb' => RouteVerb::GET,
        ],
    ],

    '^.*/api/admin/account.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:apiAccountCreate',
            'verb' => RouteVerb::PUT,
        ],
        [
            'dest' => '\Modules\Admin\Controller:apiAccountUpdate',
            'verb' => RouteVerb::SET,
        ],
        [
            'dest' => '\Modules\Admin\Controller:apiAccountDelete',
            'verb' => RouteVerb::DELETE,
        ],
        [
            'dest' => '\Modules\Admin\Controller:apiAccountGet',
            'verb' => RouteVerb::GET,
        ],
    ],

    '^.*/api/admin/module/status.*$' => [
        [
            'dest' => '\Modules\Admin\Controller:apiModuleStatusUpdate',
            'verb' => RouteVerb::SET,
        ],
    ],
];
