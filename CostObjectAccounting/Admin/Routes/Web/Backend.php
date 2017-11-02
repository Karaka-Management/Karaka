<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/accounting/costobject/list.*$' => [
        [
            'dest' => '\Modules\CostObjectAccounting\Controller:viewCostObjectList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/costobject/create.*$' => [
        [
            'dest' => '\Modules\CostObjectAccounting\Controller:viewCostObjectCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/costobject/profile.*$' => [
        [
            'dest' => '\Modules\CostObjectAccounting\Controller:viewCostObjectProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
