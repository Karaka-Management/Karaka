<?php return [
    '^.*/admin/settings.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiSettingsSet',
            'verb' => 4,
            'permission' => [
                'module' => 'Admin',
                'type' => 8,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiSettingsGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/group$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 3,
            ],
        ],
        1 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Admin',
                'type' => 8,
                'state' => 3,
            ],
        ],
        2 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Admin',
                'type' => 16,
                'state' => 3,
            ],
        ],
        3 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 3,
            ],
        ],
    ],
    '^.*/admin/find/account.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountFind',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/admin/find/group.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupFind',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/admin/find/accgrp.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountGroupFind',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/admin/account$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 2,
            ],
        ],
        1 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Admin',
                'type' => 8,
                'state' => 2,
            ],
        ],
        2 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Admin',
                'type' => 16,
                'state' => 2,
            ],
        ],
        3 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/admin/module/status.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiModuleStatusUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Admin',
                'type' => 8,
                'state' => 4,
            ],
        ],
    ],
    '^.*/admin/group/account.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAddAccountToGroup',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 8,
                'state' => 4,
            ],
        ],
    ],
    '^.*/admin/account/group.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAddGroupToAccount',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 8,
                'state' => 4,
            ],
        ],
    ],
    '^.*/admin/group/permission.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupPermissionGet',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
        1 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAddGroupPermission',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
        2 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupPermissionUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
        3 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiGroupPermissionDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
    ],
    '^.*/admin/account/permission.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountPermissionGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
        1 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAddAccountPermission',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
        2 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountPermissionUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
        3 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiAccountPermissionDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Admin',
                'type' => 32,
                'state' => 4,
            ],
        ],
    ],
    '^.*/admin/module/reinit.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiReInit',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 6,
            ],
        ],
    ],
    '^.*/admin/update/url.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiUpdateFile',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 7,
            ],
        ],
    ],
    '^.*/admin/update/check.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiCheckForUpdates',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 7,
            ],
        ],
    ],
    '^.*/admin/update/component.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\ApiController:apiCheckForUpdates',
            'verb' => 2,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 7,
            ],
        ],
    ],
    '^.*/tag.*$' => [
        0 => [
            'dest' => '\Modules\Tag\Controller\ApiController:apiTagCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Tag',
                'type' => 4,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Tag\Controller\ApiController:apiTagUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Tag',
                'type' => 8,
                'state' => 1,
            ],
        ],
        2 => [
            'dest' => '\Modules\Tag\Controller\ApiController:apiTagDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Tag',
                'type' => 16,
                'state' => 1,
            ],
        ],
    ],
    '^.*/editor.*$' => [
        0 => [
            'dest' => '\Modules\Editor\Controller\ApiController:apiEditorCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Editor',
                'type' => 4,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Editor\Controller\ApiController:apiEditorUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Editor',
                'type' => 8,
                'state' => 1,
            ],
        ],
        2 => [
            'dest' => '\Modules\Editor\Controller\ApiController:apiEditorGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Editor',
                'type' => 2,
                'state' => 1,
            ],
        ],
        3 => [
            'dest' => '\Modules\Editor\Controller\ApiController:apiEditorDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Editor',
                'type' => 16,
                'state' => 1,
            ],
        ],
    ],
    '^.*/organization/position.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiPositionCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 3,
            ],
        ],
        1 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiPositionGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 3,
            ],
        ],
        2 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiPositionSet',
            'verb' => 4,
            'permission' => [
                'module' => 'Organization',
                'type' => 8,
                'state' => 3,
            ],
        ],
        3 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiPositionDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Organization',
                'type' => 16,
                'state' => 3,
            ],
        ],
    ],
    '^.*/organization/department.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiDepartmentCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 2,
            ],
        ],
        1 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiDepartmentGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 2,
            ],
        ],
        2 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiDepartmentSet',
            'verb' => 4,
            'permission' => [
                'module' => 'Organization',
                'type' => 8,
                'state' => 2,
            ],
        ],
        3 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiDepartmentDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Organization',
                'type' => 16,
                'state' => 2,
            ],
        ],
    ],
    '^.*/organization/unit.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiUnitCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiUnitGet',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 1,
            ],
        ],
        2 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiUnitSet',
            'verb' => 4,
            'permission' => [
                'module' => 'Organization',
                'type' => 8,
                'state' => 1,
            ],
        ],
        3 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiUnitDelete',
            'verb' => 8,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/organization/find/unit.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiUnitFind',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/organization/find/department.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiDepartmentFind',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/organization/find/position.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\ApiController:apiPositionFind',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 3,
            ],
        ],
    ],
    '^.*/media(\?+.*|$)' => [
        0 => [
            'dest' => '\Modules\Media\Controller\ApiController:apiMediaUpload',
            'verb' => 2,
            'permission' => [
                'module' => 'Media',
                'type' => 4,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Media\Controller\ApiController:apiMediaUpdate',
            'verb' => 4,
            'permission' => [
                'module' => 'Media',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/media/find.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\ApiController:apiMediaFind',
            'verb' => 1,
            'permission' => [
                'module' => 'Media',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/profile.*$' => [
        0 => [
            'dest' => '\Modules\Profile\Controller\ApiController:apiProfileCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Profile',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/helper/report/export.*$' => [
        0 => [
            'dest' => '\Modules\Helper\Controller\ApiController:apiHelperExport',
            'verb' => 1,
            'permission' => [
                'module' => 'Helper',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/helper/report/template.*$' => [
        0 => [
            'dest' => '\Modules\Helper\Controller\ApiController:apiTemplateCreate',
            'verb' => 4,
            'permission' => [
                'module' => 'Helper',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/helper/report/report.*$' => [
        0 => [
            'dest' => '\Modules\Helper\Controller\ApiController:apiReportCreate',
            'verb' => 4,
            'permission' => [
                'module' => 'Helper',
                'type' => 4,
                'state' => 2,
            ],
        ],
    ],
    '^.*/search(\?.*|$)' => [
        0 => [
            'dest' => '\Modules\Search\Controller\ApiController:routeSearch',
            'verb' => 16,
            'permission' => [
                'module' => 'Search',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/dashboard/board(\?.*|$)' => [
        0 => [
            'dest' => '\Modules\Dashboard\Controller\ApiController:apiBoardCreate',
            'verb' => 2,
            'permission' => [
                'module' => 'Dashboard',
                'type' => 4,
                'state' => 2,
            ],
        ],
    ],
    '^.*/dashboard/board/component(\?.*|$)' => [
        0 => [
            'dest' => '\Modules\Dashboard\Controller\ApiController:apiComponentAdd',
            'verb' => 2,
            'permission' => [
                'module' => 'Dashboard',
                'type' => 4,
                'state' => 3,
            ],
        ],
    ],
];