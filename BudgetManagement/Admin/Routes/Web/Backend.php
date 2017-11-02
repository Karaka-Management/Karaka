<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/controlling/budget/dashboard.*$' => [
        [
            'dest' => '\Modules\BudgetManagement\Controller:viewBudgetingDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
