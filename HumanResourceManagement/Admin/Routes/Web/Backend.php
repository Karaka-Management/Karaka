<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/hr/staff/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrStaffList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/hr/staff/profile.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrStaffProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/hr/staff/create.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrStaffCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/hr/department/list.*$' => [
        [
            'dest' => '\Modules\HumanResourceManagement\Controller:viewHrDepartmentList', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
