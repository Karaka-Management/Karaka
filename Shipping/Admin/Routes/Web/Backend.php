<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/warehouse/shipping/list.*$' => [
        [
            'dest' => '\Modules\Shipping\Controller:viewShippingList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/warehouse/shipping/create.*$' => [
        [
            'dest' => '\Modules\Shipping\Controller:viewShippingCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
