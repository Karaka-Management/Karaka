<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/api/organization/position.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:apiPositionCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
    '^.*/api/organization/department.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:apiDepartmentCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
    '^.*/api/organization/unit.*$' => [
        [
            'dest' => '\Modules\Organization\Controller:apiUnitCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
];
