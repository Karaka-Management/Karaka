<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/news/dashboard.*$' => [
        [
            'dest' => '\Modules\News\Controller:viewNewsDashboard', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/news/article.*$' => [
        [
            'dest' => '\Modules\News\Controller:viewNewsArticle', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/news/archive.*$' => [
        [
            'dest' => '\Modules\News\Controller:viewNewsArchive', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/news/create.*$' => [
        [
            'dest' => '\Modules\Editor\Controller:setUpEditorEditor', 
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\News\Controller:viewNewsCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
