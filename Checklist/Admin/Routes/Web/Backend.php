<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/checklist/list.*$' => [
        [
            'dest' => '\Modules\Checklist\Controller:viewChecklistList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/checklist/template/list.*$' => [
        [
            'dest' => '\Modules\Checklist\Controller:viewChecklistTemplateList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/checklist/template/create.*$' => [
        [
            'dest' => '\Modules\Checklist\Controller:viewChecklistTemplateCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/checklist/template/view.*$' => [
        [
            'dest' => '\Modules\Checklist\Controller:viewChecklistTemplateView', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
