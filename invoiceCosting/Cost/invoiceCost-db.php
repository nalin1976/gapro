<?php
session_start();
include "../../Connector.php";
$id=$_GET["id"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($id=="saveInvoiceHeader")
{		  
$styleId	    	= $_GET["cbointStyleId"];			
$orderNo			= $_GET["strOrderNo"];
$strFabric			= $_GET["strFabric"];
$dblNewCM			= $_GET["dblNewCM"];
$strDescription		= $_GET["strDescription"];
$dblFob		    	= $_GET["dblFob"];
$dblQty				= $_GET["dblQty"];
$reduceCM			= $_GET["ReduceCM"];

	$delSQL = "DELETE FROM invoicecostingdetails WHERE intStyleId = '$styleId'";
	$delResult = $db->RunQuery($delSQL);

	$isOrderNoAvailable = IsOrderNoAvailable($styleId);
	
	if($isOrderNoAvailable)
		UpdateInvoiceCostHeader($styleId,$orderNo,$strFabric,$dblNewCM,$strDescription,$dblFob,$dblQty,$reduceCM);
	else
		InsertInvoiceCostHeader($styleId,$orderNo,$strFabric,$dblNewCM,$strDescription,$dblFob,$dblQty,$reduceCM);
}

if($id=="saveInvoiceCostDetails")
{
	$count				= $_GET["count"];
	$cbointStyleId		= $_GET["cbointStyleId"];
	$intOrigin			= $_GET["intOrigin"];
	$strItemCode		= $_GET["strItemCode"];
	$reaConPC			= $_GET["reaConPC"];
	$reaWastage			= $_GET["reaWastage"];
	$dblUnitPrice		= $_GET["dblUnitPrice"];
	$dblValue			= $_GET["dblValue"];
	$category			= $_GET["category"];
	$finPercent			= $_GET["finPercent"];
	$diferent			= $_GET["diferent"];

	$SQL="INSERT INTO invoicecostingdetails (intStyleId,intOrigin,strItemCode,reaConPC,reaWastage,dblUnitPrice,dblValue,dblFinance,strType,		intDifference) VALUES('$cbointStyleId','$intOrigin','$strItemCode','$reaConPC','$reaWastage','$dblUnitPrice','$dblValue','$finPercent',		'$category','$diferent')";
	$intSave = $db->RunQuery($SQL);
	if ($intSave==1)
		echo $intSave;
	else
		echo "Saving-Error";			
}

if($id=="saveInvoiceCostConfirmedHeader")
	{		  
	$cbointStyleId	    = $_GET["cbointStyleId"];			
	$strOrderNo		= $_GET["strOrderNo"];
	$strFabric			= $_GET["strFabric"];
	$dblNewCM			= $_GET["dblNewCM"];
	$strDescription	= $_GET["strDescription"];
	$dblFob		    = $_GET["dblFob"];
	$dblQty			= $_GET["dblQty"];
	$intStatus        = '1';
	
	$delSQL = "DELETE FROM invoicecostingheader WHERE intStyleId = '$cbointStyleId'";
	$delResult = $db->RunQuery($delSQL);
	
	$delSQL = "DELETE FROM invoicecostingdetails WHERE intStyleId = '$cbointStyleId'";
	$delResult = $db->RunQuery($delSQL);
	
	$SQL="insert into invoicecostingheader 
		(intStyleId, 
		strOrderNo, 
		strFabric, 
		dblNewCM, 
		strDescription, 
		dblFob, 
		dblQty,
		intStatus)
		values
		('$cbointStyleId', 
		'$strOrderNo', 
		'$strFabric', 
		'$dblNewCM', 
		'$strDescription', 
		'$dblFob', 
		'$dblQty',
		'$intStatus')";
	$intSave = $db->RunQuery($SQL);
	if ($intSave==1)
		echo "$cbointStyleId";
	else
		echo "Saving-Error";//"Saving-Error";
}
elseif($id=="ConfirmInvoiceCostSheet")
{
	$orderId		= $_GET["orderId"];
	$sql="update invoicecostingheader set intStatus=1,intConfirmBy='$userId',intConfirmDate=now(),intApprovalNo=intApprovalNo+1 where intStyleId='$orderId'";
	$intSave = $db->RunQuery($sql);
	if ($intSave==1)
		echo "1";
	else
		echo "0";
}
#############-----------01-11-2010-------- lasantha addProcesses##############################
if($id=="addPrc"){
	$StyleId 	= $_GET['StyleId'];
	$ProcessId 	= $_GET['ProcessId'];
	$UnitPrice 	= $_GET['UnitPrice'];
	$tag		= $_GET['tag'];
	$sqlChk="SELECT intProcessId FROM invoicecostingproceses WHERE intStyleId='$StyleId';";
			$resChk=$db->RunQuery($sqlChk);
			$nR=mysql_num_rows($resChk);
			if($nR>0 && $tag==1){
				$sqlDel="DELETE FROM invoicecostingproceses WHERE intStyleId='$StyleId';";
				$resD=$db->RunQuery($sqlDel);
			}
			
			$sqlPrc="INSERT INTO invoicecostingproceses(intStyleId,intProcessId,dblUnitPrice)VALUES('$StyleId','$ProcessId','$UnitPrice');";
			//echo $sqlPrc;
			$res=$db->RunQuery($sqlPrc);
			if($res==1){
				echo $res;
			}
}
if($id=="srcPrc"){
	$StyleId 	= $_GET['StyleId'];	
	$prc		= $_GET['prc'];		
			$sqlChk="SELECT intProcessId FROM invoicecostingproceses WHERE intStyleId='$StyleId';";
			$resChk=$db->RunQuery($sqlChk);
			//echo $sqlChk;
			$nR=mysql_num_rows($resChk);
			$sql="";
			if($nR>0){
					$sql="SELECT intSerialNo,strDescription FROM was_dryprocess WHERE intStatus='1' AND strDescription like '%$prc%' AND intSerialNo NOT IN 
						(SELECT intProcessId FROM invoicecostingproceses WHERE intStyleId='$StyleId');";
						//echo $sql;
				}
			else{
					$sql="SELECT intSerialNo,strDescription FROM was_dryprocess WHERE intStatus='1' AND  strDescription like '%$prc%' AND intSerialNo NOT IN 
						(SELECT intDryProssId FROM was_washpricedetails WHERE intStyleId='$StyleId');";
						//echo $sql;
			}
			//echo $sql;
			$res=$db->RunQuery($sql);
			$cls="";
			$count=0;
			$htm="";
			while($row=mysql_fetch_array($res)){
				($count%2==0)?$cls="grid_raw":$cls="grid_raw2";
				$htm.="<tr> <td style=\"width:30px;\" class=\"".$cls."\" id=\"".$row['intSerialNo']."\">";
				$htm.="<input type=\"checkbox\" /></td>";
				$htm.="<td style=\"width:150px;text-align:left;\" class=\"".$cls."\" >".$row['strDescription']."</td></tr>";/**/
				$count++;
			}
			echo $htm;
}
if($id=="delPrc"){
	$prcId		=	$_GET['prcId'];
	$StyleId	=	$_GET['styId'];
	$sqlDel="DELETE FROM invoicecostingproceses WHERE  intStyleId='$StyleId' AND intProcessId='$prcId';";
	echo $sqlDel;
	$res=$db->RunQuery($sqlDel);
	if($res==1){
		echo $res;
	}
}
############################-------End----------#################

//BEGIN - 17-06-2011
if($id=="URLRevisePO")
{
$orderId = $_GET["OrderId"];
$reason = $_GET["reason"];
	
	CopyDetailToHistory_header($orderId);
	CopyDetailToHistory_detail($orderId);
	CopyDetailToHistory_Process($orderId);
	
	$sql="update invoicecostingheader set intStatus=0,intRevisedBy='$userId',dtmRevisedDate=now(),intConfirmBy=null,intConfirmDate=null, strRevisedReason='$reason' where intStyleId='$orderId'";
	$result=$db->RunQuery($sql);
	if($result)
		echo "true";
	else
		echo "false";
}
//END - 17-06-2011
//start 2011-09-29 check delivery lead time before confirm invoice costing
if($id=="validateDelDateBeforeConfirmInvCosting")
{
	$orderId = $_GET["orderId"];
	$leadDays = getDeliverLeadTime();
	
	$sql = " select * from deliveryschedule where intStyleId=$orderId
having max(date(dtDateofDelivery))>= date(date_add(now(),INTERVAL $leadDays DAY)) ";
	 $result = $db->CheckRecordAvailability($sql);
	 
	 if($result==1)
	 {
	 	echo "true";
	 }
	else
	{
		$maxDelDate = getMaxDeliveryDate($orderId);
		$str = " Sorry! You can't confirm invoice costing.\n Delivery lead time is $leadDays days \n Delivery Date $maxDelDate \n You should confirm invoice costing  $leadDays days before Delivery date. ";
		echo $str;
	}	
}

//end 2011-09-29 check delivery lead time before confirm invoice costing

if($id=="CheckFSCostingAvailability")
{
	$orderId = $_GET["orderId"];
	$sql = " select intStyleId from firstsalecostworksheetheader where intStyleId='$orderId' ";
	$result = $db->CheckRecordAvailability($sql);
	 
	if($result ==1) 
		echo 'true';
	else
		echo 'false';	
}
//BEGIN - Functions ---------------------------------------------------------------------------------------------------------------------------------
if($id=="URLApproveInvoice")
{
	$orderId = $_GET["OrderId"];
	$sql = "update invoicecostingheader set intStatus=1 where intStyleId=$orderId";
	$result = $db->RunQuery($sql);
	 
	if($result ==1) 
		echo 'true';
	else
		echo 'false';	
}

function IsOrderNoAvailable($styleId)
{
global $db;
$booAvailable = false;
	$sql="select intStyleId from invoicecostingheader where intStyleId='$styleId';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$booAvailable = true;
	}
return $booAvailable;
}

function UpdateInvoiceCostHeader($styleId,$orderNo,$fabricDesc,$newCM,$remarks,$fob,$qty,$reduceCM)
{
global $db;
global $userId;

	$sql="update invoicecostingheader set intStyleId = '$styleId', strOrderNo = '$orderNo', dblFOB = '$fob', dblQty = '$qty', strFabric = '$fabricDesc', dblNewCM = '$newCM', dblReduceCM = '$reduceCM', strDescription = '$remarks', intStatus = '0', intUserId = '$userId', dtmDate = now() where intStyleId = '$styleId';";
	$result=$db->RunQuery($sql);
	if($result)
		echo "Saved";
	else
		echo "Saving-Error";
}

function InsertInvoiceCostHeader($styleId,$orderNo,$fabricDesc,$newCM,$remarks,$fob,$qty,$reduceCM)
{
global $db;
global $userId;

	$sql="insert into invoicecostingheader (intStyleId, strOrderNo, dblFOB, dblQty, strFabric, dblNewCM, dblReduceCM, strDescription, intStatus, intUserId, 	dtmDate, intCreateBy, dtmCreateDate) values('$styleId', '$orderNo', '$fob', '$qty', '$fabricDesc', '$newCM', '$reduceCM', '$remarks', '0', '$userId', 	now(), '$userId', now());";
	$result=$db->RunQuery($sql);
	if($result)
		echo "Saved";
	else
		echo "Saving-Error";
}

function CopyDetailToHistory_header($orderId)
{
global $db;
	$sql="insert into history_invoicecostingheader (intApprovalNo, intStyleId, strOrderNo, dblFOB, dblQty, strFabric, dblNewCM, dblReduceCM, strDescription, 	intStatus, intUserId, dtmDate, intConfirmBy, intConfirmDate, intRevisedBy, dtmRevisedDate, intCreateBy, dtmCreateDate,dblTotalCostValue,strRevisedReason) select 	intApprovalNo,	intStyleId, strOrderNo, dblFOB, dblQty, strFabric, dblNewCM, dblReduceCM, strDescription, intStatus, intUserId, dtmDate, intConfirmBy, intConfirmDate, intRevisedBy, dtmRevisedDate, intCreateBy, dtmCreateDate,dblTotalCostValue,strRevisedReason from invoicecostingheader where intStyleId='$orderId';";
	$result=$db->RunQuery($sql);
}

function CopyDetailToHistory_detail($orderId)
{
global $db;
	$sql="insert into history_invoicecostingdetails (intApprovalNo, intStyleId, intOrigin, strItemCode, reaConPc, reaWastage, dblUnitPrice, dblValue, 	dblFinance, strType, intDifference)	select 	(select intApprovalNo from invoicecostingheader where intStyleId='$orderId'),intStyleId, intOrigin, 	strItemCode, reaConPc, reaWastage, dblUnitPrice, dblValue, dblFinance, strType, intDifference from 	invoicecostingdetails where intStyleId='$orderId';";
$result=$db->RunQuery($sql);
}
function CopyDetailToHistory_Process($orderId)
{
global $db;
	$sql = "insert into history_invoicecostingproceses (intStyleId,intProcessId,dblUnitPrice)
select intStyleId,intProcessId,dblUnitPrice from invoicecostingproceses where intStyleId='$orderId' ";
	$result=$db->RunQuery($sql);
}
function getDeliverLeadTime()
{
	global $db;
	$sql = " select strValue from settings  where strKey='SetDeliveryLeadTimeBrforeConfimInvoiceCosting' ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strValue"];
}
function getMaxDeliveryDate($orderId)
{
	global $db;
	$sql = " select max(date(dtDateofDelivery)) as DelDate from deliveryschedule where intStyleId='$orderId' ";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["DelDate"];
}
//END - Functions ---------------------------------------------------------------------------------------------------------------------------------
?>