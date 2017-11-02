<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/api/reporter/report/export.*$' => [
        [
            'dest' => '\Modules\Reporter\Controller:apiReporterExport',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/api/reporter/report/template.*$' => [
        [
            'dest' => '\Modules\Reporter\Controller:apiTemplateCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
    '^.*/api/reporter/report/report.*$' => [
        [
            'dest' => '\Modules\Reporter\Controller:apiReportCreate',
            'verb' => RouteVerb::SET,
        ],
    ],
];
