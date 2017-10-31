<?php 
include "../Connector.php";
$msServer = "SHANKA-PC";
$msUser = "sa"; 
$msPass = "sa";
$msDb = "eplan";

$msCon = mssql_connect($msServer);
$msSelected = mssql_select_db($msDb,$msCon);

$requestType = $_GET["RequestType"];	
if($requestType=="Save")
{
$orderNo	= $_GET["OrderNo"];
	$sql="SELECT strOrderNo,strStyleID,strCompanyID,strProductID,strDescription,strCustomerID,dblQuantity,strCoordinator,intStatus,strCustRefNo,strQuotaCat,dblMaxTrmCost,dblSMV,dtDate,dblSmvRate,dblQuota, dblFOB, dblFinance, strUserID, strApprovedBy, strAppRemarks,dtmAppdate,strAppMail,bytOrderType,strImagePath,dblExQty,intOrdDays,intFinPc,intCopied,intApprovalNo,strCancelledReason, dtmCancelledDate, strCancelledBy, dblConfirmedPrice, strConPriceCurrency,dblCommission, dblEfficiencyLevel, dblCostPerMinute, dtmDateSentForApprovals, strSentForApprovalsTo, strDeliverTo, dblFreightCharges, dblECSCharge,dblLabourCost, dblBuyingOfficeId, strDivisionId, strSeasonId, strRPTMark, dblSubContractQty, dblSubContractSMV, dblSubContractRate, dblSubTransportCost,dblSubCANDM, intLineNos, dblProfit, dblUPCharges, strUPCharDes, dblFabFinance, dblTrimFinance, dblNewCm, dblNewSMV, strFirstApprovedBy, dtmFirstAppDate,dblOTLQuantity, dtOTLPODate, strOTLPOID, dblOTLPOFOB FROM Orders WHERE strStyleID = '$orderNo'";
	$result=mssql_query($sql);
	while($row=mssql_fetch_array($result))
	{
		CheckOrderAvailable(trim($row["strOrderNo"]),trim($row["strStyleID"]),$row["strCompanyID"],$row["strProductID"],trim($row["strDescription"]),$row["strCustomerID"],$row["dblQuantity"],$row["strCoordinator"],$row["intStatus"],$row["strCustRefNo"],$row["strQuotaCat"],$row["dblMaxTrmCost"],$row["dblSMV"],$row["dtDate"],$row["dblSmvRate"],$row["dblQuota"],$row["dblFOB"],$row["dblFinance"],$row["strUserID"],$row["strApprovedBy"],$row["strAppRemarks"],$row["dtmAppdate"],$row["strAppMail"],$row["bytOrderType"],$row["strImagePath"],$row["dblExQty"],$row["intOrdDays"],$row["intFinPc"],$row["intCopied"],$row["intApprovalNo"],$row["strCancelledReason"],$row["dtmCancelledDate"],$row["strCancelledBy"],$row["dblConfirmedPrice"],$row["strConPriceCurrency"],$row["dblCommission"],$row["dblEfficiencyLevel"],$row["dblCostPerMinute"],$row["dtmDateSentForApprovals"],$row["strSentForApprovalsTo"],$row["strDeliverTo"],$row["dblFreightCharges"],$row["dblECSCharge"],$row["dblLabourCost"],$row["dblBuyingOfficeId"],$row["strDivisionId"],$row["strSeasonId"],$row["strRPTMark"],$row["dblSubContractQty"],$row["dblSubContractSMV"],$row["dblSubContractRate"],$row["dblSubTransportCost"],$row["dblSubCANDM"],$row["intLineNos"],$row["dblProfit"],$row["dblUPCharges"],$row["strUPCharDes"],$row["dblFabFinance"],$row["dblTrimFinance"],$row["dblNewCm"],$row["dblNewSMV"],$row["strFirstApprovedBy"],$row["dtmFirstAppDate"],$row["dblOTLQuantity"],$row["dtOTLPODate"],$row["strOTLPOID"],$row["dblOTLPOFOB"]);
	}
	
	$sql="SELECT strStyleID,strBuyerPONO,strColor,strSize,dblQty,dblExQty FROM StyleRatio where strStyleID='$orderNo'";
	$result=mssql_query($sql);
	while($row=mssql_fetch_array($result))
	{
		InserIntoStyleRatio(trim($row["strStyleID"]),trim($row["strBuyerPONO"]),trim($row["strColor"]),trim($row["strSize"]),$row["dblQty"],$row["dblExQty"]);	
	}
echo "Data transfered successful.";
}

//Start - Functions
function CheckOrderAvailable($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$c10,$c11,$c12,$c13,$c14,$c15,$c16,$c17,$c18,$c19,$c20,$c21,$c22,$c23,$c24,$c25,$c26,$c27,$c28,$c29,$c30,$c31,$c32,$c33,$c34,$c35,$c36,$c37,$c38,$c39,$c40,$c41,$c42,$c43,$c44,$c45,$c46,$c47,$c48,$c49,$c50,$c51,$c52,$c53,$c54,$c55,$c56,$c57,$c58,$c59,$c60,$c61,$c62,$c63,$c64,$c65,$c66,$c67)
{
global $db;
$boo = false;
	$sql="select intStyleId from orders where strOrderNo='$c2'";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$boo = true;
		$styleId	= $row["intStyleId"];
	}
	
	if($boo)
	{
		UpdateIntoOrders($styleId,$c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$c10,$c11,$c12,$c13,$c14,$c15,$c16,$c17,$c18,$c19,$c20,$c21,$c22,$c23,$c24,$c25,$c26,$c27,$c28,$c29,$c30,$c31,$c32,$c33,$c34,$c35,$c36,$c37,$c38,$c39,$c40,$c41,$c42,$c43,$c44,$c45,$c46,$c47,$c48,$c49,$c50,$c51,$c52,$c53,$c54,$c55,$c56,$c57,$c58,$c59,$c60,$c61,$c62,$c63,$c64,$c65,$c66,$c67);
	}
	else
	{
		InsertIntoOrders($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$c10,$c11,$c12,$c13,$c14,$c15,$c16,$c17,$c18,$c19,$c20,$c21,$c22,$c23,$c24,$c25,$c26,$c27,$c28,$c29,$c30,$c31,$c32,$c33,$c34,$c35,$c36,$c37,$c38,$c39,$c40,$c41,$c42,$c43,$c44,$c45,$c46,$c47,$c48,$c49,$c50,$c51,$c52,$c53,$c54,$c55,$c56,$c57,$c58,$c59,$c60,$c61,$c62,$c63,$c64,$c65,$c66,$c67);
	}
}

function InsertIntoOrders($c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$c10,$c11,$c12,$c13,$c14,$c15,$c16,$c17,$c18,$c19,$c20,$c21,$c22,$c23,$c24,$c25,$c26,$c27,$c28,$c29,$c30,$c31,$c32,$c33,$c34,$c35,$c36,$c37,$c38,$c39,$c40,$c41,$c42,$c43,$c44,$c45,$c46,$c47,$c48,$c49,$c50,$c51,$c52,$c53,$c54,$c55,$c56,$c57,$c58,$c59,$c60,$c61,$c62,$c63,$c64,$c65,$c66,$c67)
{
global $db;
$c14	= ArrangeDate($c14);
$c32	= ArrangeDate($c32);
$c39	= ArrangeDate($c39);
$c63	= ArrangeDate($c63);
$c3		= GetCompanyId($c3);
$c6		= GetBuyerId($c6);
$c45	= GetBuyingOfficeId($c45);
$c46	= GetBuyerDivisionId($c46);
$c47	= GetSeasonId($c47);
$c8 	= 1 ;// Dammy user
$c43     = ($c43 == '' ? 0:$c43);
$c44     = ($c43 == '' ? 0:$c44);
$sql="insert into orders (strOrderNo,strStyle,intCompanyID,strDescription,intBuyerID,intQty,intCoordinator,intStatus,strCustomerRefNo,reaSMV,dtmDate,reaSMVRate,reaFOB,reaFinance,intUserID,intApprovedBy,strAppRemarks,dtmAppDate,reaExPercentage,reaFinPercntage,intApprovalNo,strRevisedReason,strRevisedDate,intRevisedBy,reaConfirmedPrice,strConPriceCurrency,reaCommission,reaEfficiencyLevel,reaCostPerMinute,dtmDateSentForApprovals,intSentForApprovalsTo,strDeliverTo,reaFreightCharges,reaECSCharge,reaLabourCost,intBuyingOfficeId,intDivisionId,intSeasonId,strRPTMark,intSubContractQty,reaSubContractSMV,reaSubContractRate,reaSubTransportCost,reaSubCM,intLineNos,reaProfit,reaUPCharges,strUPChargeDescription,reaFabFinance,reaTrimFinance,intFirstApprovedBy,dtmFirstAppDate,intMsSql,strScheduleMethod,orderUnit,productSubCategory,dblFacProfit) values(trim('$c2'),trim('$c1'),$c3,'$c5',$c6,'$c7','$c8','$c9','$c10','$c13',now(),'$c15','$c17','$c18','$c8','$c8','$c21',now(),'$c26','$c28','$c30',null,now(),'$c8','$c34','$c35','$c36','$c37','$c38',now(),'$c8','$c41','$c42','$c43','$c44',$c45,$c46,$c47,'$c48','$c49',	'$c50','$c51','$c52','$c53','$c54','$c55','$c56','$c57','$c58','$c59','$c8',now(),'0','SE','','','$c55');";
$result = $db->RunQuery($sql);
}

function UpdateIntoOrders($styleId,$c1,$c2,$c3,$c4,$c5,$c6,$c7,$c8,$c9,$c10,$c11,$c12,$c13,$c14,$c15,$c16,$c17,$c18,$c19,$c20,$c21,$c22,$c23,$c24,$c25,$c26,$c27,$c28,$c29,$c30,$c31,$c32,$c33,$c34,$c35,$c36,$c37,$c38,$c39,$c40,$c41,$c42,$c43,$c44,$c45,$c46,$c47,$c48,$c49,$c50,$c51,$c52,$c53,$c54,$c55,$c56,$c57,$c58,$c59,$c60,$c61,$c62,$c63,$c64,$c65,$c66,$c67)
{
$c3		= GetCompanyId($c3);
$c6		= GetBuyerId($c6);
$c45	= GetBuyingOfficeId($c45);
$c46	= GetBuyerDivisionId($c46);
$c47	= GetSeasonId($c47);
$c8 	= 1 ;// Dammy user
global $db;
	$sql="update orders 
	set
	strOrderNo = '$c2' , 
	strStyle = '$c1' , 
	intCompanyID = '$c3' , 
	strDescription = '$c5' , 
	intBuyerID = '$c6' , 
	intQty = '$c7' , 
	intCoordinator = '$c8' , 
	intStatus = '$c9' , 
	reaSMV = '$c13' , 
	intUserID = '$c8' , 
	reaExPercentage = '$c26' , 
	reaEfficiencyLevel = '$c37' , 
	intBuyingOfficeId = $c45 , 
	intDivisionId = $c46 , 
	intSeasonId = $c47
	where
	intStyleId = '$styleId' ;";
	$result = $db->RunQuery($sql);
}

function InserIntoStyleRatio($c1,$c2,$c3,$c4,$c5,$c6)
{
global $db;
$userId 	= 1 ;// Dammy user
$styleId	= GetStyleId($c1);
$sql="insert into styleratio (intStyleId,strBuyerPONO,strColor,strSize,dblQty,dblExQty,strUserId)values('$styleId','$c2','$c3','$c4','$c5','$c6','$userId');";
$result = $db->RunQuery($sql);
}

function GetStyleId($c1)
{
global $db;
$sql="select intStyleId from orders where strOrderNo='$c1'";
$result = $db->RunQuery($sql);
$row = mysql_fetch_array($result);
return $row["intStyleId"];
}

function ArrangeDate($date)
{
	switch($date)
	{
		case '':
			$a = '0000-00-00 00:00:00';
		default:
			$a	= $date;
	}
	return $a;
}

function GetCompanyId($companyId)
{
	switch($companyId)
	{
		case 'ORIT-TRADE':
			$c3 = 1;
		default:
			$c3	= 1;
	}
	return $c3;
}

function GetBuyerId($buyerId)
{
	switch($buyerId)
	{
		case '4':
			$c6 = 4;
		case '3':
			$c6 = 3;
		default :
			$c6 = 3;
	}
	return $c6;
}

function GetBuyingOfficeId($boId)
{
	switch($boId)
	{
		case '1' :
			$c45 = 1;
		case '0' :
			$c45 = 'null';
		default :
			$c45 = 'null';
	}
	return $c45;
}

function GetBuyerDivisionId($bdId)
{
	switch($bdId)
	{
		case '19' :
			$c46  = 19;
		case '48' :
			$c46  = 48;
		case '46' :
			$c46  = 46;
		case '16' :
			$c46  = 16;
		case '8' :
			$c46  = 8;
		case '9' :
			$c46  = 9;
		default   :
			$c46  = 'null';
	}
	return $c46;
}

function GetSeasonId($id)
{
	switch ($id)
	{
		case '15' :
			$c47 = 15;
		default :
			$c47 = 'null';
	}
	return $c47;
}
//End - Function
?>