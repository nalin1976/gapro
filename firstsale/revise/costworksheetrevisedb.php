<?php
include "../../Connector.php";
header('Content-Type: text/xml');

$RequestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="load_InvoiceNo")
{
	$sql = "select distinct strInvoiceNo from firstsale_shippingdata where intStatus='1' order by strInvoiceNo ;";
	$result = $db->RunQuery($sql);
	
	while($row=mysql_fetch_array($result))
			{
				$pr_arr.= $row['strInvoiceNo']."|";
				 
			}
			echo $pr_arr;
}
if($RequestType=="loadOrderWiseColor")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$styleId = $_GET["styleId"];
	$ResponseXML = "<XMLLoadColor>\n";
	
	$sql = "select intStyleId,strOrderColorCode from firstsale_shippingdata where intStatus='1'";
	if($styleId!="")
		$sql.=" and intStyleId='$styleId'";
	$sql.=" order by strOrderColorCode";
	
	$result_load =$db->RunQuery($sql);
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderColorCode"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadColor>\n";
		echo $ResponseXML;
}
if($RequestType=="loadOrderNo")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$invNo = $_GET["invNo"];
	$ResponseXML = "<XMLLoadOrderNo>\n";
	
	$sql = "select intStyleId,strOrderNo from firstsale_shippingdata where intStatus='1'";
	if($invNo!="")
		$sql.=" and strInvoiceNo='$invNo'";
	$sql.=" order by strOrderNo";
	$result_load =$db->RunQuery($sql);
	if($invNo=="")
		$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	
		while($row=mysql_fetch_array($result_load))
		{
			$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
		}
		$ResponseXML .= "</XMLLoadOrderNo>\n";
		echo $ResponseXML;
}
if($RequestType=="reviseInvandCost")
{
	$invNo   = $_GET["invNo"];
	$orderNo = $_GET["orderNo"];
	$reason  = $_GET["reason"];
	$boolUpdate = "false";
	$intCancelOrReviseStatus = 1;
	
	$boolcheck1 = InsertToHistory_ShippingData($invNo,$orderNo,$intCancelOrReviseStatus);
	$boolcheck2 = InsertToHistory_Header($orderNo,$intCancelOrReviseStatus,$intCancelOrReviseStatus);
	$boolcheck3 = InsertToHistory_Detail($orderNo);
	$boolcheck4 = InsertToHistory_invoiceProcess($orderNo);
		
	if($boolcheck1==true && $boolcheck2==true && $boolcheck3==true && $boolcheck4==true)
	{
		$boolUpdate = updateShippingData($invNo,$orderNo,$reason);
		if($boolUpdate=="true")
		{
			$boolUpdate = updateCostWorkSheetHeader($orderNo,$reason);
		}
					
	}
	echo $boolUpdate;
	
}
if($RequestType=="reviseInvOnly")
{
	$invNo   = $_GET["invNo"];
	$orderNo = $_GET["orderNo"];
	$reason  = $_GET["reason"];
	$boolUpdate = "false";
	$intCancelOrReviseStatus =2;
	
	$boolcheck1 = InsertToHistory_ShippingData($invNo,$orderNo,$intCancelOrReviseStatus);
	
	if($boolcheck1==true)
	{
		$boolUpdate = updateShippingData($invNo,$orderNo,$reason);
	}
	echo $boolUpdate;
}
if($RequestType=="cancleInvandCost")
{
	$invNo   = $_GET["invNo"];
	$orderNo = $_GET["orderNo"];
	$reason  = $_GET["reason"];
	$boolUpdate = "false";
	$intCancelOrReviseStatus = 3;
	
	$boolcheck1 = InsertToHistory_ShippingData($invNo,$orderNo,$intCancelOrReviseStatus);
	$boolcheck2 = InsertToHistory_Header($orderNo,$intCancelOrReviseStatus);
	$boolcheck3 = InsertToHistory_Detail($orderNo);
	$boolcheck4 = InsertToHistory_invoiceProcess($orderNo);
	
	$ShippingApprovalNo = getOrderApprovalNo($orderNo,'shipping');
	$costingApprovalNo =  getOrderApprovalNo($orderNo,'costing');
	
	$boolUpdate = updateCancleShippingData($invNo,$orderNo,$reason,$ShippingApprovalNo);
		if($boolUpdate=="true")
		{
			$boolUpdate = updateCancleCostWorkSheetHeader($orderNo,$reason,$costingApprovalNo);
			deleteShippingDetails($orderNo,$invNo);
			deleteCostingDetails($orderNo);
		}
	echo $boolUpdate;
}
if($RequestType=="cancleInvOnly")
{
	$invNo   = $_GET["invNo"];
	$orderNo = $_GET["orderNo"];
	$reason  = $_GET["reason"];
	$boolUpdate = "false";
	$intCancelOrReviseStatus =4;
	
	$boolcheck1 = InsertToHistory_ShippingData($invNo,$orderNo,$intCancelOrReviseStatus);
	$ShippingApprovalNo = getOrderApprovalNo($orderNo,'shipping');
	$boolUpdate = updateCancleShippingData($invNo,$orderNo,$reason,$ShippingApprovalNo);
	deleteShippingDetails($orderNo,$invNo);
	echo $boolUpdate;
}
if($RequestType=="chkCostingHasManyInvoices")
{
	$invNo   = $_GET["invNo"];
	$orderNo = $_GET["orderNo"];
	
	$sql = "select dblInvoiceId from firstsale_shippingdata where intStyleId='$orderNo' ";
	$result = $db->RunQuery($sql);
	$numRows = mysql_num_rows($result);
	
	echo $numRows;
	
}
if($RequestType=="loadCancleData")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<loadCancleData>\n";
	
	$sql = "select FCH.strOrderNo,FCH.strColor,date(FCH.dtmCanceledDate) as CanceledDate,
			FCH.strCanceledReason,FS.strInvoiceNo,UA.Name
			from firstsalecostworksheetheader FCH
			inner join firstsale_shippingdata FS on FCH.intStyleId=FS.intStyleId and FCH.strOrderNo=FS.strOrderNo
			inner join useraccounts UA on UA.intUserID=FCH.intCanceledBy 
			where FCH.intStatus=11;";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<OrderNo><![CDATA[" . $row["strOrderNo"]  . "]]></OrderNo>\n";
		$ResponseXML .= "<Color><![CDATA[" . $row["strColor"]  . "]]></Color>\n";
		$ResponseXML .= "<CanceledDate><![CDATA[" . $row["CanceledDate"]  . "]]></CanceledDate>\n";
		$ResponseXML .= "<CanceledReason><![CDATA[" . $row["strCanceledReason"]  . "]]></CanceledReason>\n";
		$ResponseXML .= "<InvoiceNo><![CDATA[" . $row["strInvoiceNo"]  . "]]></InvoiceNo>\n";
		$ResponseXML .= "<CancleBy><![CDATA[" . $row["Name"]  . "]]></CancleBy>\n";
	}
	$ResponseXML .= "</loadCancleData>\n";
	echo $ResponseXML;		
}
function InsertToHistory_ShippingData($invNo,$orderNo,$intCancelOrReviseStatus)
{
	global $db;
	$sql = "insert into history_firstsale_shippingdata 
			(intStyleId, 
			strOrderNo, 
			strOrderColorCode, 
			dblInvoiceId, 
			strInvoiceNo, 
			strComInvNo, 
			intPaytermId, 
			intShipmentTermId, 
			dblVatRate, 
			dtmDate, 
			intStatus, 
			intUserId, 
			intTaxInvoiceConfirmBy, 
			dtmTaxInvoiceConfirmed, 
			intRevisedBy, 
			dtmRevisedDate, 
			strRevisedReason, 
			intCanceledBy, 
			dtmCanceledDate, 
			strCanceledReason, 
			intApprovalNo,
			intCancelOrReviseStatus
			)
			select 	
			intStyleId, 
			strOrderNo, 
			strOrderColorCode, 
			dblInvoiceId, 
			strInvoiceNo, 
			strComInvNo, 
			intPaytermId, 
			intShipmentTermId, 
			dblVatRate, 
			dtmDate, 
			intStatus, 
			intUserId, 
			intTaxInvoiceConfirmBy, 
			dtmTaxInvoiceConfirmed, 
			intRevisedBy, 
			dtmRevisedDate, 
			strRevisedReason, 
			intCanceledBy, 
			dtmCanceledDate, 
			strCanceledReason, 
			intApprovalNo,
			$intCancelOrReviseStatus
			from 
			firstsale_shippingdata 
			where intStyleId='$orderNo' and strInvoiceNo='$invNo'";
	$result=$db->RunQuery($sql);
	if($result)
		return true;
	else
		return false;
}
function InsertToHistory_Header($orderNo,$intCancelOrReviseStatus)
{
	global $db;
	$sql = "insert into history_firstsalecostworksheetheader 
			(intStyleId, 
			strOrderNo, 
			strColor, 
			buyerFOB, 
			intOrderQty, 
			dblSMV, 
			dblPCScarton, 
			dblCMvalue, 
			dtmOTLdate, 
			dtmBPOdate, 
			dtmExFactorydate, 
			dblPreorderFob, 
			dblInvFob, 
			dblFsaleFob, 
			intStatus, 
			dtmDate, 
			intUserId, 
			dtmConfirm, 
			intApprovedBy, 
			dtmReject, 
			intRejectBy, 
			strRejectReason, 
			dtmRevise, 
			intReviseBy, 
			strReviseReason, 
			intCanceledBy, 
			dtmCanceledDate, 
			strCanceledReason, 
			intExtraApprovalRequired, 
			intExtraApprovalStatus, 
			intFirstApproveBy, 
			dtmFirstApproveDate, 
			strFirstApproveRemarks, 
			intSecondApproveBy, 
			dtmSecondApproveDate, 
			strSecondApproveRemarks, 
			intApprovalNo,
			intCancelOrReviseStatus,
			intSendToApprovUser,
			dtmSendToApprove
			)
			select 	
			intStyleId, 
			strOrderNo, 
			strColor, 
			buyerFOB, 
			intOrderQty, 
			dblSMV, 
			dblPCScarton, 
			dblCMvalue, 
			dtmOTLdate, 
			dtmBPOdate, 
			dtmExFactorydate, 
			dblPreorderFob, 
			dblInvFob, 
			dblFsaleFob, 
			intStatus, 
			dtmDate, 
			intUserId, 
			dtmConfirm, 
			intApprovedBy, 
			dtmReject, 
			intRejectBy, 
			strRejectReason, 
			dtmRevise, 
			intReviseBy, 
			strReviseReason, 
			intCanceledBy, 
			dtmCanceledDate, 
			strCanceledReason, 
			intExtraApprovalRequired, 
			intExtraApprovalStatus, 
			intFirstApproveBy, 
			dtmFirstApproveDate, 
			strFirstApproveRemarks, 
			intSecondApproveBy, 
			dtmSecondApproveDate, 
			strSecondApproveRemarks, 
			intApprovalNo,
			$intCancelOrReviseStatus,
			intSendToApprovUser,
			dtmSendToApprove
			from 
			firstsalecostworksheetheader 
			where intStyleId='$orderNo'";
	$result=$db->RunQuery($sql);
	if($result)
		return true;
	else
		return false;
}
function InsertToHistory_Detail($orderNo)
{
	global $db;
	$sql = "insert into history_firstsalecostworksheetdetail 
			(intStyleId, 
			intMatDetailID, 
			dblUnitPrice, 
			reaConPc, 
			dblValue, 
			strItemDescription, 
			strType, 
			intApprovalNo
			)
			select 	
			intStyleId, 
			intMatDetailID, 
			dblUnitPrice, 
			reaConPc, 
			dblValue, 
			strItemDescription, 
			strType,
			(select intApprovalNo from firstsalecostworksheetheader where intStyleId='$orderNo') 
			from 
			firstsalecostworksheetdetail
			where intStyleId='$orderNo' ";
	$result=$db->RunQuery($sql);
	if($result)
		return true;
	else
		return false;
}
function InsertToHistory_invoiceProcess($orderNo)
{
	global $db;
	$sql = " insert into history_firstsale_invprocessdetails (intStyleId,intProcessId,intFScategoryId,dblConpc,dblUnitprice,strUnit,intApprovalNo)
select intStyleId,intProcessId,intFScategoryId,dblConpc,dblUnitprice,strUnit,(select intApprovalNo from firstsalecostworksheetheader where intStyleId='$orderNo')  from firstsale_invprocessdetails where 
intStyleId = '$orderNo' ";
	$result=$db->RunQuery($sql);
	if($result)
		return true;
	else
		return false;
}

function updateShippingData($invNo,$orderNo,$reason)
{
	global $db;
	global $userId;
	$sql_updateShippngData = "update firstsale_shippingdata 
									set
									intStatus = '0' , 
									intRevisedBy = '$userId' , 
									dtmRevisedDate = now() , 
									strRevisedReason = '$reason'  
									where
									intStyleId = '$orderNo'
									and strInvoiceNo = '$invNo'";
	$result_updateShippngData=$db->RunQuery($sql_updateShippngData);
	if($result_updateShippngData)
		return "true";
	else
		return "false";
}
function updateCostWorkSheetHeader($orderNo,$reason)
{
	global $db;
	global $userId;
	$sql_updateCostwkShHeader = "update firstsalecostworksheetheader 
									set
									intStatus = '0' , 
									dtmRevise = now() , 
									intReviseBy = '$userId' , 
									strReviseReason = '$reason'  
									where
									intStyleId = '$orderNo'";
	$result_updateCostwkShHeader=$db->RunQuery($sql_updateCostwkShHeader);
	if($result_updateCostwkShHeader)
		return "true";
	else
		return "false";
}
function updateCancleShippingData($invNo,$orderNo,$reason,$ShippingApprovalNo)
{
	global $db;
	global $userId;
	$sql_updateCancleShippngData = " update history_firstsale_shippingdata 
									set
									intCanceledBy = '$userId' , 
									dtmCanceledDate = now() , 
									strCanceledReason = '$reason'
									where
									intStyleId = '$orderNo' and intApprovalNo = '$ShippingApprovalNo' ";
	$result_updateCancleShippngData=$db->RunQuery($sql_updateCancleShippngData);
	if($result_updateCancleShippngData)
		return "true";
	else
		return "false";
}
function updateCancleCostWorkSheetHeader($orderNo,$reason,$costingApprovalNo)
{
	global $db;
	global $userId;
	$sql_updateCancleCostwkShHeader = "update history_firstsalecostworksheetheader 
									set
									intCanceledBy = '$userId' , 
									dtmCanceledDate = now() , 
									strCanceledReason = '$reason'
									where
									intStyleId = '$orderNo' and intApprovalNo='$costingApprovalNo' ";
	$result_updateCancleCostwkShHeader=$db->RunQuery($sql_updateCancleCostwkShHeader);
	if($result_updateCancleCostwkShHeader)
		return "true";
	else
		return "false";
}
function getOrderApprovalNo($orderNo,$type)
{
	global $db;
	if($type == 'shipping')
		$sql = " select intApprovalNo from firstsale_shippingdata where intStyleId='$orderNo' ";
	else
		$sql = " select intApprovalNo from firstsalecostworksheetheader where intStyleId='$orderNo' ";	
	
	$result = $db->RunQuery($sql);	
	$row = mysql_fetch_array($result);
	
	return $row["intApprovalNo"];	
}

function deleteShippingDetails($orderNo,$invNo)
{
	global $db;
	$sql = " delete from firstsale_shippingdata 	where
	intStyleId ='$orderNo' and strInvoiceNo='$invNo' ";
	$result = $db->RunQuery($sql);	
}

function deleteCostingDetails($orderNo)
{
	global $db;
	$sql = " delete from firstsalecostworksheetheader where 	intStyleId = '$orderNo' ";
	$result = $db->RunQuery($sql);	
}
?>