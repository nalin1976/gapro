<?php

session_start();

$administration 				= false;
$styleTransfer 					= false;
$manageUsers 					= false;
$CanTransferDataToMSSQL 		= false;
$canGetItemsFromOldSystem 		= false;
$canEditUserCompany				= false;
$canEditAnyUserAccount			= false;	

$addingMenu 					= false;
$manageSuppliers 				= false;
$addStyleItems 					= false;
$addgeneralItems 				= false;
$buyerform 						= false;
$manageCompanyForm 				= false;
$countryForm 					= false;
$departmentForm 				= false;
$seasonForm 					= false;
$shipmentTerms 					= false;
$colorForm 						= false;
$subContratorForm 				= false;
$unitForm 						= false;
$$shippingAgentForm 			= false;
$payeeForm 						= false;
$eventSchedule 					= false;
$eventTemplate 					= false;
$purchaseTypeForm 				= false;
$shippmentModeForm 				= false;
$quotaCategoryForm 				= false;
$canManageStyleSubCategories 	= false;
$manageStoreLocations 			= false;
$CanUpdateCurrencyRates 		= false;

$merchandising 					= false;
$manageCostSheet 				= false;
$preorderCosting 				= false;
$manageCostingSheet 			= false;
$approvalPreOrder 				= false;
$bomForm 						= false;
$purchaseorderforms 			= false;
$styleRevision 					= false;
$manageStyleBuyerPO 			= false;
$checkStatusForm 				= false;
$styleCompletion 				= false;
$orderCompletionForAny 			= false;
$supperStyleRatioEditor 		= false;
$supperMaterialRatioEditor 		= false;
$canIncreaseUnitPriceFromPO 	= false;
$canCancelPO 					= false;
$confirmPO 						= false;
$manageEventSchedules 			= false;
$bomItemDeletion 				= false;
$bomItemAddition 				= false;
$bomItemModify					= false;
$canSeeCostManagementFigures 	= false;
$canOrderAdditional 			= false;
$canChangePO 					= false;
$assignSubContractorOrders  	= false;
$canSeeCostingProfitMargin 		= false;
$canCancelAnyStyle 				= false;
$canModifyAnyCosting 			= false;
$canValidatePOs 				= false;
$sizeForm 						= false;
$allowSecondApprovalPO 			= false;
$cantPurchaseStockAvailable 	= false;
$manageOrderInquiry 			= false;

$inventory 						= false;
$grn 							= false;
$mrn 							= false;
$issues 						= false;
$gatePass 						= false;
$gatePassTransferring 			= false;
$returnToStore 					= false;
$returnToSupplier 				= false;
$orderStatusForm 				= false;
$fabricInspection 				= false;
$interJobTransfer 				= false;
$generalInventory				= false;
$generalPO 						= false;
$generalgrn 					= false;
$generalGatePass 				= false;
$generalMrn 					= false;
$generalIssues 					= false;
$generalRetunToStore 			= false;
$generalRetunToSupplier 		= false;
$fabricRollInspection 			= false;
$binToBinTransfer 				= false;
$confirmGeneralPO  				= false;
$GRNExcessQuantity				= false;
$canSaveInterjobTransfer 		= false;
$canApproveInterjobTransfer 	= false;
$canAuthorizeInterjobTransfer 	= false;
$canConfirmInterjobTransfer 	= false;
$canCancelInterjobTransfer 		= false;
$GRNUnlimitedExcess 			= false;
$editInvoicePriceInGrn			= false;
$raiseAdditionalPOForExGRNQty	= false;
$editInvoiceNumberInGrn			= false;
$approveGeneralPo				= false;
$canIncreaseUnitPriceInGPO      = false;
	
$payments 						= false;
$paymentAddings 				= false;
$glCreationForm 				= false;
$glAllocationForSupplier 		= false;
$glAllocationForFactory  		= false;
$paymentModeForm 				= false;
$paymentTermForm 				= false;
$withoutPO 						= false;
$withoutPOInvoice 				= false;
$withoutPOScheduleForm 			= false;
$withoutPOVoucherForm 			= false;
$advancePayments 				= false;
$supplierInvice 				= false;
$paymentSchedule 				= false;
$paymentVoucher 				= false;
$chequePrinting 				= false;

$production 					= false;
$cadConsumption 				= false;
$cadConsumption1 				= false;
$cadConsumption2 				= false;
$cadConsumption3 				= false;
$packingList     				= false;
$defectEntry     				= false;
$gatePassReturn    				= false;

$cutTicket 						= false;
$cutTicket1 					= false;
$normalGatepass 				= false;
$canUseSavedCmForAddingInSameCategory = false;

$reports 						= false;
$preorderReports 				= false;
$canSeeApprovedSheets 			= false;
$canViewAllApprovedSheets 		= false;
$canSeePendingCostSheetList 	= false;
$costVariationReport 			= false;
$CompletedOrderReport 			= false;
$inventoryReports 				= false;
$purchaseOrderReports 			= false;
$styleReports 					= false;
$styleMRNReports 				= false;
$POGRNList 						= false;
$costEstimateSheet 				= false;
$orderStatusTracking 			= false;
$inventoryReports			 	= false;
$generalpogrnlist 				= false;
$stockBalanceReport 			= false;
$subContractorReports 			= false;
$bomReports 					= false;
$canSeeOldToNewTransferReports  = false;
$materialDeletion 				= false;
$poRevisePTermAdvance 			= false;
$poCancelPTermAdvance 			= false;
$genaraItemSearchAndDelete 		= false;
$fabricRollApprove 				= false;
$manageProductCategory 			= false;
$allowApproveEventSchedule 		= false;
$allowReviceEventSchedule 		= false;
$viewEventSchedule				= false;
$manageInvoiceCostingMain 		= false;
$manageInvoiceCosting			= false;
$manageInvoiceCostingList 		= false;
$viewAuditTrail					= false;

$allowFirstApprovalPreOrder		= false;
$allowSecondApprovalPreOrder	= false;
$confirmInvoiceCosting			= false;
$confirmBulkPo					= false;

$manageCWSsendToapproval        = false;
$updateFabConpc					= false;
$updatePockConpc				= false;
$updateThreadConpc				= false;
$updateSMV						= false;
$updateDryWashPrice				= false;
$updateWetWashPrice				= false;
$manageCWSapproval				= false;
$manageCWSreject				= false;
$manageCWSRevise				= false;
$PP_ReviseMoreThanMaximumApproval 		= false;
$PP_editDelScheduleAfterFirstRevision 	= false;
$PP_manageSubContractModule1    		= false;
$PP_manageSubContractModule     		= false;
$washReady                      		= false;
$sewing                         		= false;
$viewallapprovedcostsheets				=false;
$confirmMRN								= false;
$viewdeliveryschedule    				= false;
$manageApproveAndAthorisInterJob 		= false;

$allowExtra					= false;
$allowFastReactDataTransfer      		= false;
$allowViewDeliveryAuditReport			= false;
$allowViewAuditReports				= false;
$allowBudgetLine				= false;

$viewSalesMonitoring				= false;
$approveDeliveries				= false;
$confirmDeliveries				= false;
$freezeDeliverySchedule				= false;

$allowCostSheetBelowEPM                         = false;

$sql = "select role.RoleName from useraccounts, role, userpermission where useraccounts.intUserID =" . $_SESSION["UserID"] . " and role.RoleID = userpermission.RoleID and userpermission.intUserID = useraccounts.intUserID and intStatus=1 ";

//global $db;

//$result = $db->RunQuery($sql);
$result = $dbheader->RunQuery($sql);
	
while($row = mysql_fetch_array($result))
{
	if ($row["RoleName"] == "Audit Trial Form")
	{
		$addingMenu = true;
		$viewAuditTrail = true;
	}	
	else if ($row["RoleName"] == "Manage Users")
	{
		$administration = true;
		$manageUsers = true;
	}
	else if ($row["RoleName"] == "MRN Confirm")
	{
		$confirmMRN	= true;
	}	
	else if ($row["RoleName"] == "Add Style Items")
	{
		$addingMenu = true;
		$addStyleItems = true;
	}
	else if ($row["RoleName"] == "View all approved cost sheets")
	{
		$viewallapprovedcostsheets = true;
	}
	else if ($row["RoleName"] == "Add General Items")
	{
		$addingMenu = true;
		$addgeneralItems = true;
	}
	else if ($row["RoleName"] == "Manage Suppliers")
	{
		$addingMenu = true;
		$manageSuppliers = true;
	}
	else if ($row["RoleName"] == "Banks Page Access")
	{
		$addingMenu = true;
		$paymentAddings	= true;
		$bankform = true;
	}
	else if ($row["RoleName"] == "Buyers Page Access")
	{
		$addingMenu = true;
		$buyerform = true;
	}
	else if ($row["RoleName"] == "Manage Company")
	{
		$addingMenu = true;
		$manageCompanyForm = true;
	}
	else if ($row["RoleName"] == "Manage Company")
	{
		$addingMenu = true;
		$manageCompanyForm = true;
	}
	else if ($row["RoleName"] == "Country Form")
	{
		$addingMenu = true;
		$countryForm = true;
	}
	else if ($row["RoleName"] == "Currency Form")
	{
		$addingMenu 				= true;
		$paymentAddings				= true;
		$currencyForm 				= true;
	}
	else if ($row["RoleName"] == "Department Form")
	{
		$addingMenu = true;
		$departmentForm = true;
	}
	else if ($row["RoleName"] == "Season Form")
	{
		$addingMenu = true;
		$seasonForm = true;
	}
	else if ($row["RoleName"] == "Shipment Terms Form")
	{
		$addingMenu = true;
		$shipmentTerms = true;
	}
	else if ($row["RoleName"] == "Colors Form")
	{
		$addingMenu = true;
		$colorForm = true;
	}
		else if ($row["RoleName"] == "Size Form")
	{
		$addingMenu = true;
		$sizeForm = true;
	}
	else if ($row["RoleName"] == "Sub Contractor Form")
	{
		$addingMenu = true;
		$subContratorForm = true;
	}
	else if ($row["RoleName"] == "Unit Form")
	{
		$addingMenu = true;
		$unitForm = true;
	}
	else if ($row["RoleName"] == "Shipping Agent Form")
	{
		$addingMenu = true;
		$shippingAgentForm = true;
	}
	else if ($row["RoleName"] == "Payee Form")
	{
		$addingMenu = true;
		$payeeForm = true;
	}
	else if ($row["RoleName"] == "Events Form")
	{
		$addingMenu = true;
		$eventSchedule = true;
	}
	else if ($row["RoleName"] == "Event Template Form")
	{
		$addingMenu = true;
		$eventTemplate = true;
	}
	else if ($row["RoleName"] == "Item Purchase Type Form")
	{
		$addingMenu = true;
		$purchaseTypeForm = true;
	}
	else if ($row["RoleName"] == "Shippment Mode Form")
	{
		$addingMenu = true;
		$shippmentModeForm = true;
	}
	else if ($row["RoleName"] == "Quota Categories Form")
	{
		$addingMenu = true;
		$quotaCategoryForm = true;
	}		
	else if ($row["RoleName"] == "Manage Costing Sheet")
	{
		$merchandising = true;
		$preorderCosting = true;
		$manageCostingSheet = true;
	}
	else if ($row["RoleName"] == "Manage Order No Change")
	{
		$merchandising = true;
		$preorderCosting = true;
		$PP_ManageOrderNoChange = true;
	}
	else if ($row["RoleName"] == "Approval Pre Order")
	{
		$merchandising = true;
		$preorderCosting = true;
		$approvalPreOrder = true;
	}
	else if ($row["RoleName"] == "BOM Form")
	{
		$merchandising = true;
		$bomForm = true;
	}
	else if ($row["RoleName"] == "Purchase Order Forms")
	{
		$merchandising = true;
		$purchaseorderforms = true;
	}
	else if ($row["RoleName"] == "Style Revision")
	{
		$merchandising = true;
		$styleRevision = true;
	}
	else if ($row["RoleName"] == "Manage Style Buyer PO")
	{
		$merchandising = false;
		$manageStyleBuyerPO = false;
	}
	else if ($row["RoleName"] == "Check Status Form")
	{
		$merchandising = true;
		$checkStatusForm = true;
	}
	else if ($row["RoleName"] == "Interjob Authorization")
	{		
		$manageApproveAndAthorisInterJob	= true;
	}
	else if ($row["RoleName"] == "GRN")
	{
		$inventory 					= true;
		$grn 						= true;
	}
	else if ($row["RoleName"] == "Trim Inspection")
	{		
		$PP_AllowTrimInspection 	= true;
		$PP_TrimInspection			= true;
		$inventory 					= true;
	}
	else if ($row["RoleName"] == "MRN")
	{
		$inventory 					= true;
		$mrn 						= true;
	}
	else if ($row["RoleName"] == "Issues")
	{
		$inventory 					= true;
		$issues 					= true;
	}
	else if ($row["RoleName"] == "Gate Pass")
	{
		$inventory 					= true;
		$gatePass 					= true;
		$PP_AllowStyleGatePass 		= true;
	}
	else if ($row["RoleName"] == "Gate Pass Transferring")
	{
		$inventory 					= true;
		$gatePassTransferring 		= true;
		$PP_AllowStylerGatePassTI	= true;
	}
	else if ($row["RoleName"] == "Return To Store")
	{
		$inventory 					= true;
		$returnToStore 				= true;
	}
	else if ($row["RoleName"] == "Order Status Form")
	{
		$inventory 					= true;
		$orderStatusForm 			= true;
	}
	else if ($row["RoleName"] == "Fabric Inspection")
	{
		$inventory 					= true;
		$fabricInspection 			= true;
	}
	else if ($row["RoleName"] == "Inter Job Transfer")
	{
		$inventory 					= true;
		$interJobTransfer 			= true;
	}
	else if ($row["RoleName"] == "General Purchase Order")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalPO 					= true;
	}
	else if ($row["RoleName"] == "General GRN")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalgrn 				= true;
	}
	else if ($row["RoleName"] == "General Gate Pass")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalGatePass 			= true;
	}
	else if ($row["RoleName"] == "General MRN")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalMrn 				= true;
	}
	else if ($row["RoleName"] == "General Issues")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalIssues 				= true;
	}
	else if ($row["RoleName"] == "General Return To Store")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalRetunToStore 		= true;
	}
	else if ($row["RoleName"] == "General Return To Supplier")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalRetunToSupplier 	= true;
	}
	else if ($row["RoleName"] == "General Check Status")
	{
		$inventory 					= true;
		$generalInventory			= true;
		$generalCheckStatus 		= true;
	}
	else if ($row["RoleName"] == "Tax Type Form")
	{
		$addingMenu		 			= true;
		$paymentAddings 			= true;
		$taxTypeForm 				= true;
	}
	else if ($row["RoleName"] == "Credit Period Form")
	{
		$addingMenu 				= true;
		$paymentAddings 			= true;
		$creditPeriodForm 			= true;
	}
	else if ($row["RoleName"] == "Batch Creation Form")
	{
		$addingMenu 				= true;
		$paymentAddings 			= true;
		$batchCreationForm 			= true;
	}
	else if ($row["RoleName"] == "GL Account Creation")
	{
		$addingMenu 				= true;
		$paymentAddings 			= true;
		$glCreationForm 			= true;
	}
	else if ($row["RoleName"] == "GL Allocation For Supplier Form")
	{
		$addingMenu 				= true;
		$paymentAddings		 		= true;
		$glAllocationForSupplier 	= true;
	}
	else if ($row["RoleName"] == "GL Allocation for Factory Form")
	{
		$addingMenu 				= true;
		$paymentAddings 			= true;
		$glAllocationForFactory 	= true;
	}
	else if ($row["RoleName"] == "Manage Cheque Information")
	{
		$addingMenu 				= true;
		$paymentAddings 			= true;
		$manageChequeInformation	= true;
	}
	else if ($row["RoleName"] == "Payment Mode Form")
	{
		$addingMenu				 	= true;
		$paymentAddings 			= true;
		$paymentModeForm 			= true;
	}
	else if ($row["RoleName"] == "Payment Term Form")
	{
		$addingMenu 				= true;
		$paymentAddings 			= true;
		$paymentTermForm 			= true;
	}
	else if ($row["RoleName"] == "Without PO Invoice")
	{
		$payments = true;
		$withoutPO = true;
		$withoutPOInvoice = true;
	}
	else if ($row["RoleName"] == "Without PO Schedule Form")
	{
		$payments = true;
		$withoutPO = true;
		$withoutPOScheduleForm = true;
	}
	else if ($row["RoleName"] == "Without PO Voucher")
	{
		$payments = true;
		$withoutPO = true;
		$withoutPOVoucherForm = true;
	}
	else if ($row["RoleName"] == "Advance Payment")
	{
		$payments = true;
		$advancePayments = true;
	}
	else if ($row["RoleName"] == "Supplier Invoice")
	{
		$payments = true;
		$supplierInvice = true;
	}
	else if ($row["RoleName"] == "Payment Schedule")
	{
		$payments = true;
		$paymentSchedule = true;
	}
	else if ($row["RoleName"] == "Payment Voucher")
	{
		$payments = true;
		$paymentVoucher = true;
	}
	else if ($row["RoleName"] == "Cheque Printing")
	{
		$payments = true;
		$chequePrinting = true;
	}
	else if ($row["RoleName"] == "CAD Consumption")
	{
		$production = true;
		$cadConsumption = true;
	}
	else if ($row["RoleName"] == "Sawing")
	{
		$production = true;
		$cadConsumption1 = true;
	}
	else if ($row["RoleName"] == "CAD Consumptions")
	{
		$production = true;
		$cadConsumption2 = true;
	}
	else if ($row["RoleName"] == "WIP Report")
	{
		$production = true;
		$cadConsumption3 = true;
	}
	else if ($row["RoleName"] == "Packing List")
	{
		$production = true;
		$packingList = true;
	}
	else if ($row["RoleName"] == "Defect Entry")
	{
		$production = true;
		$defectEntry = true;
	}
	else if ($row["RoleName"] == "Gate Pass Return")
	{
		$production = true;
		$gatePassReturn = true;
	}
	else if ($row["RoleName"] == "Wash Ready")
	{
		$production = true;
		$washReady = true;
	}
	else if ($row["RoleName"] == "Allow Sewing")
	{
		$production = true;
		$sewing = true;
	}
	
	else if ($row["RoleName"] == "Cut Ticket")
	{
		$production = true;
		$cutTicket = true;
	}
	else if ($row["RoleName"] == "Gate pass Return")
	{
		$production = true;
		$cutTicket1 = false;
	}
	else if ($row["RoleName"] == "Normal Gate Pass")
	{
		$inventory = true;
		$normalGatepass = true;
	}
	else if ($row["RoleName"] == "Return To Supplier")
	{
		$inventory = true;
		$returnToSupplier = true;
	}
	else if ($row["RoleName"] == "Order Completion") 
	{
		$merchandising = true;
		$styleCompletion = true;
	}
	else if ($row["RoleName"] == "BOM Can Play On Same Category CM")
	{
		$canUseSavedCmForAddingInSameCategory = true;
	}
	else if ($row["RoleName"] == "Order Completion For Any") 
	{
		$merchandising = true;
		$styleCompletion = true;
		$orderCompletionForAny = true;
	}	
	else if ($row["RoleName"] == "Supper Style Ratio Editor") 
	{
		$supperStyleRatioEditor = true;
	}
	else if ($row["RoleName"] == "Super Material Ratio Editor") 
	{
		$supperMaterialRatioEditor = true;
	}	
	else if ($row["RoleName"] == "Can Increase Unit Price from PO") 
	{
		$canIncreaseUnitPriceFromPO = true;
	}
	else if ($row["RoleName"] == "Can View Approved Sheets") 
	{
		$reports = true;
		$preorderReports = true;
		$canSeeApprovedSheets  = true;
	}
	else if ($row["RoleName"] == "Can View All Approved Sheets") 
	{
		$reports = true;
		$preorderReports = true;
		$canViewAllApprovedSheets = true;
	}
	else if ($row["RoleName"] == "Can View Rejected Sheets") 
	{
		$reports = true;
		$preorderReports = true;
		$canViewRejectedSheets  = true;
	}
	else if ($row["RoleName"] == "Purchase Order Reports") 
	{
		$reports = true;
		$purchaseOrderReports = true;
	}
	else if ($row["RoleName"] == "Style Reports") 
	{
		$reports = true;
		$styleReports = true;
	}
	else if ($row["RoleName"] == "Manage Bulk Reports") 
	{
		$reports = true;
		$bulkReports = true;
	}
	else if ($row["RoleName"] == "Style MRN Reports") 
	{
		$reports = true;
		$styleMRNReports = true;
	}
	else if ($row["RoleName"] == "PO GRN List") 
	{
		$reports = true;
		$POGRNList = true;
	}
	else if ($row["RoleName"] == "Cost Estimate Sheets") 
	{
		$reports = true;
		$costEstimateSheet = true;
	}
	else if ($row["RoleName"] == "Order Status") 
	{
		$reports = true;
		$orderStatusTracking = true;
	}
	else if ($row["RoleName"] == "Fabric Roll Inspection") 
	{
		$inventory = true;
		$fabricRollInspection = true;
	}
	else if ($row["RoleName"] == "Cancel PO") 
	{
		$canCancelPO = true;
	}
	else if ($row["RoleName"] == "Confirm PO") 
	{
		$confirmPO = true;
		$purchaseorderforms = true;
	}
	else if ($row["RoleName"] == "Bin to Bin Transfer") 
	{
		$inventory = true;
		$binToBinTransfer = true;
	}
	else if ($row["RoleName"] == "GRN Excess Quantity") 
	{
		$addingMenu = true;
		$GRNExcessQuantity = true;
	}
	else if ($row["RoleName"] == "Create New Inter Job Transfer") 
	{
		$canSaveInterjobTransfer = true;
	}
	else if ($row["RoleName"] == "Approve Inter Job Transfer") 
	{
		$canApproveInterjobTransfer = true;
	}
	else if ($row["RoleName"] == "Authorize Inter Job Transfer") 
	{
		$canAuthorizeInterjobTransfer = true;
	}
	else if ($row["RoleName"] == "Confirm Inter Job Transfer") 
	{
		$canConfirmInterjobTransfer = true;
	}
	else if ($row["RoleName"] == "Cancel Inter Job TRansfer") 
	{
		$canCancelInterjobTransfer = true;
	}
	else if ($row["RoleName"] == "Inventory Reports") 
	{
		$reports			= true;
		$inventoryReports = true;
	}
	else if ($row["RoleName"] == "Manage Style Item Categories") 
	{
		$canManageStyleSubCategories = true;
	}
	else if ($row["RoleName"] == "Can See Pending Cost Sheet List") 
	{
		$reports		= true;
		$preorderReports = true;
		$canSeePendingCostSheetList = true;
	}
	else if ($row["RoleName"] == "Cost Variation Report") 
	{
		$reports		= true;
		$preorderReports = true;
		$costVariationReport = true;
	}
	else if ($row["RoleName"] == "Completed Order Report") 
	{
		$reports		= true;
		$preorderReports = true;
		$CompletedOrderReport = true;
	}
	else if ($row["RoleName"] == "Manage Event Schedules") 
	{
		$merchandising = true;
		$manageEventSchedules = true;
		$viewEventSchedule			= true;
	}
	else if ($row["RoleName"] == "BOM Item Deletion") 
	{
		$bomItemDeletion = true;
	}
	else if ($row["RoleName"] == "BOM Item Creation") 
	{
		$bomItemAddition = true;
	}
	else if ($row["RoleName"] == "BOM Item Modifying") 
	{
		$bomItemModify = true;
	}
	else if ($row["RoleName"] == "Style Transfer") 
	{
		$styleTransfer = true;
	}
	else if ($row["RoleName"] == "General PO - GRN") 
	{
		$reports	= true;
		$generalpogrnlist = true;
	}
	else if ($row["RoleName"] == "Allow Bulk PO GRN List") 
	{
		$reports	= true;
		$PP_AllowBulkPOGrnList = true;
	}
	else if ($row["RoleName"] == "Time & Action Plan Report") 
	{
		$reports = true;
		$timeAndActionPlanReports  = true;
	}
	else if ($row["RoleName"] == "Confirm General PO") 
	{
		$confirmGeneralPO  = true;
	}
	else if ($row["RoleName"] == "Display Cost Management Figures") 
	{
		$canSeeCostManagementFigures  = true;
	}		
	else if ($row["RoleName"] == "Stock Balance Report") 
    {
		$reports	= true;
		$stockBalanceReport  = true;
	}
	else if ($row["RoleName"] == "Change PO") 
	{
		$canChangePO  = true;
	}
	else if ($row["RoleName"] == "Assign Sub Contractor Orders") 
	{
		$assignSubContractorOrders  = true;
	}
	else if ($row["RoleName"] == "Sub Contractor Reports") 
	{
		$reports	= true;
		$subContractorReports  = true;
	}
	else if ($row["RoleName"] == "BOM Reports") 
	{
		$reports	 = true;
		$bomReports  = true;
	}
	else if ($row["RoleName"] == "GRN Unlimited Excess") 
	{
		$GRNUnlimitedExcess  = true;
	}
	else if ($row["RoleName"] == "Data Transfer To Previous Version") 
	{
		$CanTransferDataToMSSQL  = true;
		$administration = true;
	}
	else if ($row["RoleName"] == "Item Transfer From Previous Version") 
	{
		$canGetItemsFromOldSystem  = true;
		$administration = true;
	}
	else if ($row["RoleName"] == "Inter Job Transfer From Previous Version") 
	{
		$oldSystemInterJobTransfer  = true;
	}
	else if ($row["RoleName"] == "Stores Location Wizard") 
	{
		$manageStoreLocations  = true;
		$addingMenu = true;
	}	
	else if ($row["RoleName"] == "Can Update Currency Rates") 
	{
		$CanUpdateCurrencyRates  = true;
	}
	else if ($row["RoleName"] == "Can See Costing Profit Margin") 
	{
		$canSeeCostingProfitMargin  = true;
	}
	else if ($row["RoleName"] == "Can Cancel Any Style") 
	{
		$canCancelAnyStyle  = true;
	}
	else if ($row["RoleName"] == "Order Cancellation") 
	{
		$orderCancellation  = true;
	}
	else if ($row["RoleName"] == "Modify Any Costing") 
	{
		$canModifyAnyCosting  = true;
	}
	else if ($row["RoleName"] == "MRN Clearance") 
	{
		$canMRNClearance  = true;
	}
	else if ($row["RoleName"] == "Old New Transfer Report") 
	{
		$reports			= true;
		$canSeeOldToNewTransferReports  = true;
	}
	else if ($row["RoleName"] == "Validate PO") 
	{
		$canValidatePOs  = true;
	}
	else if ($row["RoleName"] == "Material Deletion")
	{
		$addingMenu = true;
		$materialDeletion = true;
	}
	else if ($row["RoleName"] == "Po Revise when payment term advance")
	{		
		$poRevisePTermAdvance = true;
	}
	else if ($row["RoleName"] == "Po Cansel when payment term advance")
	{		
		$poCancelPTermAdvance = true;
	}
	else if ($row["RoleName"] == "Genaral Item Search And Deletion")
	{		
		$genaraItemSearchAndDelete = true;
	}
	else if ($row["RoleName"] == "Fabric Roll Approve")
	{		
		$fabricRollApprove = true;
	}
	else if ($row["RoleName"] == "Product Category")
	{		
		$manageProductCategory = true;
	}
	else if ($row["RoleName"] == "Approve Event Schedule")
	{		
		$allowApproveEventSchedule = true;
		$viewEventSchedule			= true;
	}
	else if ($row["RoleName"] == "Revise Event Schedule")
	{		
		$allowReviceEventSchedule = true;
		$viewEventSchedule			= true;
	}
	else if ($row["RoleName"] == "Allow Invoice Costing")
	{		
		$manageInvoiceCostingMain 	= true;
		$manageInvoiceCosting		= true;
		$merchandising				= true;
	}
	else if ($row["RoleName"] == "Allow Invoice Costing List")
	{		
		$manageInvoiceCostingList 	= true;
		//$manageInvoiceCosting		= true;
	}
	else if ($row["RoleName"] == "Allow Invoice Costing Variation Report")
	{		
		$PP_AllowInvoiceCostingVariationReport 	= true;
		$manageInvoiceCostingList 	= true;
	}
	else if ($row["RoleName"] == "Allow PO Second Approval")
	{		
		$allowSecondApprovalPO   = true;
	}
	else if ($row["RoleName"] == "Cannot Purchase if stocks available")
	{		
		$cantPurchaseStockAvailable   = true;
	}
	else if ($row["RoleName"] == "Allow User For First Order Approval")
	{
		$allowFirstApprovalPreOrder	= true;
	}
	else if ($row["RoleName"] == "Allow User For Second Order Approval")
	{
		$allowSecondApprovalPreOrder	= true;
	}
	else if ($row["RoleName"] == "Allow User To Confirm Invoice Costing")
	{
		$confirmInvoiceCosting	= true;
	}
	else if ($row["RoleName"] == "Revise Invoice Costing")
	{
		$PP_reviseInvoiceCosting	= true;
	}
	else if ($row["RoleName"] == "Confirm Bulk PO")
	{
		$confirmBulkPo	= true;
	}
	else if ($row["RoleName"] == "Manage Order Inquiry")
	{
		$manageOrderInquiry	= true;
		$merchandising 		= true;
	}
	else if ($row["RoleName"] == "Manage Monthly Shipment Schedule")
	{
		$manageMonthlyShipmentSchedule	= true;
	}
	else if ($row["RoleName"] == "Manage Weekly Shipment Schedule")
	{
		$manageWeeklyShipmentSchedule	= true;
	}
	else if ($row["RoleName"] == "Manage Fabric Recap")
	{
		$manageManageFabricRecap	= true;
		$merchandising 		= true;
	}
	else if ($row["RoleName"] == "Manage Shipping Data")
	{
		$manageShippingData	= true;
		$merchandising 		= true;
	}
	else if ($row["RoleName"] == "Can Edit User Company")
	{
		$canEditUserCompany	= true;		
	}
	else if ($row["RoleName"] == "Can Edit Any User Account")
	{
		$canEditAnyUserAccount	= true;		
	}
	else if ($row["RoleName"] == "Raise Additional PO For Excess GRN Qty")
	{
		$raiseAdditionalPOForExGRNQty	= true;		
	}
	else if ($row["RoleName"] == "Can Edit Invoice Price In Grn")
	{
		$editInvoicePriceInGrn	= true;		
	}
	else if ($row["RoleName"] == "Can Edit User Excess Pecentage")
	{
		$canEditUserExcessPecentage	= true;		
	}
	else if ($row["RoleName"] == "Manage Stock Movement Report") 
	{
		$reports	= true;
		$manageStockMovementReport  = true;
	}
	else if ($row["RoleName"] == "Manage Age Analysis Report") 
	{
		$reports	= true;
		$manageAgeAnalysisReport  = true;
	}
	else if ($row["RoleName"] == "Manage Planning Board") 
	{		
		$managePlanningBoard  = true;
	}
	else if ($row["RoleName"] == "Manage Fixed Assets Management") 
	{		
		$manageFixedAssetsManagement  = true;
	}
	else if ($row["RoleName"] == "Manage WorkStudy") 
	{		
		$manageWorkStudy  = true;
	}	
	else if ($row["RoleName"] == "Manage Unit Conversion") 
	{	
		$addingMenu				= true;	
		$manageUnitConversion  	= true;
	}
	else if ($row["RoleName"] == "Manage Bin Inquiry") 
	{	
		$addingMenu				= true;	
		$manageBinInquiry  		= true;
	}
	else if ($row["RoleName"] == "Manage Style Item Request") 
	{	
		$addingMenu				= true;	
		$manageItemRequest  	= true;
	}
	else if ($row["RoleName"] == "Manage Style Item Request Confirmation") 
	{	
		$addingMenu				= true;	
		$manageItemRequestConfirmation  	= true;
	}	
	else if ($row["RoleName"] == "Manage Delivery Schedule Report") 
	{	
		$reports						= true;	
		$manageDeliveryScheduleReport  	= true;
	}
	else if ($row["RoleName"] == "Can Edit Invoice Number In GRN")
	{
		$editInvoiceNumberInGrn	= true;		
	}
	else if ($row["RoleName"] == "Manage Dry Process") 
	{		
		$manageWashing  	= true;
		$manageWasAdding  	= true;
		$manageWasDryProcess = true;
	}
	else if ($row["RoleName"] == "Manage Garment Type") 
	{		
		$manageWashing  	= true;
		$manageWasAdding  	= true;
		$manageWasGarmentType = true;
	}
	else if ($row["RoleName"] == "Manage Operators") 
	{		
		$manageWashing  	= true;
		$manageWasAdding  	= true;
		$manageWasOperator = true;
	}
	else if ($row["RoleName"] == "Manage Wash Formula") 
	{		
		$manageWashing  	= true;
		$manageWasAdding  	= true;
		$manageWasWashFormula = true;
	}
	else if ($row["RoleName"] == "Manage Wash Type") 
	{		
		$manageWashing  	= true;
		$manageWasAdding  	= true;
		$manageWasWashType	= true;
	}
	else if ($row["RoleName"] == "Manage Machine Type") 
	{		
		$manageWashing  		= true;
		$manageWasAdding  		= true;
		$manageWasMachineType	= true;
	}
	else if ($row["RoleName"] == "Manage Machine Category") 
	{		
		$manageWashing  			= true;
		$manageWasAdding  			= true;
		$manageWasMachineCategory	= true;
	}
	else if ($row["RoleName"] == "Manage Issued To Washing") 
	{		
		$manageWashing  		= true;
		$manageWasIssuedToWash	= true;
	}
	else if ($row["RoleName"] == "Manage Wash Price") 
	{		
		$manageWashing  		= true;
		$manageWasWashPrice		= true;
	}
	else if ($row["RoleName"] == "Manage Budget Cost") 
	{		
		$manageWashing  		= true;
		$manageWasBudgetCost	= true;
		$manageWasBudgetCostForm	= true;
	}
	else if ($row["RoleName"] == "Manage Budget Cost Listing") 
	{
		$manageWashing  		= true;	
		$manageWasBudgetCostList	= true;
	}
	else if ($row["RoleName"] == "Manage Actual Cost") 
	{		
		$manageWashing  				= true;
		$manageWasActualCost			= true;
		$manageWasActualCostListForm	= true;
	}
	else if ($row["RoleName"] == "Manage Actual Cost Listing") 
	{
		$manageWashing  		= true;
		$manageWasActualCostList		= true;
	}
	else if ($row["RoleName"] == "Manage Maching Loading") 
	{		
		$manageWashing  			= true;
		$manageWasMachineLoading	= true;
	}
	else if ($row["RoleName"] == "Manage Issued To Finishing") 
	{		
		$manageWashing  			= true;
		$manageWasIssuedToFinishing	= true;
	}
	else if ($row["RoleName"] == "Manage WIP") 
	{		
		$manageWashing  = true;
		$manageWasWip	= true;
	}
	else if ($row["RoleName"] == "Manage Cost Work Sheet-Approval")
	{
		$manageFirstSale = true;
		$manageFSCostWorkSheet = true;
		$manageFSCostWorkSheet_Approval= true;
	}
	else if ($row["RoleName"] == "Manage Cost Work Sheet-Finance")
	{
		$manageFirstSale = true;
		$manageFSCostWorkSheet = true;
		$manageFSCostWorkSheet_Finance = true;
	}
	else if ($row["RoleName"] == "Manage Cost Work Sheet-Shipping")
	{
		$manageFirstSale = true;
		$manageFSCostWorkSheet = true;
		$manageFSCostWorkSheet_Shipping = true;
	}
	else if ($row["RoleName"] == "Manage Item Allocation")
	{
		$manageAddinsFirstSale = true;
		$manageAddinsFSItemAllocation = true;
		$addingMenu					= true;
	}
	else if ($row["RoleName"] == "Allow CWS send to approval")
	{
		$manageCWSsendToapproval = true;		
	}
	else if ($row["RoleName"] == "Manage Purchase Requisition")
	{
		$managePR = true;		
	}
	else if ($row["RoleName"] == "Manage Allocate GL To Main Item")
	{
		$manageAlloGlToItem = true;
		$manageBudgetAddins = true;	
	}
	else if($row["RoleName"] =="Revise Order After Done Invoice Costing")
	{
		$reviseOrderAfterDoneInvoiceCosting = true;
	}
	else if($row["RoleName"] =="Manage Adjust Stock")
	{
		$manageOpeningStock	= true;
	}
	else if($row["RoleName"] =="Transfer Bulk Stock From Old ERP")
	{
		$manageTransferBulkStockFromOldERP	= true;
	}
	else if($row["RoleName"] =="Cancel Cutting GatePass")
	{
		$cancelCuttingGatePass	= true;
	}
	else if($row["RoleName"] =="Update Actual Fabric Consumtion")
	{
		$updateFabConpc	= true;
	}
	else if($row["RoleName"] =="Update Actual Pocketing Consumtion")
	{
		$updatePockConpc	= true;
	}
	else if($row["RoleName"] =="Update Actual Thread Consumption")
	{
		$updateThreadConpc	= true;
	}
	else if($row["RoleName"] =="Update SMV Rate")
	{
		$updateSMV	= true;
	}
	else if($row["RoleName"] =="Allow Chemical PO Report")
	{
		$PP_allowChemicalPOReport	= true;
	}
	else if($row["RoleName"] =="Allow Item Wise LeftOver Form")
	{
		$PP_allowItemWiseLeftOverForm	= true;
	}
	else if($row["RoleName"] =="Allow Stores Order Confirmation")
	{
		$PP_allowStoresOrderConfirmation	= true;
	}
	else if($row["RoleName"] =="Allow Allocation Reports")
	{
		$PP_allowAllocationReports	= true;
		$reports					= true;
	}
	else if($row["RoleName"] =="Allow Order Book")
	{
		$PP_allowOrderBook			= true;
		$PP_allowOrderBookList		= true;
		$reports					= true;
	}
	else if($row["RoleName"] =="Allow Sales Reports")
	{
		$PP_AllowSalesReports			= true;
		$PP_allowOrderBookList		= true;
		$reports						= true;
	}
	else if($row["RoleName"] =="Allow Special Send To Approval Form")
	{
		$PP_allowSpecialSendToApprovalForm		= true;
	}
	else if($row["RoleName"] =="Confirm Bulk GRN")
	{
		$PP_confirmBulkGRN		= true;
	}
	else if($row["RoleName"] =="UpdateDryWashPrice")
	{
		$updateDryWashPrice		= true;
	}
	else if($row["RoleName"] =="Update Wet Wash Price")
	{
		$updateWetWashPrice		= true;
	}
	else if($row["RoleName"] =="Confirm CWS")
	{
		$manageCWSapproval		= true;
	}
	else if($row["RoleName"] =="Reject CWS")
	{
		$manageCWSreject		= true;
	}
	else if($row["RoleName"] =="Revise CWS")
	{
		$manageCWSRevise		= true;
	}
	else if($row["RoleName"] =="Allow Actual Consumption Form")
	{
		$PP_allowActualConsumptionForm = true;
		$manageFirstSale = true;
	}
	else if($row["RoleName"] =="Allow Monthly Shipment Schedule")
	{
		$PP_allowMonthlyShipmentSchedule 	= true;
		$PP_manageSchedule 					= true;
		$PP_manageFinishingModule 			= true;
	}
	else if($row["RoleName"] =="Allow Weekly Shipment Schedule")
	{
		$PP_allowWeeklyShipmentSchedule 	= true;
		$PP_manageSchedule 					= true;
		$PP_manageFinishingModule 			= true;
	}
	else if($row["RoleName"] =="Allow Export GatePass")
	{
		$PP_allowExportGatePass 			= true;
		$PP_manageFinishingModule 			= true;
	}
	else if($row["RoleName"] =="Allow Shipping Advise")
	{
		$PP_allowShippingAdvise 			= true;
		$PP_manageFinishingModule 			= true;
	}
	else if($row["RoleName"] =="Allow Color Size Plugin")
	{
		$PP_allowColorSizePlugin			= true;
		$PP_manageFinishingModule 			= true;
	}
	else if($row["RoleName"] =="Allow Packing List")
	{
		$PP_allowPackingList 				= true;
		$PP_manageFinishingModule 			= true;
	}
	else if($row["RoleName"] =="Allow Sample MRN,Issue,Return")
	{
		$PP_allowSample 				= true;
		$manageWashing 					= true;
	}
	else if($row["RoleName"] =="Allow Chemical Inventory")
	{
		$PP_manageChemicalInventory		= true;
		$manageWashing 					= true;
	}
	else if($row["RoleName"] =="Allow Internal GatePass")
	{
		$PP_allowInternalGatePass		= true;
		$manageWashing 					= true;
	}
	else if($row["RoleName"] =="Allow External GatePass")
	{
		$PP_allowExternalGatePass		= true;
		$manageWashing 					= true;
	}
	else if($row["RoleName"] =="Allow Return To Factory")
	{
		$PP_allowReturnToFactory		= true;
		$manageWashing 					= true;
	}
	else if($row["RoleName"] =="Allow Wash Receive")
	{
		$PP_allowWashReceive 			= true;
		$manageWashing 					= true;
	}
	else if($row["RoleName"] =="Manage Cost Centers")
	{
		$paymentAddings 				= true;
		$manageCostCenters 				= true;
		$addingMenu						= true;
	}
	else if($row["RoleName"] =="Allow Bulk GatePass")
	{
		$PP_AllowBulkGatePass 			= true;
		$gatePass 						= true;
		$inventory 						= true;
	}
	else if($row["RoleName"] =="Allow Bulk GatePass Transfer In")
	{
		$PP_AllowBulkGatePassTI			= true;
		$gatePass 						= true;
		$inventory 						= true;
	}
	else if($row["RoleName"] =="Allow Destination")
	{
		$PP_allowAddingDestinations		= true;
		$PP_allowAddingFinishing 		= true;
		$addingMenu						= true;
	}
	else if($row["RoleName"] =="Allow Branch Network")
	{
		$PP_allowAddingBranchNetwork	= true;
		$PP_allowAddingFinishing 		= true;
		$addingMenu						= true;
	}
	else if($row["RoleName"] =="Allow Notify Parties")
	{
		$PP_allowAddingNotifyParties	= true;
		$PP_allowAddingFinishing 		= true;
		$addingMenu						= true;
	}
	else if($row["RoleName"] =="Allow Sub Contract")
	{
		$PP_manageSubContract 			= true;
		$manageWashing					= true;
	}
	else if($row["RoleName"] =="Allow Stores Transfer Note")
	{
		$PP_storesTransferNote 	= true;
		$inventory					= true;
	}
	else if($row["RoleName"] =="Allow Stores Allocation")
	{
		$PP_storesAllocation 		= true;
		$inventory					= true;
	}
	else if($row["RoleName"] =="Allow Stores Item Disposal")
	{
		$PP_storesItemDisposal 		= true;
		$inventory					= true;
	}
	else if($row["RoleName"] =="Cancel Left Over Allocation")
	{
		$PP_CancelLeftOverAllocation 	= true;
	}
	else if($row["RoleName"] =="Cancel Bulk Allocation")
	{
		$PP_CancelBulkAllocation 		= true;
	}
	else if ($row["RoleName"] == "Allow LeftOver GatePass")
	{
		$inventory 						= true;
		$gatePass 						= true;
		$PP_AllowLeftOverGatePass 		= true;
	}
	else if ($row["RoleName"] == "Allow LeftOver GatePass")
	{
		$inventory 						= true;
		$gatePass 						= true;
		$PP_AllowLeftOverGatePass 		= true;
	}
	else if ($row["RoleName"] == "Allow LeftOver GatePass Transfer In")
	{
		$inventory 					= true;
		$gatePassTransferring 		= true;
		$PP_AllowLeftOverGatePassTI	= true;
	}
	else if ($row["RoleName"] == "Allow Update First Sale Category")
	{
		$manageWasAdding  	= true;
		$manageWasDryProcess = true;
		$manageFScategory = true;
	}
	else if ($row["RoleName"] == "Allow PR First Approval")
	{
		$PP_AllowFirstApproval  	= true;
	}
	else if ($row["RoleName"] == "Allow PR Second Approval")
	{
		$PP_AllowSecondApproval  	= true;
	}
	else if ($row["RoleName"] == "Allow SubcontractModule")
	{	
		$manageSubcontract              =true;
		$PP_manageSubContractModule 	= true;
	}
	else if ($row["RoleName"] == "Allow AOD and GRN")
	{
	    $manageSubcontract              =true;
		$PP_manageSubContractModule1 	= true;
	}
	else if ($row["RoleName"] == "Allow Confirm Return To Stores")
	{
		$PP_AllowConfirmReturnToStores 	= true;
	}
	else if ($row["RoleName"] == "Allocate Recut Qty In Allocation")
	{
		$canAllocateTotalRatioQty = true;
		$canAllocateTotalQtyFromLeftover = true;
	}
	else if ($row["RoleName"] == "Allow Left Over Reservation")
	{
		$PP_AllowLeftOverReservation 	= true;
		//$merchandising					= true;
	}
	else if ($row["RoleName"] == "Allow Style BuyerPO")
	{
		//$merchandising					= true;
	}
	else if ($row["RoleName"] == "Allow Production Reports")
	{
		$PP_AllowProduction = true;
	}
	else if($row["RoleName"] == "Cancel Style GRN")
	{
		$PP_CancelStyleGRN = true;
	}
	else if ($row["RoleName"] == "Allow Excess PO First Approval")
	{
		$PP_AllowExcessPOFirstApproval 	= true;
		$purchaseorderforms				= true;
		$merchandising					= true;
	}
	else if ($row["RoleName"] == "Allow Excess PO Second Approval")
	{
		$PP_AllowExcessPOSecondApproval = true;
		$purchaseorderforms				= true;
		$merchandising					= true;
	}
	else if ($row["RoleName"] == "Allow Gate Pass Log")
	{
		$PP_AllowGatePassLog 			= true;
		$manageWashing					= true;
	}
	else if ($row["RoleName"] == "Allow Washing Order Book")
	{
		$PP_AllowWashingOrderBook 		= true;
		$manageWashing					= true;
	}
	else if($row["RoleName"] == "Change Factory GatePass")
	{
		$manageWashing					= true;
		$PP_AllowChangeFactoryGatePass 	= true;
	}
	else if($row["RoleName"] == "Revise More Than Maximum Approval")
	{
		$PP_ReviseMoreThanMaximumApproval 	= true;
	}
	else if($row["RoleName"] == "Allow Special Trim Inspection")
	{
		$PP_AllowSpecialTrimInspection 	= true;
		$PP_TrimInspection				= true;
		$inventory 						= true;
	}
	else if($row["RoleName"] == "Allow Recut First Approval")
	{
		$allowRecutFirstApprove 	= true;
	}
	else if($row["RoleName"] == "Allow Recut Second Approval")
	{
		$allowRecutSecondApprove 	= true;
	}
	else if($row["RoleName"] == "Allow Recut Process")
	{
		$PP_AllowRecutProcess 	= true;
		$preorderCosting		= true;
		$merchandising			= true;
	}
	else if($row["RoleName"] == "Allow Order Contract Approval")
	{
		$manageFirstSale			= true;
		$PP_OrderContractApproval	= true;
	}
	else if($row["RoleName"] == "Allow Order Contract First Approval")
	{
		$PP_AllowOCFSFirstApproval	= true;
	}
	else if($row["RoleName"] == "Allow Order Contract Second Approval")
	{
		$PP_AllowOCFSSecondApproval	= true;
	}
	else if($row["RoleName"] == "Allow Tax Invoise Confirmation")
	{
		$PP_confirmTaxInvoiceInFS 	= true;
	}
	else if($row["RoleName"] == "Allow LC Request First Approval")
	{
		 $allowLCFirstApprove	= true;
	}
	else if($row["RoleName"] == "Allow LC Request Second Approval")
	{
		 $allowLCSecondApprove	= true;
	}
	else if($row["RoleName"] == "Allow LC Request Log")
	{
		 $PP_manageLCRequest	= true;
	}
	else if($row["RoleName"] == "Allow WIP Valuation")
	{
		 $PP_manageWIPValuation	= true;
	}
	else if($row["RoleName"] == "Allow Costworksheet Revise")
	{
		 $PP_CostworksheetRevise	= true;
	}
	else if($row["RoleName"] == "Allow Order Contract Checking Permission")
	{
		$PP_AllowFSOrderContractCheck	= true;
	}
	else if($row["RoleName"] == "Allow Payment SVAT Report")
	{
		$PP_AllowPaymentSVATReport	= true;
	}
	else if($row["RoleName"] == "Invoice Costing Power User")
	{
		$PP_InvoiceCostingPowerUser	= true;
	}
	else if($row["RoleName"] == "Can Increase Item Unitprice")
	{
		$PP_canIncreaseItemUnitprice	= true;
	}
	else if($row["RoleName"] == "Can Edit Delivery Schedule After First Revision")
	{
		$PP_editDelScheduleAfterFirstRevision	= true;
	}
	else if($row["RoleName"] == "Can Edit Delivery Schedule After Revision")
	{
		$PP_editDelScheduleAfterRevision	= true;
	}
	else if($row["RoleName"] == "Allow Export Sales Report")
	{
		$PP_AllowExportSalesReport	= true;
	}
	else if($row["RoleName"] == "Allow Reconciliation Reports")
	{
		$PP_AllowReconciliationReports	= true;
	}
	else if($row["RoleName"] == "Allow Shipping Register Report")
	{
		$PP_AllowShippingRegisterReports = true;
	}
	else if($row["RoleName"] == "Allow Confirm Budget Costsheet")
	{
		$PP_AllowConfirmBudgetCostsheet = true;
	}
	else if($row["RoleName"] == "Create Import Log Batch")
	{
		$PP_CreateImportLogBatch 	= true;
		$PP_manageLCRequest			= true;
	}
	else if($row["RoleName"] == "Allow BOI GRN Note")
	{
		$PP_AllowBOIGRNNote			= true;
		$PP_AllowFirstSaleReport1 	= true;
	}
	else if($row["RoleName"] == "Allow First Sale Summary")
	{
		$PP_AlloFirstSaleSummary	= true;
		$PP_AllowFirstSaleReport1 	= true;
	}
	else if($row["RoleName"] == "Allow First Sale Inter Company Sales")
	{
		$PP_AllowInterCompanySales	= true;
		$PP_AllowFirstSaleReport1 	= true;
	}
	else if($row["RoleName"] == "Allow Reason Codes")
	{
		$PP_AllowReasonCodes			= true;
		$addingMenu 					= true;
	}
	else if($row["RoleName"] == "Allow Trim Inspection Listing")
	{
		$PP_AllowTrimInspectionListing	= true;
		$PP_TrimInspection				= true;
		$inventory 						= true;
	}
	else if($row["RoleName"] == "Allow General Item Transfer")
	{
		$PP_AllowGenItemTransfer		= true;
	}
	else if($row["RoleName"] == "Allow Style Price Change List")
	{
		$PP_AllowPriceList				= true;
		$addingMenu						= true;
	}
	else if($row["RoleName"] == "Allow General Price Change List")
	{
		$PP_AllowGenPriceList			= true;
		$addgeneralItems				= true;
		$addingMenu						= true;
	}
	else if ($row["RoleName"] == "Allow Sample Non Invoice Approval")
	{		
		$PP_AllowSampleNonInvoiceApproval 	= true;
		$manageInvoiceCosting				= true;
		$merchandising						= true;
	}
	else if ($row["RoleName"] == "Allow General Chemical Item Allocation")
	{		
		$PP_AllowGeneralChemicalItemAllocation 	= true;
		$generalInventory						= true;
	}
	else if ($row["RoleName"] == "Allow Production WIP Report")
	{
		$PP_AllowProductionWIPReport 		= true;
		$PP_AllowProduction 				= true;
	}
	else if ($row["RoleName"] == "Allow Cut Quantity Report")
	{
		$PP_AllowCutQuantityReport 			= true;
		$PP_AllowProduction 				= true;
	}
	else if ($row["RoleName"] == "Allow Washing Plan Report")
	{
		$PP_AllowWashingPlanReport 			= true;
		$PP_AllowProduction 				= true;
	}
	else if ($row["RoleName"] == "Allow Size Wise Gate Pass Report")
	{
		$PP_AllowSizeWiseGatePassReport 	= true;
		$PP_AllowProduction 				= true;
	}
	else if ($row["RoleName"] == "Allow Production Summary Report")
	{
		$PP_AllowProductionSummaryReport 	= true;
		$PP_AllowProduction 				= true;
	}
	else if ($row["RoleName"] == "Allow Production Detail Report")
	{
		$PP_AllowProductionDetailReport 	= true;
		$PP_AllowProduction 				= true;
	}
	else if ($row["RoleName"] == "Allow Bundle Movement Report")
	{
		$PP_AllowBundleMovementReport 		= true;
		$PP_AllowProduction 				= true;
	}else if($row["RoleName"] == "Delivery Schedule Report"){
		$viewdeliveryschedule				= true;	
	}
	else if ($row["RoleName"] == "Approve General PO") 
	{
		$approveGeneralPo  = true;
	}
	else if ($row["RoleName"] == "Allow To Increase Unit Price In PO")
	{
		$canIncreaseUnitPriceInGPO = 1;//true;			
	}
	else if ($row["RoleName"] == "Data Transfer to Fast React")
	{
		$allowFastReactDataTransfer = true;	
		$allowExtra = true;		
	}
	elseif ($row["RoleName"] == "Audit") {
		$allowViewAuditReports = true;
	}
	else if ($row["RoleName"] == "Audit Delivery Schedule Report")
	{
		$allowViewDeliveryAuditReport = true;				
	}
	else if ($row["RoleName"] == "Budget Line to Navision")
	{
		$allowBudgetLine = true;				
	}
	else if ($row["RoleName"] == "View Sales Confirmation")
	{
		$viewSalesMonitoring = true;				
	}
	else if ($row["RoleName"] == "Freeze Delivery Schedule")
	{
		$freezeDeliverySchedule = true;				
	}else if($row["RoleName"] == "Approve costsheet below EMP level"){
            $allowCostSheetBelowEPM = true;
        }

	
}
?>