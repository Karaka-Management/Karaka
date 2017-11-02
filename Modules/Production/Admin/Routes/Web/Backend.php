<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/production/list.*$' => [
        [
            'dest' => '\Modules\Production\Controller:viewProductionList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/production/create.*$' => [
        [
            'dest' => '\Modules\Production\Controller:viewProductionCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/production/process/list.*$' => [
        [
            'dest' => '\Modules\Production\Controller:viewProductionProcessList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/production/process/create.*$' => [
        [
            'dest' => '\Modules\Production\Controller:viewProductionProcessCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
