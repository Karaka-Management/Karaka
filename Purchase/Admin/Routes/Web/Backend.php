<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/purchase/invoice/create.*$' => [
        [
            'dest' => '\Modules\Purchase\Controller:viewPurchaseInvoiceCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/invoice/list.*$' => [
        [
            'dest' => '\Modules\Purchase\Controller:viewPurchaseInvoiceList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/article/list.*$' => [
        [
            'dest' => '\Modules\Purchase\Controller:viewPurchaseArticleList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/article/recommend.*$' => [
        [
            'dest' => '\Modules\Purchase\Controller:viewPurchaseOrderRecommendation', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/article/create.*$' => [
        [
            'dest' => '\Modules\Purchase\Controller:viewPurchaseArticleCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/article/profile.*$' => [
        [
            'dest' => '\Modules\Purchase\Controller:viewPurchaseArticleProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
