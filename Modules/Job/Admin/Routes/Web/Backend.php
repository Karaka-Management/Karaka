<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/admin/job/list.*$' => [
        [
            'dest' => '\Modules\Job\Controller:viewJobList',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/job/single.*$' => [
        [
            'dest' => '\Modules\Job\Controller:viewJob',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/admin/job/create.*$' => [
        [
            'dest' => '\Modules\Job\Controller:viewJobCreate',
            'verb' => RouteVerb::GET,
        ],
    ],
];
