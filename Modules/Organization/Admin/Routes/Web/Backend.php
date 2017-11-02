<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/organization/unit/list.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewUnitList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/unit/profile.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewUnitProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/unit/create.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewUnitCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/department/list.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewDepartmentList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/department/profile.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewDepartmentProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/department/create.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewDepartmentCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/position/list.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewPositionList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/position/profile.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewPositionProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/organization/position/create.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:viewPositionCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
