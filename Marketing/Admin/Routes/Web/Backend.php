<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/marketing/promotion/list.*$' => [
        [
            'dest' => '\Modules\Marketing\Controller:viewMarketingPromotionList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/marketing/promotion/create.*$' => [
        [
            'dest' => '\Modules\Marketing\Controller:viewMarketingPromotionCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/marketing/promotion/profile.*$' => [
        [
            'dest' => '\Modules\Marketing\Controller:viewMarketingPromotionProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/marketing/event/list.*$' => [
        [
            'dest' => '\Modules\Marketing\Controller:viewMarketingEventList', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/marketing/event/create.*$' => [
        [
            'dest' => '\Modules\Marketing\Controller:viewMarketingEventCreate', 
            'verb' => RouteVerb::GET,
        ],
    ],
    '^.*/backend/marketing/event/profile.*$' => [
        [
            'dest' => '\Modules\Marketing\Controller:viewMarketingEventProfile', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
