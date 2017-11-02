<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/editor/create.*$' => [
        [
            'dest' => '\Modules\Editor\Controller:setUpEditorEditor', 
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\Editor\Controller:viewEditorCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/editor/list.*$' => [
        [
            'dest' => '\Modules\Editor\Controller:viewEditorList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/editor/single.*$' => [
        [
            'dest' => '\Modules\Editor\Controller:viewEditorSingle', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
