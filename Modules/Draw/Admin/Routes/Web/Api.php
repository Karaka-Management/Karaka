<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/api/draw.*$' => [
        [
            'dest' => '\Modules\Draw\Controller:apiDrawCreate', 
            'verb' => RouteVerb::SET,
        ],
    ],
];
