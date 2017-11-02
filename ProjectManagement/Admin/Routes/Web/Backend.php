<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/projectmanagement/list.*$' => [
        [
            'dest' => '\Modules\ProjectManagement\Controller:viewProjectManagementList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/projectmanagement/create.*$' => [
        [
            'dest' => '\Modules\ProjectManagement\Controller:viewProjectManagementCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/projectmanagement/profile.*$' => [
        [
            'dest' => '\Modules\ProjectManagement\Controller:viewProjectManagementProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
