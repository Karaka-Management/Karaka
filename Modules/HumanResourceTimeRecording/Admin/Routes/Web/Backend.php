<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/hr/timerecording/dashboard.*$' => [
        [
            'dest' => '\Modules\HumanResourceTimeRecording\Controller:viewDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
