<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/chart/create($|\?.*)' => [
        [
            'dest' => '\Modules\Chart\Controller:viewChartCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/chart/create/line.*$' => [
        [
            'dest' => '\Modules\Chart\Controller:setUpChartEditor', 
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\Chart\Controller:viewChartCreateLine', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/chart/list.*$' => [
        [
            'dest' => '\Modules\Chart\Controller:viewChartList', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
