<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/riskmanagement/cockpit.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskCockpit', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/risk/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/risk/create.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/risk/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/cause/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskCauseList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/cause/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskCauseSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/solution/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskSolutionList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/solution/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskSolutionSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/unit/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskUnitList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/unit/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskUnitSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/department/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskDepartmentList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/department/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskDepartmentSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/category/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskCategoryList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/category/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskCategorySingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/project/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskProjectList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/project/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskProjectSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/process/list.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskProcessList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/process/single.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskProcessSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/riskmanagement/settings/dashboard.*$' => [
        [
            'dest' => '\Modules\RiskManagement\Controller:viewRiskSettings', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
