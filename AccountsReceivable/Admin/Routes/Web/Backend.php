<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/accounting/receivable/list.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/create.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/profile.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/outstanding.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorOutstanding', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/age.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorAge', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/receivable.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorPayable', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/dun/list.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorDunList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/dso/list.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewDebitorDsoList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/journal/list.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewJournalList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/entries.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewEntriesList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/receivable/analyze.*$' => [
        [
            'dest' => '\Modules\AccountsReceivable\Controller:viewAnalyzeDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
