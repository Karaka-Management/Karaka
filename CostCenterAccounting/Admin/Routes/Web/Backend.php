<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/accounting/costcenter/list.*$' => [
        [
            'dest' => '\Modules\CostCenterAccounting\Controller:viewCostCenterList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/costcenter/create.*$' => [
        [
            'dest' => '\Modules\CostCenterAccounting\Controller:viewCostCenterCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/costcenter/profile.*$' => [
        [
            'dest' => '\Modules\CostCenterAccounting\Controller:viewCostCenterProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
