<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/warehouse/stock/arrival/list.*$' => [
        [
            'dest' => '\Modules\Arrival\Controller:viewArrivalList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/warehouse/stock/arrival/create.*$' => [
        [
            'dest' => '\Modules\Arrival\Controller:viewArrivalCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
