<?php
session_start();
include "../Connector.php";

$id=$_GET["id"];

if($id=="saveBulkPoHeader")
{		  
$strBulkPONo			= $_GET["strBulkPONo"];			
$intYear				= $_GET["intYear"];
$strSupplierID			= $_GET["strSupplierID"];
$strRemarks				= $_GET["strRemarks"];
$dtDate					= $_GET["dtDate"];
$dtDeliveryDate			= $_GET["dtDeliveryDate"];
$strCurrency			= $_GET["strCurrency"];
$dblTotalValue			= $_GET["dblTotalValue"];
$intInvoiceComp			= $_GET["intInvoiceComp"];
$intDeliverTo			= $_GET["intDeliverTo"];
$strPayTerm				= $_GET["strPayTerm"];
$intPayMode				= $_GET["intPayMode"];
$intShipmentModeId  	= $_GET["intShipmentModeId"];
$intShipmentTermId  	= $_GET["intShipmentTermId"];
$strInstructions		= $_GET["strInstructions"];
$strPINO				= $_GET["strPINO"];
$FactoryID				= $_SESSION["FactoryID"];
$intUserID				= $_SESSION["UserID"];
$dtmETA					= $_GET["ETA"];
$dtmETD 				= $_GET["ETD"];
$merchandiser 			= $_GET["merchandiser"];
	 
if($dtmETA!="")
{
	$ETAUnformat=explode('/', $dtmETA);
	$mysqlFormatETA="'".$ETAUnformat[2]."-".$ETAUnformat[1]."-".$ETAUnformat[0]."'";
}
else
{
	$mysqlFormatETA="Null";
}
if($dtmETD!="")
{
	$ETDUnformat=explode('/', $dtmETD);
	$mysqlFormatETD="'".$ETDUnformat[2]."-".$ETDUnformat[1]."-".$ETDUnformat[0]."'";
}
else
{
	$mysqlFormatETD="Null";
}

	if($strBulkPONo != "")
	{
		$SQL = "update bulkpurchaseorderheader 
				set
				strSupplierID = '$strSupplierID', 
				dtDeliveryDate = '$dtDeliveryDate', 
				strCurrency = '$strCurrency', 
				dblTotalValue = '$dblTotalValue', 
				intStatus = '0',  
				intUserID = '$intUserID', 
				intInvoiceComp = '$intInvoiceComp', 
				intCompId = '$FactoryID', 
				intDeliverTo = '$intDeliverTo', 
				strPayTerm = '$strPayTerm', 
				intPayMode = '$intPayMode', 
				intShipmentModeId = $intShipmentModeId, 
				intShipmentTermID = $intShipmentTermId,
				strInstructions = '$strInstructions', 
				strPINO = '$strPINO',
				dblPoBalance = '$dblTotalValue',
				dtmETA = $mysqlFormatETA,
				dtmETD = $mysqlFormatETD,
				intMerchandiser = '$merchandiser'
				where
				intBulkPoNo = '$strBulkPONo' and intYear = '$intYear';";				
	}
	else
	{
		//start 2010-09-03 get next BPO no from syscontrol ---------------------------------------
	 if($intYear=="")
		$intYear=date("Y");
		
		$sqlM = "SELECT dblBulkPoNo FROM syscontrol WHERE intCompanyID='$FactoryID'";
		$result=$db->RunQuery($sqlM);
		
		while($row = mysql_fetch_array($result))
		{
			$maxID=$row["dblBulkPoNo"];		
		}
		
		if($maxID == '' || is_null($maxID))
		{
			return -1000;
		}
		$intMax=0;
		$intMax=(int)$maxID;
		
		$strBulkPONo=$intMax+1;
		
		$sql1="UPDATE syscontrol SET dblBulkPoNo='$strBulkPONo' WHERE intCompanyID='$FactoryID'";
	
		$db->executeQuery($sql1); 
			
		$SQL="insert into bulkpurchaseorderheader 
		(intBulkPoNo, 
		intYear, 
		strSupplierID, 
		dtDate, 
		dtDeliveryDate, 
		strCurrency, 
		dblTotalValue, 
		intStatus,  
		intUserID, 
		intInvoiceComp, 
		intPrintStatus, 
		intCompId, 
		intDeliverTo, 
		intPreviousUserId, 
		strPayTerm, 
		intPayMode, 
		intShipmentModeId, 
		intShipmentTermID,
		strInstructions, 
		strPINO,
		dblPoBalance,
		dtmETA,
		dtmETD,intMerchandiser)
		values
		('$strBulkPONo', 
		'$intYear', 
		'$strSupplierID', 
		'$dtDate', 
		'$dtDeliveryDate', 
		'$strCurrency', 
		'$dblTotalValue', 
		'0',
		'$intUserID', 
		'$intInvoiceComp', 
		'0', 
		'$FactoryID', 
		'$intDeliverTo', 
		'0', 
		'$strPayTerm', 
		'$intPayMode', 
		$intShipmentModeId, 
		$intShipmentTermId,
		'$strInstructions', 
		'$strPINO',
		'$dblTotalValue',
		$mysqlFormatETA,
		$mysqlFormatETD,'$merchandiser');";			
	}	 

		$intSave = $db->RunQuery($SQL);
		if ($intSave==1)
			echo "***$intYear/$strBulkPONo";
		else
		{
			/////// sending error emails to my mail /////////////////////////
			$_GET["body"]= $SQL;
			include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
			echo "Saving-Error***$intYear/$strBulkPONo";//"Saving-Error";
			
		}
}

if($id=="saveBulkPoDetails")
{
	$count						= $_GET["count"];
	$strBulkPoNo				= $_GET["strBulkPoNo"];
	$intYear					= $_GET["intYear"];
	$strMatDetailID				= $_GET["strMatDetailID"];
	$strColor					= $_GET["strColor"];
	$strSize					= $_GET["strSize"];
	$strUnit					= $_GET["strUnit"];
	$dblUnitPrice				= $_GET["dblUnitPrice"];
	$dblQty						= $_GET["dblQty"];
	$dblPending					= $_GET["dblPending"];
	$dblDlPrice					= $_GET["dblDlPrice"];
	$strDeliveryDates			= $_GET["strDeliveryDates"];
	$intDeliverTo				= $_GET["intDeliverTo"];
	$intMainCatID				= "";
	$intSubCatID				= "";
		
	if($count==1)
	{
		$delSQL = "DELETE FROM bulkpurchaseorderdetails WHERE intBulkPoNo = '$strBulkPoNo' AND intYear='$intYear'";
		$delResult = $db->RunQuery($delSQL);
	}
	
	$SQL="insert into bulkpurchaseorderdetails 
		(	intBulkPoNo, 
			intYear, 			
			intMatDetailId,			
			strColor, 
			strSize, 
			strUnit, 
			dblUnitPrice, 
			dblQty, 
			dblPending, 
			dblDlPrice, 
			strDeliveryDates, 
			intDeliverTo
		)
		values
		(	'$strBulkPoNo', 
			'$intYear', 
			'$strMatDetailID', 
			'$strColor', 
			'$strSize', 
			'$strUnit', 
			'$dblUnitPrice', 
			'$dblQty', 
			'$dblPending', 
			'$dblDlPrice', 
			'$strDeliveryDates', 
			'$intDeliverTo');";
	
		
		$intSave = $db->RunQuery($SQL);

		if ($intSave==1)
			echo $intSave;
		else
		{
			/////// sending error emails to my mail /////////////////////////
			$_GET["body"]= $SQL;
			include "errorEmail.php";
			/////////////////////////////////////////////////////////////////
			echo "Saving-Error";
			
		}
}

if($id=="confirmBulkPo")
{
$strBulkPoNo	= $_GET["strBulkPoNo"];
$intYear		= $_GET["intYear"];
$intUserId		= $_SESSION["UserID"];
$dtmDate		= date("Y-m-d");
	
	$SQL =    "UPDATE bulkpurchaseorderheader set intStatus = 1 , intConfirmedBy = $intUserId ,dtmConfirmedDate = '$dtmDate' WHERE intBulkPoNo = '$strBulkPoNo' AND intYear = '$intYear';";				   
	$result = $db->RunQuery($SQL);
	$str = $result.'-'.$intYear.'-'.$strBulkPoNo;
	echo $str;
	if ($result!=1)
	{
	/////// sending error emails to my mail /////////////////////////
	$_GET["body"]= $SQL;
	include "errorEmail.php";
	/////////////////////////////////////////////////////////////////
	}
}

if($id=="cancelBulkPo")
{
$strBulkPoNo		= $_GET["strBulkPoNo"];
$intYear			= $_GET["intYear"];
$intUserId			= $_SESSION["UserID"];
$dtmDate			= date("Y-m-d");
$cancelReason		= $_GET["CancelReason"];
	
	$sql="SELECT intBulkPoNo FROM bulkgrnheader where intBulkPoNo='$strBulkPoNo' and intBulkPoYear='$intYear' and intStatus=1;";
	$result=$db->RunQuery($sql);
	$count = mysql_num_rows($result);
	
	if($count<=0)
	{
		$SQL = "UPDATE bulkpurchaseorderheader 
				set intStatus 	= 10,
				strCancelUserId	= $intUserId,
				dtCanceledDate  = now(),
				strCancelReason = '$cancelReason'	
				WHERE
				intBulkPoNo	=	'$strBulkPoNo' 
				AND intYear	= 	'$intYear' ";				   
		$result = $db->RunQuery($SQL);
		echo $result.'-'.$intYear.'-'.$strBulkPoNo;//"Bulk po is canceld";
	}
	else
	{
		echo "Sorry!\nYou cannot cancel this po\nGrn raised to this po.Cancel the grn and try";
	}		
}
if($id=="Revise")
{
		$strBulkPoNo	= $_GET["strBulkPoNo"];
		$intYear		= $_GET["intYear"];
		$intUserId		= $_SESSION["UserID"];	

$sql="SELECT intBulkPoNo FROM bulkgrnheader where intBulkPoNo='$strBulkPoNo' and intBulkPoYear='$intYear' and intStatus=1;";
$result=$db->RunQuery($sql);
$count = mysql_num_rows($result);

if($count<=0)
{
$SQL = "UPDATE bulkpurchaseorderheader 
		set intStatus = 0,
		intReviseBy	  = $intUserId,
		dtmReviseDate = now()	
		WHERE
		intBulkPoNo	=	'$strBulkPoNo' 
		AND intYear		= 	'$intYear' ";
					   
		$result = $db->RunQuery($SQL);
		echo true;
}
else
{
	echo false;
}		
}
?>