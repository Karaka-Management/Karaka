<?php

use phpOMS\Router\RouteVerb;

return [
    '^.*/backend/accounting/asset/list.*$' => [
        [
            'dest' => '\Modules\AssetManagement\Controller:viewAssetManagementList', 
            'verb' => RouteVerb::GET,
        ],
    ],
];
