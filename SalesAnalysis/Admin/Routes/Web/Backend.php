<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/sales/analysis/dashboard.*$' => [
        [
            'dest' => '\Modules\SalesAnalysis\Controller:viewBackendDashboard',
            'verb' => RouteVerb::GET,
        ],
    ],

    '^.*/backend/sales/analysis/overview/dashboard.*$' => [
        [
            'dest' => '\Modules\SalesAnalysis\Controller:viewBackendOverviewDashboard',
            'verb' => RouteVerb::GET,
        ],
    ],
];
