<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/purchase/supplier/list.*$' => [
        [
            'dest' => '\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/supplier/create.*$' => [
        [
            'dest' => '\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/supplier/profile.*$' => [
        [
            'dest' => '\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/supplier/analysis.*$' => [
        [
            'dest' => '\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierAnalysis', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
