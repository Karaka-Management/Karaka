<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/sales/item/list.*$' => [
        [
            'dest' => '\Modules\ItemManagement\Controller:viewItemManagementSalesList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/item/list.*$' => [
        [
            'dest' => '\Modules\ItemManagement\Controller:viewItemManagementPurchaseList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/warehouse/stock/list.*$' => [
        [
            'dest' => '\Modules\ItemManagement\Controller:viewItemManagementWarehousingList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/sales/item/create.*$' => [
        [
            'dest' => '\Modules\ItemManagement\Controller:viewItemManagementSalesCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/item/create.*$' => [
        [
            'dest' => '\Modules\ItemManagement\Controller:viewItemManagementPurchaseCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '.*/backend/warehouse/stock/create.*$' => [
        [
            'dest' => '\Modules\ItemManagement\Controller:viewItemManagementWarehousingCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
