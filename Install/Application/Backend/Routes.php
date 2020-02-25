<?php return [
    '^.*/admin/settings/general.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewSettingsGeneral',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/account/list.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewAccountList',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/admin/account/settings.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewAccountSettings',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/admin/account/create.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewAccountCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 2,
            ],
        ],
    ],
    '^.*/admin/group/list.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewGroupList',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 3,
            ],
        ],
    ],
    '^.*/admin/group/settings.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewGroupSettings',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 8,
                'state' => 3,
            ],
        ],
    ],
    '^.*/admin/group/create.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewGroupCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 4,
                'state' => 3,
            ],
        ],
    ],
    '^.*/admin/module/list.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewModuleList',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 4,
            ],
        ],
    ],
    '^.*/admin/module/settings\?.*$' => [
        0 => [
            'dest' => '\Modules\Admin\Controller\BackendController:viewModuleProfile',
            'verb' => 1,
            'permission' => [
                'module' => 'Admin',
                'type' => 2,
                'state' => 4,
            ],
        ],
    ],
    '^.*/admin/audit/list.*$' => [
        0 => [
            'dest' => '\Modules\Auditor\Controller\BackendController:viewAuditorList',
            'verb' => 1,
            'permission' => [
                'module' => 'Auditor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/audit/single.*$' => [
        0 => [
            'dest' => '\Modules\Auditor\Controller\BackendController:viewAuditorSingle',
            'verb' => 1,
            'permission' => [
                'module' => 'Auditor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/audit/module/list.*$' => [
        0 => [
            'dest' => '\Modules\Auditor\Controller\BackendController:viewAuditorModuleList',
            'verb' => 1,
            'permission' => [
                'module' => 'Auditor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/audit/module/single.*$' => [
        0 => [
            'dest' => '\Modules\Auditor\Controller\BackendController:viewAuditorModuleSingle',
            'verb' => 1,
            'permission' => [
                'module' => 'Auditor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/audit/account/list.*$' => [
        0 => [
            'dest' => '\Modules\Auditor\Controller\BackendController:viewAuditorAccountList',
            'verb' => 1,
            'permission' => [
                'module' => 'Auditor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/audit/account/single.*$' => [
        0 => [
            'dest' => '\Modules\Auditor\Controller\BackendController:viewAuditorAccountSingle',
            'verb' => 1,
            'permission' => [
                'module' => 'Auditor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/editor/create.*$' => [
        0 => [
            'dest' => '\Modules\Editor\Controller\BackendController:setUpEditorEditor',
            'verb' => 1,
            'permission' => [
                'module' => 'Editor',
                'type' => 4,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Editor\Controller\BackendController:viewEditorCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Editor',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/editor/list.*$' => [
        0 => [
            'dest' => '\Modules\Editor\Controller\BackendController:viewEditorList',
            'verb' => 1,
            'permission' => [
                'module' => 'Editor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/editor/single.*$' => [
        0 => [
            'dest' => '\Modules\Editor\Controller\BackendController:viewEditorSingle',
            'verb' => 1,
            'permission' => [
                'module' => 'Editor',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/organization/organigram.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewOrganigram',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 4,
            ],
        ],
    ],
    '^.*/organization/unit/list.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewUnitList',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/organization/unit/profile.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewUnitProfile',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/organization/unit/create.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController::setUpFileUploader',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewUnitCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/organization/department/list.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewDepartmentList',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/organization/department/profile.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewDepartmentProfile',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/organization/department/create.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewDepartmentCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 2,
            ],
        ],
    ],
    '^.*/organization/position/list.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewPositionList',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 3,
            ],
        ],
    ],
    '^.*/organization/position/profile.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewPositionProfile',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 2,
                'state' => 3,
            ],
        ],
    ],
    '^.*/organization/position/create.*$' => [
        0 => [
            'dest' => '\Modules\Organization\Controller\BackendController:viewPositionCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Organization',
                'type' => 4,
                'state' => 3,
            ],
        ],
    ],
    '^.*/help/general(\?.*)?$' => [
        0 => [
            'dest' => '\Modules\Help\Controller\BackendController:viewHelpGeneral',
            'verb' => 1,
            'permission' => [
                'module' => 'Help',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/help/module/list(\?.*)?$' => [
        0 => [
            'dest' => '\Modules\Help\Controller\BackendController:viewHelpModuleList',
            'verb' => 1,
            'permission' => [
                'module' => 'Help',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/help/module/single(\?.*)?$' => [
        0 => [
            'dest' => '\Modules\Help\Controller\BackendController:viewHelpModule',
            'verb' => 1,
            'permission' => [
                'module' => 'Help',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/help/developer(\?.*)?$' => [
        0 => [
            'dest' => '\Modules\Help\Controller\BackendController:viewHelpDeveloper',
            'verb' => 1,
            'permission' => [
                'module' => 'Help',
                'type' => 2,
                'state' => 3,
            ],
        ],
    ],
    '^.*/media/list.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController:viewMediaList',
            'verb' => 1,
            'permission' => [
                'module' => 'Media',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/media/upload.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController:viewMediaUpload',
            'verb' => 1,
            'permission' => [
                'module' => 'Media',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/media/file/create.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController:viewMediaFileCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Media',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/media/collection/create.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController:viewMediaCollectionCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Media',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/media/single.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController:viewMediaSingle',
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
            'dest' => '\Modules\Profile\Controller\BackendController:setupProfileStyles',
            'verb' => 1,
            'permission' => [
                'module' => 'Profile',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/profile/list.*$' => [
        0 => [
            'dest' => '\Modules\Profile\Controller\BackendController:viewProfileList',
            'verb' => 1,
            'permission' => [
                'module' => 'Profile',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/profile/single.*$' => [
        0 => [
            'dest' => '\Modules\Profile\Controller\BackendController:viewProfileSingle',
            'verb' => 1,
            'permission' => [
                'module' => 'Profile',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/module/settings/profile/settings.*$' => [
        0 => [
            'dest' => '\Modules\Profile\Controller\BackendController:viewProfileAdminSettings',
            'verb' => 1,
            'permission' => [
                'module' => 'Profile',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/admin/module/settings/profile/create.*$' => [
        0 => [
            'dest' => '\Modules\Profile\Controller\BackendController:viewProfileAdminCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Profile',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/helper/template/create.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController::setUpFileUploader',
            'verb' => 1,
            'permission' => [
                'module' => 'Helper',
                'type' => 4,
                'state' => 1,
            ],
        ],
        1 => [
            'dest' => '\Modules\Helper\Controller\BackendController:viewTemplateCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Helper',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/helper/report/create.*$' => [
        0 => [
            'dest' => '\Modules\Media\Controller\BackendController::setUpFileUploader',
            'verb' => 1,
            'permission' => [
                'module' => 'Helper',
                'type' => 4,
                'state' => 2,
            ],
        ],
        1 => [
            'dest' => '\Modules\Helper\Controller\BackendController:viewReportCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Helper',
                'type' => 4,
                'state' => 2,
            ],
        ],
    ],
    '^.*/helper/list.*$' => [
        0 => [
            'dest' => '\Modules\Helper\Controller\BackendController:viewTemplateList',
            'verb' => 1,
            'permission' => [
                'module' => 'Helper',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/helper/report/view.*$' => [
        0 => [
            'dest' => '\Modules\Helper\Controller\BackendController:viewHelperReport',
            'verb' => 1,
            'permission' => [
                'module' => 'Helper',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^(\/)(\?.*)*$' => [
        0 => [
            'dest' => '\Modules\Dashboard\Controller\BackendController:viewDashboard',
            'verb' => 1,
            'permission' => [
                'module' => 'Dashboard',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/wiki.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:setUpBackend',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/wiki/dashboard.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:viewKnowledgebaseDashboard',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/wiki/category/list.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:viewKnowledgebaseCategoryList',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/wiki/category/single.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:viewKnowledgebaseCategory',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 2,
                'state' => 1,
            ],
        ],
    ],
    '^.*/wiki/category/create.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:viewKnowledgebaseCategoryCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 4,
                'state' => 1,
            ],
        ],
    ],
    '^.*/wiki/doc/single.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:viewKnowledgebaseDoc',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
    '^.*/wiki/doc/create.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:viewKnowledgebaseDocCreate',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 4,
                'state' => 2,
            ],
        ],
    ],
    '^.*/wiki/doc/list.*$' => [
        0 => [
            'dest' => '\Modules\Knowledgebase\Controller\BackendController:viewKnowledgebaseDocList',
            'verb' => 1,
            'permission' => [
                'module' => 'Knowledgebase',
                'type' => 2,
                'state' => 2,
            ],
        ],
    ],
];