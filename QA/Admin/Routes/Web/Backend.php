<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/qa.*$' => [
        [
            'dest' => '\Modules\QA\Controller:setUpBackend',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/qa/dashboard.*$' => [
        [
            'dest' => '\Modules\QA\Controller:viewQADashboard',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/qa/badge/list.*$' => [
        [
            'dest' => '\Modules\QA\Controller:viewQABadgeList',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/qa/badge/single.*$' => [
        [
            'dest' => '\Modules\QA\Controller:viewQABadgeEdit',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/qa/question.*$' => [
        [
            'dest' => '\Modules\QA\Controller:viewQADoc',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/qa/question/create.*$' => [
        [
            'dest' => '\Modules\QA\Controller:viewQAQuestionCreate',
            'verb' => RouteVerb::GET,
        ],
    ],
];
