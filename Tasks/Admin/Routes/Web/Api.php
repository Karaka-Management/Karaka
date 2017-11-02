<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/api/task(\?.*|$)' => [
        [
            'dest' => '\Modules\Tasks\Controller:apiTaskCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
    '^.*/api/task/element.*$' => [
        [
            'dest' => '\Modules\Tasks\Controller:apiTaskElementCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
];
