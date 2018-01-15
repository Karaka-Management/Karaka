<?php return[
    "^.*/backend/admin/settings/general.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewSettingsGeneral",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/account/list.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewAccountList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/account/settings.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewAccountSettings",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/account/create.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewAccountCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/group/list.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewGroupList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/group/settings.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewGroupSettings",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/group/create.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewGroupCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/module/list.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewModuleList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/module/settings.*$" => [
    0 => [
    "dest" => "\Modules\Admin\Controller:viewModuleProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/personal/entries.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewPersonalEntries",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/impersonal/entries.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewImpersonalEntries",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/entries.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewEntries",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/impersonal/journal/list.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewJournalList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/stack/list.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewStackList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/stack/entries.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewStackEntries",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/stack/archive/list.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewStackArchiveList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/stack/create.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewStackCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/stack/predefined/list.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewStackPredefinedList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/gl/list.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewGLList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/gl/create.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewGLCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/gl/profile.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewGLProfile",
    "verb" => 1,
]
,
]
,
    "^.*/api/accounting/dun/print.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewCostCenterProfile",
    "verb" => 1,
]
,
]
,
    "^.*/api/accounting/statement/print.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewCostCenterProfile",
    "verb" => 1,
]
,
]
,
    "^.*/api/accounting/balances/print.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewCostCenterProfile",
    "verb" => 1,
]
,
]
,
    "^.*/api/accounting/accountform/print.*$" => [
    0 => [
    "dest" => "\Modules\Accounting\Controller:viewCostCenterProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/list.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewCreditorList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/create.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewCreditorCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/profile.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewCreditorProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/outstanding.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewCreditorOutstanding",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/age.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewCreditorAge",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/payable.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewCreditorPayable",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/journal/list.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewJournalList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/entries.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewEntriesList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/payable/analyze.*$" => [
    0 => [
    "dest" => "\Modules\AccountsPayable\Controller:viewAnalyzeDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/list.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/create.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/profile.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/outstanding.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorOutstanding",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/age.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorAge",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/receivable.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorPayable",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/dun/list.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorDunList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/dso/list.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewDebitorDsoList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/journal/list.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewJournalList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/entries.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewEntriesList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/receivable/analyze.*$" => [
    0 => [
    "dest" => "\Modules\AccountsReceivable\Controller:viewAnalyzeDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/warehouse/stock/arrival/list.*$" => [
    0 => [
    "dest" => "\Modules\Arrival\Controller:viewArrivalList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/warehouse/stock/arrival/create.*$" => [
    0 => [
    "dest" => "\Modules\Arrival\Controller:viewArrivalCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/asset/list.*$" => [
    0 => [
    "dest" => "\Modules\AssetManagement\Controller:viewAssetManagementList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/audit/list.*$" => [
    0 => [
    "dest" => "\Modules\Auditor\Controller:viewAuditorList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/audit/single.*$" => [
    0 => [
    "dest" => "\Modules\Auditor\Controller:viewAuditorSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/audit/module/list.*$" => [
    0 => [
    "dest" => "\Modules\Auditor\Controller:viewAuditorModuleList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/audit/module/single.*$" => [
    0 => [
    "dest" => "\Modules\Auditor\Controller:viewAuditorModuleSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/audit/account/list.*$" => [
    0 => [
    "dest" => "\Modules\Auditor\Controller:viewAuditorAccountList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/audit/account/single.*$" => [
    0 => [
    "dest" => "\Modules\Auditor\Controller:viewAuditorAccountSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/controlling/balance/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Balance\Controller:viewBalanceDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/calendar/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Calendar\Controller:viewCalendarDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/media/list.*$" => [
    0 => [
    "dest" => "\Modules\Media\Controller:viewMediaList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/media/create.*$" => [
    0 => [
    "dest" => "\Modules\Media\Controller:setUpFileUploader",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Media\Controller:viewMediaCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/media/single.*$" => [
    0 => [
    "dest" => "\Modules\Media\Controller:viewMediaSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/profile.*$" => [
    0 => [
    "dest" => "\Modules\Profile\Controller:setupProfileStyles",
    "verb" => 1,
]
,
]
,
    "^.*/backend/profile/list.*$" => [
    0 => [
    "dest" => "\Modules\Profile\Controller:viewProfileList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/profile/single.*$" => [
    0 => [
    "dest" => "\Modules\Profile\Controller:viewProfileSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/client/list.*$" => [
    0 => [
    "dest" => "\Modules\ClientManagement\Controller:viewClientManagementClientList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/client/create.*$" => [
    0 => [
    "dest" => "\Modules\ClientManagement\Controller:viewClientManagementClientCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/client/profile.*$" => [
    0 => [
    "dest" => "\Modules\ClientManagement\Controller:viewClientManagementClientProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/client/analysis.*$" => [
    0 => [
    "dest" => "\Modules\ClientManagement\Controller:viewClientManagementClientAnalysis",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/invoice/create.*$" => [
    0 => [
    "dest" => "\Modules\Billing\Controller:viewBillingInvoiceCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/invoice/list.*$" => [
    0 => [
    "dest" => "\Modules\Billing\Controller:viewBillingInvoiceList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/invoice/create.*$" => [
    0 => [
    "dest" => "\Modules\Billing\Controller:viewBillingPurchaseInvoiceCreate",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Purchase\Controller:viewPurchaseInvoiceCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/invoice/list.*$" => [
    0 => [
    "dest" => "\Modules\Billing\Controller:viewBillingPurchaInvoiceList",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Purchase\Controller:viewPurchaseInvoiceList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/controlling/budget/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\BudgetManagement\Controller:viewBudgetingDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/chart/create($|\?.*)" => [
    0 => [
    "dest" => "\Modules\Chart\Controller:viewChartCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/chart/create/line.*$" => [
    0 => [
    "dest" => "\Modules\Chart\Controller:setUpChartEditor",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Chart\Controller:viewChartCreateLine",
    "verb" => 1,
]
,
]
,
    "^.*/backend/chart/list.*$" => [
    0 => [
    "dest" => "\Modules\Chart\Controller:viewChartList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/task/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Tasks\Controller:viewTaskDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/task/single.*$" => [
    0 => [
    "dest" => "\Modules\Tasks\Controller:viewTaskView",
    "verb" => 1,
]
,
]
,
    "^.*/backend/task/create.*$" => [
    0 => [
    "dest" => "\Modules\Tasks\Controller:viewTaskCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/task/analysis.*$" => [
    0 => [
    "dest" => "\Modules\Tasks\Controller:viewTaskAnalysis",
    "verb" => 1,
]
,
]
,
    "^.*/backend/checklist/list.*$" => [
    0 => [
    "dest" => "\Modules\Checklist\Controller:viewChecklistList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/checklist/template/list.*$" => [
    0 => [
    "dest" => "\Modules\Checklist\Controller:viewChecklistTemplateList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/checklist/template/create.*$" => [
    0 => [
    "dest" => "\Modules\Checklist\Controller:viewChecklistTemplateCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/checklist/template/view.*$" => [
    0 => [
    "dest" => "\Modules\Checklist\Controller:viewChecklistTemplateView",
    "verb" => 1,
]
,
]
,
    "^.*/backend/editor/create.*$" => [
    0 => [
    "dest" => "\Modules\Editor\Controller:setUpEditorEditor",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Editor\Controller:viewEditorCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/editor/list.*$" => [
    0 => [
    "dest" => "\Modules\Editor\Controller:viewEditorList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/editor/single.*$" => [
    0 => [
    "dest" => "\Modules\Editor\Controller:viewEditorSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/costcenter/list.*$" => [
    0 => [
    "dest" => "\Modules\CostCenterAccounting\Controller:viewCostCenterList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/costcenter/create.*$" => [
    0 => [
    "dest" => "\Modules\CostCenterAccounting\Controller:viewCostCenterCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/costcenter/profile.*$" => [
    0 => [
    "dest" => "\Modules\CostCenterAccounting\Controller:viewCostCenterProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/costobject/list.*$" => [
    0 => [
    "dest" => "\Modules\CostObjectAccounting\Controller:viewCostObjectList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/costobject/create.*$" => [
    0 => [
    "dest" => "\Modules\CostObjectAccounting\Controller:viewCostObjectCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/accounting/costobject/profile.*$" => [
    0 => [
    "dest" => "\Modules\CostObjectAccounting\Controller:viewCostObjectProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend(\?.*)?$" => [
    0 => [
    "dest" => "\Modules\Dashboard\Controller:viewDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/database/list.*$" => [
    0 => [
    "dest" => "\Modules\Database\Controller:viewDatabaseList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/database/create.*$" => [
    0 => [
    "dest" => "\Modules\Database\Controller:viewDatabaseCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/database/result.*$" => [
    0 => [
    "dest" => "\Modules\Database\Controller:viewDatabaseResult",
    "verb" => 1,
]
,
]
,
    "^.*/backend/database/template.*$" => [
    0 => [
    "dest" => "\Modules\Database\Controller:viewDatabaseTemplate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/draw/create.*$" => [
    0 => [
    "dest" => "\Modules\Draw\Controller:setUpDrawEditor",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Draw\Controller:viewDrawCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/draw/list.*$" => [
    0 => [
    "dest" => "\Modules\Draw\Controller:viewDrawList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/draw/single.*$" => [
    0 => [
    "dest" => "\Modules\Draw\Controller:setUpDrawEditor",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Draw\Controller:viewDrawSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/eventmanagement/list.*$" => [
    0 => [
    "dest" => "\Modules\EventManagement\Controller:viewEventManagementList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/eventmanagement/create.*$" => [
    0 => [
    "dest" => "\Modules\EventManagement\Controller:viewEventManagementCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/eventmanagement/profile.*$" => [
    0 => [
    "dest" => "\Modules\EventManagement\Controller:viewEventManagementProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/help/general(\?.*)?$" => [
    0 => [
    "dest" => "\Modules\Help\Controller:viewHelpGeneral",
    "verb" => 1,
]
,
]
,
    "^.*/backend/help/module/list(\?.*)?$" => [
    0 => [
    "dest" => "\Modules\Help\Controller:viewHelpModuleList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/help/module/single(\?.*)?$" => [
    0 => [
    "dest" => "\Modules\Help\Controller:viewHelpModule",
    "verb" => 1,
]
,
]
,
    "^.*/backend/help/developer(\?.*)?$" => [
    0 => [
    "dest" => "\Modules\Help\Controller:viewHelpDeveloper",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/unit/list.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewUnitList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/unit/profile.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewUnitProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/unit/create.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewUnitCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/department/list.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewDepartmentList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/department/profile.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewDepartmentProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/department/create.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewDepartmentCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/position/list.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewPositionList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/position/profile.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewPositionProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/organization/position/create.*$" => [
    0 => [
    "dest" => "\Modules\Organization\Controller:viewPositionCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/hr/staff/list.*$" => [
    0 => [
    "dest" => "\Modules\HumanResourceManagement\Controller:viewHrStaffList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/hr/staff/profile.*$" => [
    0 => [
    "dest" => "\Modules\HumanResourceManagement\Controller:viewHrStaffProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/hr/staff/create.*$" => [
    0 => [
    "dest" => "\Modules\HumanResourceManagement\Controller:viewHrStaffCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/hr/department/list.*$" => [
    0 => [
    "dest" => "\Modules\HumanResourceManagement\Controller:viewHrDepartmentList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/item/list.*$" => [
    0 => [
    "dest" => "\Modules\ItemManagement\Controller:viewItemManagementSalesList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/item/list.*$" => [
    0 => [
    "dest" => "\Modules\ItemManagement\Controller:viewItemManagementPurchaseList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/warehouse/stock/list.*$" => [
    0 => [
    "dest" => "\Modules\ItemManagement\Controller:viewItemManagementWarehousingList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/sales/item/create.*$" => [
    0 => [
    "dest" => "\Modules\ItemManagement\Controller:viewItemManagementSalesCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/item/create.*$" => [
    0 => [
    "dest" => "\Modules\ItemManagement\Controller:viewItemManagementPurchaseCreate",
    "verb" => 1,
]
,
]
,
    ".*/backend/warehouse/stock/create.*$" => [
    0 => [
    "dest" => "\Modules\ItemManagement\Controller:viewItemManagementWarehousingCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/job/list.*$" => [
    0 => [
    "dest" => "\Modules\Job\Controller:viewJobList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/job/single.*$" => [
    0 => [
    "dest" => "\Modules\Job\Controller:viewJob",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/job/create.*$" => [
    0 => [
    "dest" => "\Modules\Job\Controller:viewJobCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/kanban.*$" => [
    0 => [
    "dest" => "\Modules\Kanban\Controller:setupStyles",
    "verb" => 1,
]
,
]
,
    "^.*/backend/kanban/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Kanban\Controller:viewKanbanDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/kanban/archive.*$" => [
    0 => [
    "dest" => "\Modules\Kanban\Controller:viewKanbanArchive",
    "verb" => 1,
]
,
]
,
    "^.*/backend/kanban/board.*$" => [
    0 => [
    "dest" => "\Modules\Kanban\Controller:viewKanbanBoard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/kanban/card.*$" => [
    0 => [
    "dest" => "\Modules\Kanban\Controller:viewKanbanCard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/kanban/create.*$" => [
    0 => [
    "dest" => "\Modules\Kanban\Controller:viewKanbanBoardCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:setUpBackend",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:viewKnowledgebaseDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki/category/list.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:viewKnowledgebaseCategoryList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki/category/single.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:viewKnowledgebaseCategory",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki/category/create.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:viewKnowledgebaseCategoryCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki/doc/single.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:viewKnowledgebaseDoc",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki/doc/create.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:viewKnowledgebaseDocCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/wiki/doc/list.*$" => [
    0 => [
    "dest" => "\Modules\Knowledgebase\Controller:viewKnowledgebaseDocList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/marketing/promotion/list.*$" => [
    0 => [
    "dest" => "\Modules\Marketing\Controller:viewMarketingPromotionList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/marketing/promotion/create.*$" => [
    0 => [
    "dest" => "\Modules\Marketing\Controller:viewMarketingPromotionCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/marketing/promotion/profile.*$" => [
    0 => [
    "dest" => "\Modules\Marketing\Controller:viewMarketingPromotionProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/marketing/event/list.*$" => [
    0 => [
    "dest" => "\Modules\Marketing\Controller:viewMarketingEventList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/marketing/event/create.*$" => [
    0 => [
    "dest" => "\Modules\Marketing\Controller:viewMarketingEventCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/marketing/event/profile.*$" => [
    0 => [
    "dest" => "\Modules\Marketing\Controller:viewMarketingEventProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/messages/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageInbox",
    "verb" => 1,
]
,
]
,
    "^.*/backend/messages/outbox.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageOutbox",
    "verb" => 1,
]
,
]
,
    "^.*/backend/messages/trash.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageTrash",
    "verb" => 1,
]
,
]
,
    "^.*/backend/messages/spam.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageSpam",
    "verb" => 1,
]
,
]
,
    "^.*/backend/messages/settings.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageSettings",
    "verb" => 1,
]
,
]
,
    "^.*/backend/messages/mail/create.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/messages/mail/single.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageView",
    "verb" => 1,
]
,
]
,
    "^.*/api/messages/mail/single.*$" => [
    0 => [
    "dest" => "\Modules\Messages\Controller:viewMessageView",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/monitoring/general.*$" => [
    0 => [
    "dest" => "\Modules\Monitoring\Controller:viewMonitoringGeneral",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/monitoring/log/list.*$" => [
    0 => [
    "dest" => "\Modules\Monitoring\Controller:viewMonitoringLogList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/admin/monitoring/log/single.*$" => [
    0 => [
    "dest" => "\Modules\Monitoring\Controller:viewMonitoringLogEntry",
    "verb" => 1,
]
,
]
,
    "^.*/backend/news/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\News\Controller:viewNewsDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/news/article.*$" => [
    0 => [
    "dest" => "\Modules\News\Controller:viewNewsArticle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/news/archive.*$" => [
    0 => [
    "dest" => "\Modules\News\Controller:viewNewsArchive",
    "verb" => 1,
]
,
]
,
    "^.*/backend/news/create.*$" => [
    0 => [
    "dest" => "\Modules\Editor\Controller:setUpEditorEditor",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\News\Controller:viewNewsCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/controlling/pl/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\PL\Controller:viewPLDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/production/list.*$" => [
    0 => [
    "dest" => "\Modules\Production\Controller:viewProductionList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/production/create.*$" => [
    0 => [
    "dest" => "\Modules\Production\Controller:viewProductionCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/production/process/list.*$" => [
    0 => [
    "dest" => "\Modules\Production\Controller:viewProductionProcessList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/production/process/create.*$" => [
    0 => [
    "dest" => "\Modules\Production\Controller:viewProductionProcessCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/projectmanagement/list.*$" => [
    0 => [
    "dest" => "\Modules\ProjectManagement\Controller:viewProjectManagementList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/projectmanagement/create.*$" => [
    0 => [
    "dest" => "\Modules\ProjectManagement\Controller:viewProjectManagementCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/projectmanagement/profile.*$" => [
    0 => [
    "dest" => "\Modules\ProjectManagement\Controller:viewProjectManagementProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/article/list.*$" => [
    0 => [
    "dest" => "\Modules\Purchase\Controller:viewPurchaseArticleList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/article/recommend.*$" => [
    0 => [
    "dest" => "\Modules\Purchase\Controller:viewPurchaseOrderRecommendation",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/article/create.*$" => [
    0 => [
    "dest" => "\Modules\Purchase\Controller:viewPurchaseArticleCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/article/profile.*$" => [
    0 => [
    "dest" => "\Modules\Purchase\Controller:viewPurchaseArticleProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/qa.*$" => [
    0 => [
    "dest" => "\Modules\QA\Controller:setUpBackend",
    "verb" => 1,
]
,
]
,
    "^.*/backend/qa/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\QA\Controller:viewQADashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/qa/badge/list.*$" => [
    0 => [
    "dest" => "\Modules\QA\Controller:viewQABadgeList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/qa/badge/single.*$" => [
    0 => [
    "dest" => "\Modules\QA\Controller:viewQABadgeEdit",
    "verb" => 1,
]
,
]
,
    "^.*/backend/qa/question.*$" => [
    0 => [
    "dest" => "\Modules\QA\Controller:viewQADoc",
    "verb" => 1,
]
,
]
,
    "^.*/backend/qa/question/create.*$" => [
    0 => [
    "dest" => "\Modules\QA\Controller:viewQAQuestionCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/reporter/template/create.*$" => [
    0 => [
    "dest" => "\Modules\Media\Controller::setUpFileUploader",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Reporter\Controller:viewTemplateCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/reporter/report/create.*$" => [
    0 => [
    "dest" => "\Modules\Media\Controller::setUpFileUploader",
    "verb" => 1,
]
,
    1 => [
    "dest" => "\Modules\Reporter\Controller:viewReportCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/reporter/list.*$" => [
    0 => [
    "dest" => "\Modules\Reporter\Controller:viewTemplateList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/reporter/report/view.*$" => [
    0 => [
    "dest" => "\Modules\Reporter\Controller:viewReporterReport",
    "verb" => 1,
]
,
]
,
    "^.*/backend/rnd/list.*$" => [
    0 => [
    "dest" => "\Modules\ResearchDevelopment\Controller:viewProjectList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/rnd/create.*$" => [
    0 => [
    "dest" => "\Modules\ResearchDevelopment\Controller:viewProjectCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/cockpit.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskCockpit",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/risk/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/risk/create.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/risk/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/cause/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskCauseList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/cause/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskCauseSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/solution/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskSolutionList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/solution/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskSolutionSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/unit/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskUnitList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/unit/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskUnitSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/department/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskDepartmentList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/department/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskDepartmentSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/category/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskCategoryList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/category/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskCategorySingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/project/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskProjectList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/project/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskProjectSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/process/list.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskProcessList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/process/single.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskProcessSingle",
    "verb" => 1,
]
,
]
,
    "^.*/backend/riskmanagement/settings/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\RiskManagement\Controller:viewRiskSettings",
    "verb" => 1,
]
,
]
,
    "^.*/backend/warehouse/shipping/list.*$" => [
    0 => [
    "dest" => "\Modules\Shipping\Controller:viewShippingList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/warehouse/shipping/create.*$" => [
    0 => [
    "dest" => "\Modules\Shipping\Controller:viewShippingCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/warehouse/stocktaking/list.*$" => [
    0 => [
    "dest" => "\Modules\StockTaking\Controller:viewStockTakingList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/supplier/list.*$" => [
    0 => [
    "dest" => "\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/supplier/create.*$" => [
    0 => [
    "dest" => "\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/supplier/profile.*$" => [
    0 => [
    "dest" => "\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/purchase/supplier/analysis.*$" => [
    0 => [
    "dest" => "\Modules\SupplierManagement\Controller:viewSupplierManagementSupplierAnalysis",
    "verb" => 1,
]
,
]
,
    "^.*/backend/support/list.*$" => [
    0 => [
    "dest" => "\Modules\Support\Controller:viewSupportList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/support/single.*$" => [
    0 => [
    "dest" => "\Modules\Support\Controller:viewSupportTicket",
    "verb" => 1,
]
,
]
,
    "^.*/backend/support/create.*$" => [
    0 => [
    "dest" => "\Modules\Support\Controller:viewSupportCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/support/analysis.*$" => [
    0 => [
    "dest" => "\Modules\Support\Controller:viewSupportAnalysis",
    "verb" => 1,
]
,
]
,
    "^.*/backend/support/settings.*$" => [
    0 => [
    "dest" => "\Modules\Support\Controller:viewSupportSettings",
    "verb" => 1,
]
,
]
,
    "^.*/backend/private/support/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Support\Controller:viewPrivateSupportDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/survey/list.*$" => [
    0 => [
    "dest" => "\Modules\Surveys\Controller:viewSurveysList",
    "verb" => 1,
]
,
]
,
    "^.*/backend/survey/create.*$" => [
    0 => [
    "dest" => "\Modules\Surveys\Controller:viewSurveysCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/survey/profile.*$" => [
    0 => [
    "dest" => "\Modules\Surveys\Controller:viewSurveysProfile",
    "verb" => 1,
]
,
]
,
    "^.*/backend/workflow/template/list.*$" => [
    0 => [
    "dest" => "\Modules\Workflow\Controller:viewWorkflowTemplates",
    "verb" => 1,
]
,
]
,
    "^.*/backend/workflow/template/single.*$" => [
    0 => [
    "dest" => "\Modules\Workflow\Controller:viewWorkflowTemplate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/workflow/template/create.*$" => [
    0 => [
    "dest" => "\Modules\Workflow\Controller:viewWorkflowTemplateCreate",
    "verb" => 1,
]
,
]
,
    "^.*/backend/workflow/dashboard.*$" => [
    0 => [
    "dest" => "\Modules\Workflow\Controller:viewWorkflowDashboard",
    "verb" => 1,
]
,
]
,
    "^.*/backend/workflow/single.*$" => [
    0 => [
    "dest" => "\Modules\Workflow\Controller:viewWorkflowSingle",
    "verb" => 1,
]
,
]
,
];