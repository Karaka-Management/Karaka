<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/controlling/balance/dashboard.*$' => [
        [
            'dest' => '\Modules\Balance\Controller:viewBalanceDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
