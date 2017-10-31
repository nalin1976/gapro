<?php
/*BEGIN - PR status
0	= Pending and not send for the approval.
1	= send to factory approval.
2	= factory approved and send to HO approval.
3	= HO approved and ready for raised the General Purchade Order.
10	= Canceled.
END - PR status*/
include "../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];
if($requestType=="URLGetNewSerialNo")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";	
    $No=0;
	$ResponseXML = "<XMLGetNewSerialNo>\n";
	
		$Sql="select intCompanyID,dblPRNo from syscontrol where intCompanyID='$companyId'";		
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblPRNo"];
					$NextNo=$No+1;
					$ReturnYear = date('Y');
					$sqlUpdate="UPDATE syscontrol SET dblPRNo='$NextNo' WHERE intCompanyID='$companyId';";
					$db->executeQuery($sqlUpdate);
					$ResponseXML .= "<admin><![CDATA[TRUE]]></admin>\n";
					$ResponseXML .= "<No><![CDATA[".$No."]]></No>\n";
					$ResponseXML .= "<Year><![CDATA[".$ReturnYear."]]></Year>\n";
					$ResponseXML .= "<PRCode><![CDATA[".CreatePrCode($No)."]]></PRCode>\n";
				}
				
		}
		else
		{
			$ResponseXML .= "<admin><![CDATA[FALSE]]></admin>\n";
		}	
	$ResponseXML .="</XMLGetNewSerialNo>";
	echo $ResponseXML;
}
else if($requestType=="URLSaveHeader")
{
$serialNo		= $_GET["SerialNo"];
$serialYear		= $_GET["SerialYear"];
$prNo			= $_GET["PRNo"];
$supplierId		= $_GET["SupplierId"];
$currencyId		= $_GET["CurrencyId"];
$currRate		= $_GET["CurrRate"];
$deptId			= $_GET["DeptId"];
$attension		= $_GET["Attension"];
$intro			= $_GET["Intro"];
$jobNo			= $_GET["JobNo"];
$discount		= $_GET["Discount"];
$totalValue		= $_GET["TotalValue"];
$totalPRValue	= $_GET["TotalPRValue"];
$costCenterId	= $_GET["CostCenterId"];
$discountValue	= $_GET["DisValue"];
$jobType		= $_GET["JobType"];

$booCheck = IsHeaderAvailable($serialNo,$serialYear);
if($booCheck)
	InsertPRHeader($serialNo,$serialYear,$prNo,$supplierId,$currencyId,$currRate,$deptId,$companyId,$userId,$attension,$intro,$jobNo,$discount,$totalValue,$totalPRValue,$costCenterId,$discountValue,$jobType);
else
	UpdatePRHeader($serialNo,$serialYear,$prNo,$supplierId,$currencyId,$currRate,$deptId,$companyId,$userId,$attension,$intro,$jobNo,$discount,$totalValue,$totalPRValue,$costCenterId,$discountValue,$jobType);
}
else if($requestType=="URLSaveDetails")
{
$serialNo		= $_GET["SerialNo"];
$serialYear		= $_GET["SerialYear"];
$matDetailId	= $_GET["MatId"];
$unit			= $_GET["Unit"];
$unitPrice		= $_GET["UnitPrice"];
$qty			= $_GET["Qty"];
$value			= $_GET["Value"];
$discount		= $_GET["Discount"];
$disValue		= $_GET["DisValue"];
$finalValue		= $_GET["FinalValue"];
$assest			= $_GET["Assest"];
$glAllowId		= $_GET["GLAllowId"];

	$booCheck = IsDetailAvailable($serialNo,$serialYear,$matDetailId);
	if($booCheck)
		InsertPRDetail($serialNo,$serialYear,$matDetailId,$unit,$unitPrice,$qty,$value,$discount,$disValue,$finalValue,$assest,$glAllowId);
	else
		UpdatePRDetail($serialNo,$serialYear,$matDetailId,$unit,$unitPrice,$qty,$value,$discount,$disValue,$finalValue,$assest,$glAllowId);
		
	DeleteGLDetails($serialNo,$serialYear);
}
else if($requestType=="URLSaveGLDetails")
{
$serialNo		= $_GET["SerialNo"];
$serialYear		= $_GET["SerialYear"];
$glAlloId		= $_GET["GLAlloId"];
$year 			= date("Y");
$month 			= date("m");
$currBuAmount	= $_GET["CurrBuAmount"];
$mainCatId		= $_GET["MainCatId"];
$currentBudget	= $_GET["CurrentBudget"];
		InsertGLDetail($serialNo,$serialYear,$glAlloId,$year,$month,$currBuAmount,$companyId,$userId,$mainCatId,$currentBudget);
}
else if($requestType=="URLSendToApproval")
{
$no	= explode('/',$_GET["SerialNo"]);
	$sql="update purchaserequisition_header set intStatus=1 ,intSendToApprovalBy='$userId' ,dtmSendToApprovalDate=now() where intPRNo=$no[1] and intPRYear=$no[0]";
	$result=$db->RunQuery($sql);
	if($result)
		echo 'true';
	else
		echo 'false';
}
else if($requestType=="URLConfirmFirstApproval")
{
$no					= explode('/',$_GET["SerialNo"]);
$ApprovalRemarks	= $_GET["ApprovalRemarks"];
	$sql="update purchaserequisition_header set intStatus=2 ,intFirstApprovedBy='$userId' ,intFirstApprovedDate=now(), strApprovalRemarks='$ApprovalRemarks' where intPRNo=$no[1] and intPRYear=$no[0]";
	$result=$db->RunQuery($sql);
	if($result)
		echo 'true';
	else
		echo 'false';
}
else if($requestType=="URLConfirmSecondApproval")
{
$no					= explode('/',$_GET["SerialNo"]);
$ApprovalRemarks	= $_GET["ApprovalRemarks"];
	
	MoveItemToActualTable($no[0],$no[1]);
	$sql="update purchaserequisition_header set intStatus=3 ,intSecondApprovedBy='$userId' ,intSecondApprovedDate=now(), strApprovalRemarks='$ApprovalRemarks',intApprovalNo=intApprovalNo+1 where intPRNo=$no[1] and intPRYear=$no[0]";
	$result=$db->RunQuery($sql);	
	if($result)
		echo 'true';
	else
		echo 'false';
}
else if($requestType=="URLRejectPR")
{
$no					= explode('/',$_GET["SerialNo"]);
$ApprovalRemarks	= $_GET["ApprovalRemarks"];
	$sql="update purchaserequisition_header set intStatus=0 ,intRejectBy='$userId' ,intRejectDate=now(), strApprovalRemarks='$ApprovalRemarks',intSendToApprovalBy=null,dtmSendToApprovalDate=null,intFirstApprovedBy=null,intFirstApprovedDate=null,intSecondApprovedBy=null,intSecondApprovedDate=null where intPRNo=$no[1] and intPRYear=$no[0]";
	$result=$db->RunQuery($sql);
	if($result)
		echo 'true';
	else
		echo 'false';
}
else if($requestType=="URLCancelPR")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLCancelPR>\n";
$no				= explode('/',$_GET["SerialNo"]);

$booAvailable = ValidateBaforeCancel($no[0],$no[1]);
if($booAvailable)
{
$cancelReason	= $_GET["CancelReason"];
	if(CancelTransaction($no[0],$no[1]))
	{
		$sql="update purchaserequisition_header set intStatus=10,intCancelBy='$userId',dtmCancelDate=now(),strCancelReason='$cancelReason' where intPRNo=$no[1] and intPRYear=$no[0]";
		$result=$db->RunQuery($sql);
		$ResponseXML .= "<Validate><![CDATA[True]]></Validate>\n";
		$ResponseXML .= "<Message><![CDATA[Canceled successfully.]]></Message>\n";
	}
	else
	{
		$ResponseXML .= "<Validate><![CDATA[False]]></Validate>\n";
		$ResponseXML .= "<Message><![CDATA[Sorry !\nError occur while current process is running. Please click 'Cancel' button again.]]></Message>\n";
	}
}
else
{
	$ResponseXML .= "<Validate><![CDATA[False]]></Validate>\n";
	$ResponseXML .= "<Message><![CDATA[Sorry !\nYou cannot cancel this PR.\nPending or confirm purchase orders already available. Cancel the purchase order/s and try again.]]></Message>\n";
}
$ResponseXML .= "</XMLCancelPR>\n";
echo $ResponseXML;
}
else if($requestType=="URLRevisePR")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLRevisePR>\n";
$no				= explode('/',$_GET["SerialNo"]);
$reviseReason	= $_GET["ReviseReason"];

$booAvailable = ValidateBaforeCancel($no[0],$no[1]);
if($booAvailable)
{
	if(CancelTransaction($no[0],$no[1]))
	{
		$sql="update purchaserequisition_header set intStatus=0,intReviseBy='$userId',dtmReviseDate=now(),strReviseReason='$reviseReason',intSendToApprovalBy=null,dtmSendToApprovalDate=null,intFirstApprovedBy=null,intFirstApprovedDate=null,intSecondApprovedBy=null,intSecondApprovedDate=null,intRejectBy=null,intRejectDate=null,intCancelBy=null,dtmCancelDate=null where intPRNo=$no[1] and intPRYear=$no[0]";
		$result=$db->RunQuery($sql);
		
		InsertToHistory_Header($no[0],$no[1]);
		InsertToHistory_Details($no[0],$no[1]);
		InsertTransactionActualToTemp($no[0],$no[1]);
		$ResponseXML .= "<Validate><![CDATA[True]]></Validate>\n";
		$ResponseXML .= "<Message><![CDATA[Revised successfully.]]></Message>\n";
		$ResponseXML .= "<PRNo><![CDATA[".$no[1]."]]></PRNo>\n";
		$ResponseXML .= "<PRYear><![CDATA[".$no[0]."]]></PRYear>\n";
	}
	else
	{
		$ResponseXML .= "<Validate><![CDATA[False]]></Validate>\n";
		$ResponseXML .= "<Message><![CDATA[Sorry !\nError occur while current process is running. Please click 'Revise' button again.]]></Message>\n";
	}
}
else
{
	$ResponseXML .= "<Validate><![CDATA[False]]></Validate>\n";
	$ResponseXML .= "<Message><![CDATA[Sorry !\nYou cannot revise this PR.\nPending or confirm purchase orders already available. Cancel the purchase order/s and try again.]]></Message>\n";
}
$ResponseXML .= "</XMLRevisePR>\n";
echo $ResponseXML;
}
else if($requestType=="URLRemoveItemFromPRTbl")
{
$no		= explode('/',$_GET["SerialNo"]);
$matId	= $_GET["MatId"];
	
	$sql="delete from purchaserequisition_details where intPRNo = '$no[1]' and intPRYear = '$no[0]' and intMatDetailId = '$matId';";
	$result=$db->RunQuery($sql);
}
else if($requestType=="URLRemoveItemFromPRGLTbl")
{
$no			= explode('/',$_GET["SerialNo"]);
$mainCatId	= $_GET["MainCatId"];
$glAllowId	= $_GET["GLAllowId"];
	
	$sql="delete from purchaserequisition_gldetails where intPRNo = '$no[1]' and intPRYear = '$no[0]' and intMainCatId = '$mainCatId' and intGLAllowId = '$glAllowId';";
	$result=$db->RunQuery($sql);
}

//BEGIN - 19-07-2011 - Functions
function IsHeaderAvailable($serialNo,$serialYear)
{
global $db;
	$sql="select count(intPRNo)as count from purchaserequisition_header where intPRNo='$serialNo' and intPRYear='$serialYear'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	if($row["count"]=='0')
		return true;
	else
		return false;
}

function IsDetailAvailable($serialNo,$serialYear,$matId)
{
global $db;
	$sql="select count(intPRNo)as count from purchaserequisition_details where intPRNo=$serialNo and intPRYear=$serialYear and intMatDetailId=$matId";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	if($row["count"]=='0')
		return true;
	else
		return false;
}

function InsertPRHeader($serialNo,$serialYear,$prNo,$supplierId,$currencyId,$currRate,$deptId,$companyId,$userId,$attension,$intro,$jobNo,$discount,$totalValue,$totalPRValue,$costCenterId,$discountValue,$jobType)
{
global $db;
	$sql="insert into purchaserequisition_header (intPRNo,intPRYear,strPRNo,intSupplierId,intCurrencyId,dblCurrencyRate,intDepartmentId,intCompanyId,intRequestBy,dtmRequestDate,strAttension,strRemarks,intStatus,strJobNo,dblDiscount,dblTotalValue,dblTotalPRValue,intCreatedBy,dtmCreatedDate,intCostCenterId,dblDiscountValue,intJobType)values('$serialNo','$serialYear','$prNo','$supplierId','$currencyId','$currRate',$deptId,'$companyId','$userId',now(),'$attension','$intro','0','$jobNo',$discount,$totalValue,$totalPRValue,$userId,now(),$costCenterId,'$discountValue','$jobType');";
	$db->executeQuery($sql);
}

function UpdatePRHeader($serialNo,$serialYear,$prNo,$supplierId,$currencyId,$currRate,$deptId,$companyId,$userId,$attension,$intro,$jobNo,$discount,$totalValue,$totalPRValue,$costCenterId,$discountValue,$jobType)
{
global $db;
	$sql="update purchaserequisition_header set strPRNo = '$prNo',intSupplierId = '$supplierId',intCurrencyId = '$currencyId',dblCurrencyRate = '$currRate',intDepartmentId = '$deptId',intCompanyId = '$companyId',intRequestBy = '$userId',dtmRequestDate = now(),strAttension = '$attension',strRemarks = '$intro',strJobNo = '$jobNo',dblDiscount =$discount ,dblTotalValue=$totalValue , dblTotalPRValue=$totalPRValue ,intCostCenterId='$costCenterId', dblDiscountValue='$discountValue', intJobType='$jobType' where intPRNo = '$serialNo' and intPRYear = '$serialYear';";
	$db->executeQuery($sql);
}

function InsertPRDetail($serialNo,$serialYear,$matDetailId,$unit,$unitPrice,$qty,$value,$discount,$disValue,$finalValue,$assest,$glAllowId)
{
global $db;
	$sql="insert into purchaserequisition_details (intPRNo,intPRYear,intMatDetailId,strUnit,dblUnitPrice,dblQty,dblBalanceQty,dblValue,dblDiscount,dblDiscountValue,dblFinalValue,intAssest,intGLAllowId) values ('$serialNo','$serialYear','$matDetailId','$unit','$unitPrice','$qty','$qty','$value','$discount','$disValue',$finalValue,'$assest','$glAllowId');";
	$db->executeQuery($sql);
}

function UpdatePRDetail($serialNo,$serialYear,$matDetailId,$unit,$unitPrice,$qty,$value,$discount,$disValue,$finalValue,$assest,$glAllowId)
{
global $db;
	$sql="update purchaserequisition_details set strUnit='$unit', dblUnitPrice='$unitPrice', dblQty='$qty', dblBalanceQty='$qty', dblValue='$value' ,dblDiscount='$discount' ,dblDiscountValue='$disValue' ,dblFinalValue='$finalValue' ,intAssest=$assest ,intGLAllowId='$glAllowId' where intPRNo=$serialNo and intPRYear=$serialYear and intMatDetailId=$matDetailId;";
	$db->executeQuery($sql);
}

function InsertGLDetail($serialNo,$serialYear,$glAlloId,$year,$month,$currBuAmount,$companyId,$userId,$mainCatId,$currentBudget)
{
global $db;
$sql="insert into budget_transaction_temp (intSerialYear,intDocumentNo,intDocumentYear,intCompanyId,intBudgetYear,intBudgetMonth,intGLNO,strType,dblQty,intUserId,dtmDate)values('$year','$serialNo','$serialYear','$companyId','$year','$month','$glAlloId','bgtPR','-$currBuAmount','$userId',now());";
$db->executeQuery($sql);

$sql="insert into purchaserequisition_gldetails (intPRNo,intPRYear,intMainCatId,intGLAllowId,dblCurrentBudget)values('$serialNo','$serialYear','$mainCatId','$glAlloId','$currentBudget');";
$db->executeQuery($sql);
}

function DeleteGLDetails($serialNo,$serialYear)
{
global $db;
$sql="delete from budget_transaction_temp where intDocumentNo='$serialNo' and intDocumentYear='$serialYear'";
$db->executeQuery($sql);

$sql="delete from purchaserequisition_gldetails where intPRNo='$serialNo' and intPRYear='$serialYear'";
$db->executeQuery($sql);
}

function CreatePrCode($no)
{
global $db;
global $companyId;
$factoryCode = GetFactoryCode($companyId);
return $factoryCode.'/P-'.date('y').'-'.date('m').'-'.$no;
}

function GetFactoryCode($companyId)
{
global $db;
	$sql="select strComCode from companies where intCompanyID=$companyId";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strComCode"];
	}
}

function MoveItemToActualTable($year,$no)
{
global $db;
$year = date('Y');
$sql="insert into budget_transaction (intSerialYear,intCompanyId,intDocumentNo,intDocumentYear,intBudgetYear,intBudgetMonth,intGLNO,strType,dblQty,intUserId, dtmDate,strReason) select 	$year,intCompanyId,intDocumentNo,intDocumentYear,intBudgetYear,intBudgetMonth,intGLNO,strType,dblQty,intUserId,dtmDate,	strReason from budget_transaction_temp where intDocumentNo='$no' and intDocumentYear='$year'";
$result=$db->RunQuery($sql);

$sql="delete from budget_transaction_temp where intDocumentNo='$no' and intDocumentYear='$year';";
$result=$db->RunQuery($sql);
}

function CancelTransaction($serialYear,$serialNo)
{
global $db;
global $userId;
	$sql="insert into budget_transaction (intSerialYear, intCompanyId, intDocumentNo, intDocumentYear, intBudgetYear, intBudgetMonth, intGLNO, 	strType, dblQty, intUserId, dtmDate, strReason)	select 	intSerialYear, intCompanyId, intDocumentNo, intDocumentYear, intBudgetYear, intBudgetMonth, 	intGLNO, 'CbgtPR', dblQty*-1, $userId, now(), strReason from budget_transaction where intDocumentNo='$serialNo' and intDocumentYear='$serialYear' and strType='bgtPR';";
	return $db->RunQuery($sql);
}

function ValidateBaforeCancel($serialYear,$serialNo)
{
global $db;
$booAvailable = true;
	$sql="select intGenPoNo from generalpurchaseorderdetails where intPRNo='$serialNo' and intPRYear='$serialYear';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$booAvailable = false;
	}
	return $booAvailable;
}

function InsertToHistory_Header($prYear,$prNo)
{
global $db;
	$sql="insert into history_purchaserequisition_header (intApprovalNo, intPRNo, intPRYear, strPRNo, intSupplierId, intCurrencyId, dblCurrencyRate, intDepartmentId, intCompanyId, intCostCenterId, intRequestBy, dtmRequestDate, intSendToApprovalBy, dtmSendToApprovalDate, intFirstApprovedBy, 	intFirstApprovedDate, intSecondApprovedBy, intSecondApprovedDate, intRejectBy, intRejectDate, intCancelBy, dtmCancelDate, intReviseBy, 	dtmReviseDate, strAttension, strRemarks, strJobNo, intStatus, dblDiscount, dblDiscountValue, dblTotalValue, dblTotalPRValue, intCreatedBy, 	dtmCreatedDate, strApprovalRemarks, strCancelReason, strReviseReason) select intApprovalNo, intPRNo, intPRYear, strPRNo, intSupplierId, 	intCurrencyId, dblCurrencyRate, intDepartmentId, intCompanyId, intCostCenterId, intRequestBy, dtmRequestDate, intSendToApprovalBy, 	dtmSendToApprovalDate, intFirstApprovedBy, intFirstApprovedDate, intSecondApprovedBy, intSecondApprovedDate, intRejectBy, intRejectDate, 	intCancelBy, dtmCancelDate, intReviseBy, dtmReviseDate, strAttension, strRemarks, strJobNo, intStatus, dblDiscount, dblDiscountValue, 	dblTotalValue, dblTotalPRValue, intCreatedBy, dtmCreatedDate, strApprovalRemarks, strCancelReason, strReviseReason	from 	purchaserequisition_header where intPRYear='$prYear' and intPRNo='$prNo';";
	$result=$db->RunQuery($sql);
}

function InsertToHistory_Details($prYear,$prNo)
{
global $db;
	$sql="insert into history_purchaserequisition_details (intApprovalNo, intPRNo, intPRYear, intMatDetailId, strUnit, dblUnitPrice, dblQty, dblBalanceQty, dblValue, dblDiscount, dblDiscountValue, dblFinalValue, intAssest) select (select intApprovalNo from purchaserequisition_header where intPRYear='$prYear' and intPRNo='$prNo'), intPRNo, intPRYear, intMatDetailId, strUnit, dblUnitPrice, dblQty, dblBalanceQty, dblValue, dblDiscount, dblDiscountValue, dblFinalValue, intAssest from purchaserequisition_details where intPRYear='$prYear' and intPRNo='$prNo';";
	$result=$db->RunQuery($sql);
}

function InsertTransactionActualToTemp($prYear,$prNo)
{
global $db;
	$sql="insert into budget_transaction_temp (intSerialYear, intCompanyId, intDocumentNo, intDocumentYear, intBudgetYear, intBudgetMonth, intGLNO, 	strType, dblQty, intUserId, dtmDate, strReason)select 	intSerialYear, intCompanyId, intDocumentNo, intDocumentYear, intBudgetYear, intBudgetMonth, 	intGLNO, strType, dblQty, intUserId, dtmDate, strReason	 from budget_transaction where intDocumentYear='$prYear' and intDocumentNo='$prNo';";
	$result=$db->RunQuery($sql);
}
//END - 19-07-2011 - Functions
?>