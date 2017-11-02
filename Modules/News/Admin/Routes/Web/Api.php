<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/api/news.*$' => [
        [
            'dest' => '\Modules\News\Controller:apiNewsCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
];
