<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/reporter/template/create.*$' => [
        [
            'dest' => '\Modules\Media\Controller::setUpFileUploader',
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\Reporter\Controller:viewTemplateCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/reporter/report/create.*$' => [
        [
            'dest' => '\Modules\Media\Controller::setUpFileUploader',
            'verb' => RouteVerb::GET,
        ],
        [
            'dest' => '\Modules\Reporter\Controller:viewReportCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/reporter/list.*$' => [
        [
            'dest' => '\Modules\Reporter\Controller:viewTemplateList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/reporter/report/view.*$' => [
        [
            'dest' => '\Modules\Reporter\Controller:viewReporterReport', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
