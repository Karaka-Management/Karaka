<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/warehouse/stocktaking/list.*$' => [
        [
            'dest' => '\Modules\StockTaking\Controller:viewStockTakingList', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
