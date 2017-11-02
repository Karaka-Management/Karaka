<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/task/dashboard.*$' => [
        [
            'dest' => '\Modules\Tasks\Controller:viewTaskDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/task/single.*$' => [
        [
            'dest' => '\Modules\Tasks\Controller:viewTaskView', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/task/create.*$' => [
        [
            'dest' => '\Modules\Tasks\Controller:viewTaskCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/task/analysis.*$' => [
        [
            'dest' => '\Modules\Tasks\Controller:viewTaskAnalysis', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
