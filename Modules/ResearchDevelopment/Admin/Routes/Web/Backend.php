<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/rnd/list.*$' => [
        [
            'dest' => '\Modules\ResearchDevelopment\Controller:viewProjectList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/rnd/create.*$' => [
        [
            'dest' => '\Modules\ResearchDevelopment\Controller:viewProjectCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
