<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/survey/list.*$' => [
        [
            'dest' => '\Modules\Surveys\Controller:viewSurveysList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/survey/create.*$' => [
        [
            'dest' => '\Modules\Surveys\Controller:viewSurveysCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/survey/profile.*$' => [
        [
            'dest' => '\Modules\Surveys\Controller:viewSurveysProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
