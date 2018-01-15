<?php return[
    "^.*/api/admin/settings.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:apiSettingsSet",
    "verb" => 4,
]
,
    1 => [
    "dest" => "\Modules\Admin\Controller:apiSettingsGet",
    "verb" => 1,
]
,
]
,
    "^.*/api/admin/group.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:apiGroupCreate",
    "verb" => 2,
]
,
    1 => [
    "dest" => "\Modules\Admin\Controller:apiGroupUpdate",
    "verb" => 4,
]
,
    2 => [
    "dest" => "\Modules\Admin\Controller:apiGroupDelete",
    "verb" => 8,
]
,
    3 => [
    "dest" => "\Modules\Admin\Controller:apiGroupGet",
    "verb" => 1,
]
,
]
,
    "^.*/api/admin/find/account.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:apiAccountFind",
    "verb" => 1,
]
,
]
,
    "^.*/api/admin/account.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:apiAccountCreate",
    "verb" => 2,
]
,
    1 => [
    "dest" => "\Modules\Admin\Controller:apiAccountUpdate",
    "verb" => 4,
]
,
    2 => [
    "dest" => "\Modules\Admin\Controller:apiAccountDelete",
    "verb" => 8,
]
,
    3 => [
    "dest" => "\Modules\Admin\Controller:apiAccountGet",
    "verb" => 1,
]
,
]
,
    "^.*/api/admin/module/status.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:apiModuleStatusUpdate",
    "verb" => 4,
]
,
]
,
];