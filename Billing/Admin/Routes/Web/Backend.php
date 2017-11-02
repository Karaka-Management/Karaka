<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/sales/invoice/create.*$' => [
        [
            'dest' => '\Modules\Billing\Controller:viewBillingInvoiceCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/sales/invoice/list.*$' => [
        [
            'dest' => '\Modules\Billing\Controller:viewBillingInvoiceList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/invoice/create.*$' => [
        [
            'dest' => '\Modules\Billing\Controller:viewBillingPurchaseInvoiceCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/purchase/invoice/list.*$' => [
        [
            'dest' => '\Modules\Billing\Controller:viewBillingPurchaInvoiceList', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
