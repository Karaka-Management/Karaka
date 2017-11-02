<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/workflow/template/list.*$' => [
        [
            'dest' => '\Modules\Workflow\Controller:viewWorkflowTemplates',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/workflow/template/single.*$' => [
        [
            'dest' => '\Modules\Workflow\Controller:viewWorkflowTemplate',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/workflow/template/create.*$' => [
        [
            'dest' => '\Modules\Workflow\Controller:viewWorkflowTemplateCreate',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/workflow/dashboard.*$' => [
        [
            'dest' => '\Modules\Workflow\Controller:viewWorkflowDashboard',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/workflow/single.*$' => [
        [
            'dest' => '\Modules\Workflow\Controller:viewWorkflowSingle',
            'verb' => RouteVerb::GET,
        ],
    ],
];
