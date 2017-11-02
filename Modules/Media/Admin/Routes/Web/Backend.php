<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/media/list.*$' => [
        [
            'dest' => '\Modules\Media\Controller:viewMediaList',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/media/create.*$' => [
        [
            'dest' => '\Modules\Media\Controller:setUpFileUploader',
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\Media\Controller:viewMediaCreate',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/media/single.*$' => [
        [
            'dest' => '\Modules\Media\Controller:viewMediaSingle',
            'verb' => RouteVerb::GET,
        ],
    ],
];
