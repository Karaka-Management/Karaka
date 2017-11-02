<?php 
return [
    "^.*/backend/admin/settings/general.*$" => [
        0 => [
            "dest" => "\Modules\Admin\Controller:viewSettingsGeneral",
            "verb" => 1,
        ]
    ]
];