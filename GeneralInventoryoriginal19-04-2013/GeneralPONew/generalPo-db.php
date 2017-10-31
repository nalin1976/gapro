<?php
session_start();
include "../../Connector.php";
$id=$_GET["id"];

if($id=="saveBulkPoHeader")
{		  
$genPoNo				= $_GET["intGenPONo"];			
$poYear					= $_GET["intYear"];
$supplierId				= $_GET["intSupplierID"];
$dtmDate				= $_GET["dtmDate"];
$dtmDeliveryDate		= $_GET["dtmDeliveryDate"];
$currencyId				= $_GET["strCurrency"];
$totalValue				= $_GET["dblTotalValue"];
$invoiceCompId			= $_GET["intInvoiceComp"];
$deliverToId			= $_GET["intDeliverTo"];
$payTerm				= $_GET["strPayTerm"];
$payMode				= $_GET["intPayMode"];
$instructions			= $_GET["strInstructions"];
$FactoryID				= $_SESSION["FactoryID"];
$userId					= $_SESSION["UserID"];

if($poYear=="")
	$poYear=date("Y");

if($genPoNo=="")
{
	$sql="SELECT dblGPONo FROM syscontrol WHERE intCompanyID='$FactoryID'";
	$result =  $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$genPoNo =  $row["dblGPONo"];
		$sql = "UPDATE syscontrol set dblGPONo=dblGPONo+1 where intCompanyID='$FactoryID'";
		$result = $db->RunQuery($sql);
		break;
	}
}

$booCheck = IsHeaderAvailable($genPoNo,$poYear);
if($booCheck)
	$result_check = InsertPOHeader($genPoNo,$poYear,$supplierId,$dtmDate,$dtmDeliveryDate,$currencyId,$userId,$invoiceCompId,$FactoryID,$deliverToId,$payTerm,$payMode,$instructions,$totalValue);
else
	$result_check = UpdatePOHeader($genPoNo,$poYear,$supplierId,$dtmDate,$dtmDeliveryDate,$currencyId,$userId,$invoiceCompId,$FactoryID,$deliverToId,$payTerm,$payMode,$instructions,$totalValue);

	$SQL_Check = "SELECT * FROM generalpurchaseorderdetails where intGenPoNo='$genPoNo' AND intYear='$poYear'";
	$result_Check = $db->RunQuery($SQL_Check);	
	while($rowCheck = mysql_fetch_array($result_Check))
	{
		$intMatDetailID	= $rowCheck["intMatDetailID"];
	    $dblChkQty		= (float)$rowCheck["dblQty"];
		$intPRNo		= $rowCheck['intPRNo'];
		$intPRYear		= $rowCheck['intPRYear'];
		
		$SQLUpdt = "UPDATE purchaserequisition_details set dblBalanceQty = dblBalanceQty + $dblChkQty
					   WHERE intPRNo = '$intPRNo'
					   AND intPRYear = '$intPRYear' 
					   AND intMatDetailId = '$intMatDetailID' ";
		$ResultUpdt = $db->RunQuery($SQLUpdt);	
	}
	
	
	$delSQL = "DELETE FROM generalpurchaseorderdetails WHERE intGenPONo = '$genPoNo' AND intYear='$poYear'";
	$delResult = $db->RunQuery($delSQL);

	if ($result_check)
		echo "$poYear/$genPoNo";
	else
		echo "Saving-Error";
}

if($id=="saveBulkPoDetails")
{
$count						= $_GET["count"];
$intGenPONo				  	= $_GET["intGenPONo"];
$intYear					= $_GET["intYear"];
$intMatDetailID				= $_GET["intMatDetailID"];
$strRemark					= $_GET["strRemark"];
$strUnit					= $_GET["strUnit"];
$dblUnitPrice				= $_GET["dblUnitPrice"];
$dblQty						= $_GET["dblQty"];
$dblPending					= $_GET["dblPending"];
$dblDisPcnt					= $_GET["dblDisPcnt"];
$intFixed					= $_GET["intFixed"];
$strDeliveryDates			= $_GET["strDeliveryDates"];
$intDeliverTo				= $_GET["intDeliverTo"];
$intMainCatID				= "";
$intSubCatID				= "";
$intPRNo					= $_GET["intPRNo"];
$intPRYear					= $_GET["intPRYear"];
$costCenterID				= $_GET["costCenterID"];
$GLId						= $_GET["GLId"];
$maxExchRate				= $_GET["maxExchRate"];

$dblDisPcnt 				= ($dblDisPcnt == ''?0:$dblDisPcnt);

$intPRNo    				= ($intPRNo == ''? '0':$intPRNo);
$intPRYear  				= ($intPRYear == ''? '0' : $intPRYear);
	//G E T   M A I N C A T   I D   A N D   S U B C A T  I D 
	$SQL = "SELECT intMainCatID,intSubCatID,strItemDescription FROM genmatitemlist WHERE intItemSerial=$intMatDetailID";
	$iResult = $db->RunQuery($SQL);
	while ($row=mysql_fetch_array($iResult))
	{
		$intMainCatID 		= $row["intMainCatID"];
		$intSubCatID		= $row["intSubCatID"];
		$strItemDescription	= $row["strItemDescription"];
	}

	$SQL="insert into generalpurchaseorderdetails (intGenPONo, intYear, intMatDetailID, strUnit, dblUnitPrice, dblExchangeRate, dblQty, dblPending, intDeliverTo, dblDiscountPct, IntFixed, strRemarks, intPRNo, intPRYear,intCostCenterId, intGLAllowId)values ('$intGenPONo', '$intYear', '$intMatDetailID', '$strUnit', '$dblUnitPrice', '$maxExchRate', '$dblQty', '$dblPending', '$intDeliverTo', '$dblDisPcnt', '$intFixed', '$strRemark', $intPRNo, $intPRYear,'$costCenterID', '$GLId');";
	$intSave = $db->RunQuery($SQL);
	if ($intSave==1){
		echo $intSave;
		UpdatePRDetails($intMatDetailID,$intPRNo,$intPRYear,$dblQty);
	}else
		echo "Saving-Error";		
}

if($id=="confirmBulkPo")
{
$intGenPONo		= $_GET["intGenPONo"];
$intYear		= $_GET["intYear"];
$intUserId		= $_SESSION["UserID"];
$dtmDate		= date("Y-m-d");
	
	$SQL =    "UPDATE generalpurchaseorderheader set intStatus = 1,intConfirmedBy = $intUserId,dtmConfirmedDate = '$dtmDate' WHERE 			       intGenPONo = '$intGenPONo' AND intYear = '$intYear' ";			
	$result = $db->RunQuery($SQL);
	echo $result;
	if ($result!=1)
	{
		echo "Saving-Error";
	}
}

if($id=="cancelBulkPo")
{
$intGenPONo	= $_GET["intGenPONo"];
$intYear	= $_GET["intYear"];
$intUserId	= $_SESSION["UserID"];
$dtmDate	= date("Y-m-d");
	
	$row1 = "";
	$SQL = "SELECT strGenGRNNo,intYear FROM gengrnheader WHERE intGenPONo = '$intGenPONo' AND intGenPOYear = $intYear ";
	$result1 = $db->RunQuery($SQL);
	while($row1 = mysql_fetch_array($result1))
	{
		$grnExist .= $row1["intYear"] . "/" . $row1["strGenGRNNo"] . ",";
	}

	if ($grnExist == "")
	{
		$SQL =    "UPDATE generalpurchaseorderheader set intStatus = 10 , intCancelledUserId = $intUserId , dtmCancelledDate = '$dtmDate' WHERE intGenPONo	= '$intGenPONo' AND intYear = '$intYear' ";					   
		$result = $db->RunQuery($SQL);
		echo $result;			
		if ($result!=1)
		{
			echo "Saving-Error";
		}
	}
	else
	{
		echo $grnExist ;
	}
}

if($id=="getExchangeRate")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML  = "";	
$ResponseXML .= "<RateM>\n";
$currencyType = $_GET["curType"];

$sql="SELECT ER.rate FROM exchangerate ER where ER.currencyID='$currencyType' and ER.intStatus=1;";
$result=$db->RunQuery($sql);
$rate = "NA";
while($row = mysql_fetch_array($result))
{
	$rate = $row["rate"];
	
}
$ResponseXML .= "<Rate><![CDATA[" . $rate . "]]></Rate>\n";
$ResponseXML .= "</RateM>";
echo $ResponseXML;
}

function UpdatePRDetails($intMatDetailID,$intPRNo,$intPRYear,$dblQty)
{
global $db;
$sql="update purchaserequisition_details set dblBalanceQty = dblBalanceQty - $dblQty where intPRNo = '$intPRNo' and intPRYear = '$intPRYear' and intMatDetailId = '$intMatDetailID';";
$result=$db->RunQuery($sql);
}

function IsHeaderAvailable($genPoNo,$poYear)
{
global $db;
	$sql="select count(intGenPONo)as count from generalpurchaseorderheader where intGenPONo='$genPoNo' and intYear='$poYear';";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	if($row["count"]=='0')
		return true;
	else
		return false;
}

function InsertPOHeader($genPoNo,$poYear,$supplierId,$dtmDate,$dtmDeliveryDate,$currencyId,$userId,$invoiceCompId,$FactoryID,$deliverToId,$payTerm,$payMode,$instructions,$totalValue)
{
global $db;
		$sql="insert into generalpurchaseorderheader (intGenPONo, intYear, intSupplierID, dtmDate, dtmDeliveryDate, strCurrency, intStatus,  intUserID, intInvoiceComp, intPrintStatus, intCompId, intDeliverTo, intPreviousUserId, strPayTerm, intPayMode, strInstructions, dblPOValue, dblPoBalance,intCreatedBy,dtmCreatedDate) values ('$genPoNo', '$poYear', '$supplierId', now(), '$dtmDeliveryDate', '$currencyId', '0','$userId', '$invoiceCompId', '0', '$FactoryID', '$deliverToId', '0', '$payTerm', '$payMode', '$instructions','$totalValue', '$totalValue','$userId',now());";
		return $db->RunQuery($sql);
}

function UpdatePOHeader($genPoNo,$poYear,$supplierId,$dtmDate,$dtmDeliveryDate,$currencyId,$userId,$invoiceCompId,$FactoryID,$deliverToId,$payTerm,$payMode,$instructions,$totalValue)
{
global $db;
		$sql="update generalpurchaseorderheader set intSupplierID='$supplierId', dtmDate=now(), dtmDeliveryDate='$dtmDeliveryDate', strCurrency='$currencyId', intStatus=0, intUserID='$userId', intInvoiceComp='$invoiceCompId', intPrintStatus=0, intCompId='$FactoryID', intDeliverTo='$deliverToId', strPayTerm='$payTerm', intPayMode='$payMode', strInstructions='$instructions', dblPOValue='$totalValue', dblPoBalance='$totalValue'  where intGenPONo='$genPoNo' and intYear='$poYear';";
		return $db->RunQuery($sql);
}
?>