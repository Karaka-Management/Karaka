<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/api/editor.*$' => [
        [
            'dest' => '\Modules\Editor\Controller:apiEditorCreate', 
            'verb' => RouteVerb::SET,
        ],
    ],
];
