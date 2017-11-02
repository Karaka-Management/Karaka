<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/controlling/pl/dashboard.*$' => [
        [
            'dest' => '\Modules\PL\Controller:viewPLDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
