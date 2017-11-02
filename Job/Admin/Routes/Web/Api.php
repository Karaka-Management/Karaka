<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/admin/job.*$' => [
        [
            'dest' => '\Modules\Job\Controller:apiJobCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
];
