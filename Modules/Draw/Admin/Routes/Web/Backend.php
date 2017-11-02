<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/draw/create.*$' => [
        [
            'dest' => '\Modules\Draw\Controller:setUpDrawEditor', 
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\Draw\Controller:viewDrawCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/draw/list.*$' => [
        [
            'dest' => '\Modules\Draw\Controller:viewDrawList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/draw/single.*$' => [
        [
            'dest' => '\Modules\Draw\Controller:setUpDrawEditor', 
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\Draw\Controller:viewDrawSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
