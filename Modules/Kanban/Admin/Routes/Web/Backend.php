<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/kanban.*$' => [
        [
            'dest' => '\Modules\Kanban\Controller:setupStyles',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/kanban/dashboard.*$' => [
        [
            'dest' => '\Modules\Kanban\Controller:viewKanbanDashboard',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/kanban/archive.*$' => [
        [
            'dest' => '\Modules\Kanban\Controller:viewKanbanArchive',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/kanban/board.*$' => [
        [
            'dest' => '\Modules\Kanban\Controller:viewKanbanBoard',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/kanban/card.*$' => [
        [
            'dest' => '\Modules\Kanban\Controller:viewKanbanCard',
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/kanban/create.*$' => [
        [
            'dest' => '\Modules\Kanban\Controller:viewKanbanBoardCreate',
            'verb' => RouteVerb::GET,
        ],
    ],
];
