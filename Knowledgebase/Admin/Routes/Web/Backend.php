<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/wiki.*$' => [
        [
            'dest' => '\Modules\Knowledgebase\Controller:setUpBackend',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/wiki/dashboard.*$' => [
        [
            'dest' => '\Modules\Knowledgebase\Controller:viewKnowledgebaseDashboard',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/wiki/category/list.*$' => [
        [
            'dest' => '\Modules\Knowledgebase\Controller:viewKnowledgebaseCategoryList',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/wiki/category/single.*$' => [
        [
            'dest' => '\Modules\Knowledgebase\Controller:viewKnowledgebaseCategory',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/wiki/category/create.*$' => [
        [
            'dest' => '\Modules\Knowledgebase\Controller:viewKnowledgebaseCategoryCreate',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/wiki/doc/single.*$' => [
        [
            'dest' => '\Modules\Knowledgebase\Controller:viewKnowledgebaseDoc',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/wiki/doc/create.*$' => [
        [
            'dest' => '\Modules\Knowledgebase\Controller:viewKnowledgebaseDocCreate',
            'verb' => RouteVerb::GET,
        ],
    ],
];
