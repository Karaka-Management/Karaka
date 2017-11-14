<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/help/general(\?.*)?$' => [
        [
            'dest' => '\Modules\Help\Controller:viewHelpGeneral', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/help/module/list(\?.*)?$' => [
        [
            'dest' => '\Modules\Help\Controller:viewHelpModuleList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/help/module/single(\?.*)?$' => [
        [
            'dest' => '\Modules\Help\Controller:viewHelpModule', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/help/developer(\?.*)?$' => [
        [
            'dest' => '\Modules\Help\Controller:viewHelpDeveloper', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
