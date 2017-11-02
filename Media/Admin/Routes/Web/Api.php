<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/api/media/collection.*$' => [
        [
            'dest' => '\Modules\Media\Controller:apiCollectionCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
    '^.*/api/media$' => [
        [
            'dest' => '\Modules\Media\Controller:apiMediaUpload',
            'verb' => RouteVerb::SET,
        ],
    ],
    '^.*/api/media/create.*$' => [
        [
            'dest' => '\Modules\Media\Controller:apiMediaCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
];
