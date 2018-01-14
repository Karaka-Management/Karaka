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
    "^.*/api/media/collection.*$" => [
    0 => [
    "dest" => "\Modules\Media\Controller:apiCollectionCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/media$" => [
    0 => [
    "dest" => "\Modules\Media\Controller:apiMediaUpload",
    "verb" => 4,
]
,
]
,
    "^.*/api/media/create.*$" => [
    0 => [
    "dest" => "\Modules\Media\Controller:apiMediaCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/task(\?.*|$)" => [
    0 => [
    "dest" => "\Modules\Tasks\Controller:apiTaskCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/task/element.*$" => [
    0 => [
    "dest" => "\Modules\Tasks\Controller:apiTaskElementCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/editor.*$" => [
    0 => [
    "dest" => "\Modules\Editor\Controller:apiEditorCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/draw.*$" => [
    0 => [
    "dest" => "\Modules\Draw\Controller:apiDrawCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/organization/position.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:apiPositionCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/organization/department.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:apiDepartmentCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/organization/unit.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:apiUnitCreate",
    "verb" => 4,
]
,
]
,
    "^.*/backend/admin/job.*$" => [
    0 => [
    "dest" => "\Modules\Job\Controller:apiJobCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/news.*$" => [
    0 => [
    "dest" => "\Modules\News\Controller:apiNewsCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/reporter/report/export.*$" => [
    0 => [
    "dest" => "\Modules\Reporter\Controller:apiReporterExport",
    "verb" => 1,
]
,
]
,
    "^.*/api/reporter/report/template.*$" => [
    0 => [
    "dest" => "\Modules\Reporter\Controller:apiTemplateCreate",
    "verb" => 4,
]
,
]
,
    "^.*/api/reporter/report/report.*$" => [
    0 => [
    "dest" => "\Modules\Reporter\Controller:apiReportCreate",
    "verb" => 4,
]
,
]
,
];