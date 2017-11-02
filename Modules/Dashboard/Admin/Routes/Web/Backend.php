<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend(\?.*)?$' => [
        [
            'dest' => '\Modules\Dashboard\Controller:viewDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
