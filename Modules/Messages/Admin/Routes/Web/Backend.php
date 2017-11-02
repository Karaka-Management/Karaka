<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/messages/dashboard.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageInbox', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/messages/outbox.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageOutbox', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/messages/trash.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageTrash', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/messages/spam.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageSpam', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/messages/settings.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageSettings', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/messages/mail/create.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/messages/mail/single.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageView', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/api/messages/mail/single.*$' => [
        [
            'dest' => '\Modules\Messages\Controller:viewMessageView', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
