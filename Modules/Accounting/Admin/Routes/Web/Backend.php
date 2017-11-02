<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/accounting/personal/entries.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewPersonalEntries', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/impersonal/entries.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewImpersonalEntries', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/entries.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewEntries', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/impersonal/journal/list.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewJournalList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/stack/list.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewStackList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/stack/entries.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewStackEntries', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/stack/archive/list.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewStackArchiveList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/stack/create.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewStackCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/stack/predefined/list.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewStackPredefinedList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/gl/list.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewGLList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/gl/create.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewGLCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/accounting/gl/profile.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewGLProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/api/accounting/dun/print.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewCostCenterProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/api/accounting/statement/print.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewCostCenterProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/api/accounting/balances/print.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewCostCenterProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/api/accounting/accountform/print.*$' => [
        [
            'dest' => '\Modules\Accounting\Controller:viewCostCenterProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
