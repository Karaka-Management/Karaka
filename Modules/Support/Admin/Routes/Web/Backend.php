<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/support/list.*$' => [
        [
            'dest' => '\Modules\Support\Controller:viewSupportList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/support/single.*$' => [
        [
            'dest' => '\Modules\Support\Controller:viewSupportTicket', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/support/create.*$' => [
        [
            'dest' => '\Modules\Support\Controller:viewSupportCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/support/analysis.*$' => [
        [
            'dest' => '\Modules\Support\Controller:viewSupportAnalysis', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/support/settings.*$' => [
        [
            'dest' => '\Modules\Support\Controller:viewSupportSettings', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/private/support/dashboard.*$' => [
        [
            'dest' => '\Modules\Support\Controller:viewPrivateSupportDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
