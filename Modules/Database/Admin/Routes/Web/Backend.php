<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/database/list.*$' => [
        [
            'dest' => '\Modules\Database\Controller:viewDatabaseList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/database/create.*$' => [
        [
            'dest' => '\Modules\Database\Controller:viewDatabaseCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/database/result.*$' => [
        [
            'dest' => '\Modules\Database\Controller:viewDatabaseResult', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/database/template.*$' => [
        [
            'dest' => '\Modules\Database\Controller:viewDatabaseTemplate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
