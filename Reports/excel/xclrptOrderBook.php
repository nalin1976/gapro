<?php
session_start();
include "../../Connector.php" ;
$orderId = $_GET["styleID"];
//$orderId = 141;

function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0); 
	return;
}
// Excel end of file footer
function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}
// Function to write a Number (double) into Row, Col
function xlsWriteNumber($Row, $Col, $Value) {
    echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
    echo pack("d", $Value);
    return;
}
// Function to write a label (text) into Row, Col
function xlsWriteLabel($Row, $Col, $Value) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
return;
}

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");    
header ("Pragma: no-cache");    
header ('Content-type: application/x-msexcel');
header ("Content-Disposition: attachment; filename=PreOrderReport.xls" ); 
header ("Content-Description: PHP/INTERBASE Generated Data" );

xlsBOF();   // begin Excel stream
$costpc = array();
$count=0;
xlsWriteLabel(2,3,"Pre Order Cost Sheet");
				   
$SQL="SELECT O.strStyle,O.strOrderNo,O.intStyleId,DATE_FORMAT(O.dtmDate, '%Y-%b-%d') AS dtmDate,date(O.dtmDate) as orderDate,O.intCompanyID,O.intBuyerID, O.intStatus ,O.reaLabourCost,O.intBuyingOfficeId,O.intUserID,O.reaECSCharge,O.intCoordinator,O.intDivisionId,O.intApprovalNo,O.strDescription, O.intQty, O.strCustomerRefNo, O.intSeasonId, O.strRPTMark, O.reaExPercentage, O.reaEfficiencyLevel, O.reaCostPerMinute, O.reaSMV, O.reaSMVRate, O.reaFinPercntage,O.reaFOB,O.reaProfit,O.dblFacProfit,concat(DATE_FORMAT(O.dtmDate,'%Y%m'),'',O.intCompanyOrderNo)as companyOrderNo FROM orders O WHERE O.intStyleId='$orderId';";
$result = $db->RunQuery($SQL);
while($row = mysql_fetch_array($result))
{
	$buyerId 			= $row["intBuyerID"];
	$userId 			= $row["intUserID"];
	$approvalNo 		= $row["intApprovalNo"];
	$buyingOfficeId 	= $row["intBuyingOfficeId"];
	$divisionId 		= $row["intDivisionId"];
	$styleNo 			= $row["strStyle"];
	$seasonId 			= $row["intSeasonId"];
	$orderNo 			= $row["strOrderNo"];
	$description 		= $row["strDescription"];
	$orderQty 			= $row["intQty"];
	$exPercentage 		= $row["reaExPercentage"];
	$efficiencyLevel	= $row["reaEfficiencyLevel"];
	$smv				= $row["reaSMV"];
	$smvRate			= $row["reaSMVRate"];
	$totalOrderQty		= ($orderQty + (($orderQty*$exPercentage)/100));
	$fob				= $row["reaFOB"];
	$profit				= $row["dblFacProfit"];
	$oderDate 			= $row["dtmDate"];
	$buyerDetails 		= GetBuyerName($buyerId);
	$companyOrderNo		= $row["companyOrderNo"];
}
$dFormatFletter = substr($buyerDetails[1],0,1);
$arrDformat = explode('-',$buyerDetails[1]);
$arrOdate = explode('-',$oderDate);
if($dFormatFletter == 'm' || $dFormatFletter == 'M')
{
	$formatOrderDate = $arrOdate[1].'-'.$arrOdate[2].'-'.$arrOdate[0];
}
else if($dFormatFletter == 'd' || $dFormatFletter == 'D')
{
	$formatOrderDate = $arrOdate[2].'-'.$arrOdate[1].'-'.$arrOdate[0];
}
else 
{
	$formatOrderDate = $oderDate;
}
	xlsWriteLabel(4,0,"STYLE NO");
	xlsWriteLabel(4,1,$styleNo);
	xlsWriteLabel(4,3,"ORDER NO");
	xlsWriteLabel(4,4,$orderNo);
	xlsWriteLabel(4,6,"DESCRIPTION");
	xlsWriteLabel(4,7,$description);
	
	xlsWriteLabel(5,0,"ORIT ORDER NO");
	xlsWriteLabel(5,1,$companyOrderNo);
	xlsWriteLabel(5,3,"ORDER DATE");
	xlsWriteLabel(5,4,$formatOrderDate);
	xlsWriteLabel(5,6,"APPROVAL NO");
	xlsWriteLabel(5,7,$approvalNo);			
	
	xlsWriteLabel(6,0,"BUYER");
	xlsWriteLabel(6,1,$buyerDetails[0]);
	xlsWriteLabel(6,3,"DESCRIPTION");
	xlsWriteLabel(6,4,$description);
	xlsWriteLabel(6,6,"MERCHANDISER");
	xlsWriteLabel(6,7,GetUserName($userId));

	xlsWriteLabel(7,0,"BUYING OFFICE");
	xlsWriteLabel(7,1,GetBuyingOfficeId($buyingOfficeId));
	xlsWriteLabel(7,3,"DIVISION");
	xlsWriteLabel(7,4,GetDivisionId($divisionId));
	xlsWriteLabel(7,6,"SEASON");
	xlsWriteLabel(7,7,GetSeasonId($seasonId));

	xlsWriteLabel(8,0,"ORDER QTY");
	xlsWriteNumber(8,1,$orderQty);
	xlsWriteLabel(8,3,"EXCESS QTY");
	xlsWriteNumber(8,4,$exPercentage);
	xlsWriteLabel(8,6,"TOTAL QTY");
	xlsWriteNumber(8,7,$totalOrderQty);
	
	xlsWriteLabel(9,0,"EFFICIENCY LEVEL");
	xlsWriteNumber(9,1,$efficiencyLevel);
	xlsWriteLabel(9,3,"SMV");
	xlsWriteNumber(9,4,$smv);
	xlsWriteLabel(9,6,"SMV RATE");
	xlsWriteNumber(9,7,$smvRate);
	
	$i = 11; // Report header row no
	xlsWriteLabel($i,0,"No");
	xlsWriteLabel($i,1,"Item Description");
	xlsWriteLabel($i,2,"Origin");
	xlsWriteLabel($i,3,"Unit");
	xlsWriteLabel($i,4,"Con Pc");
	xlsWriteLabel($i,5,"Req Qty");
	xlsWriteLabel($i,6,"Wastage %");
	xlsWriteLabel($i,7,"Freight");
	xlsWriteLabel($i,8,"Total Qty");
	xlsWriteLabel($i,9,"Price (USD)");
	xlsWriteLabel($i,10,"Total Cost PC");
	xlsWriteLabel($i,11,"Value (USD)");			
				
$SQL_Cetegory="SELECT DISTINCT matmaincategory.strDescription, matmaincategory.intID FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE orderdetails.intStyleId='$orderId' ORDER BY matmaincategory.intID;";
$result_Category = $db->RunQuery($SQL_Cetegory);
while($row_Category = mysql_fetch_array($result_Category))
{
	if($row_Category["strDescription"]=="FABRIC" | $row_Category["strDescription"]=="ACCESSORIES" | $row_Category["strDescription"]=="PACKING MATERIALS")
	{
		$category[$i]=$row_Category["strDescription"];		
		xlsWriteLabel(++$i,1,$row_Category["strDescription"]);

		$SQL_orderDetails="SELECT orderdetails.strOrderNo, orderdetails.intStyleId, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.strCurrencyID, orderdetails.intOriginNo, orderdetails.dblFreight ,orderdetails.dblTotalQty, orderdetails.dblReqQty, orderdetails.dblTotalValue, orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial,itempurchasetype.intType
	FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo
	WHERE (((orderdetails.intStyleId)='".$orderId."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."'))
	ORDER BY matitemlist.intMainCatID,matitemlist.strItemDescription;";	
		$result_order = $db->RunQuery($SQL_orderDetails);
		while($row_order = mysql_fetch_array($result_order))
		{
			xlsWriteLabel(++$i,0,++$index);
			xlsWriteLabel($i,1,$row_order["strItemDescription"]);
			if($row_Category["strDescription"]=="FABRIC" & $row_order["intType"]=="0")
			{
				$FabFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
				$TotFabFinance += $FabFinance;
			}
			if($row_Category["strDescription"]=="ACCESSORIES" & $row_order["intType"]=="0")
			{
				$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
				$TotTrimFinance += $TrimFinance;
			}
			else if($row_Category["strDescription"]=="PACKING MATERIALS" & $row_order["intType"]=="0")
			{
				$TrimFinance=$row_order["dbltotalcostpc"]*$reaFinPercntage/100;
				$TotTrimFinance += $TrimFinance;
			}
		
			xlsWriteLabel($i,2,$row_order["strOriginType"]);
			xlsWriteLabel($i,3,$row_order["strUnit"]);
			xlsWriteNumber($i,4,round($row_order["reaConPc"],4));				
			xlsWriteNumber($i,5,round($row_order["dblReqQty"],0));
			xlsWriteNumber($i,6,round($row_order["reaWastage"],2));
			xlsWriteNumber($i,7,round($row_order["dblFreight"],4));
			xlsWriteNumber($i,8,round($row_order["dblTotalQty"],0));
			xlsWriteNumber($i,9,round($row_order["dblUnitPrice"],4));
			xlsWriteNumber($i,10,round($row_order["dbltotalcostpc"],4));
			xlsWriteNumber($i,11,round($row_order["dblTotalValue"],4));
			
			$countusdValue += $row_order["dblTotalValue"];
			$counttotalcostpc += round($row_order["dbltotalcostpc"],4);
		}
		
		xlsWriteNumber(++$i,10,round($counttotalcostpc,4));
		xlsWriteNumber($i,11,round($countusdValue,4));
		
		$valueusd[$count]=$countusdValue;
		$costpc[$count]=round($counttotalcostpc,4);
		$count++;
		
		$totalMaterialcost+=$countusdValue;
		$totalMeterialCostpc+=$counttotalcostpc;
		
		$countusdValue=0.0;
		$counttotalcostpc=0.0;
	}
}
//
$result_Category1 = $db->RunQuery($SQL_Cetegory);
while($row_Category = mysql_fetch_array($result_Category1))
{					
	if($row_Category["strDescription"]=="SERVICES" | $row_Category["strDescription"]=="OTHERS" | $row_Category["strDescription"]=="WASHING")
	{	
		$category[$i]=$row_Category["strDescription"];
		xlsWriteLabel(++$i,1,$row_Category["strDescription"]);

		$SQL_orderDetails="SELECT orderdetails.strOrderNo, orderdetails.intStyleId, orderdetails.strUnit, orderdetails.dblUnitPrice, orderdetails.reaConPc, orderdetails.reaWastage, orderdetails.strCurrencyID, orderdetails.intOriginNo, orderdetails.dblFreight, orderdetails.dblTotalQty, orderdetails.dblReqQty, orderdetails.dblTotalValue, orderdetails.dbltotalcostpc, matitemlist.strItemDescription, matmaincategory.strDescription, itempurchasetype.strOriginType, matitemlist.intMainCatID, matitemlist.intItemSerial,itempurchasetype.intType FROM ((orderdetails INNER JOIN matitemlist ON orderdetails.intMatDetailID = matitemlist.intItemSerial) INNER JOIN matmaincategory ON matitemlist.intMainCatID = matmaincategory.intID) INNER JOIN itempurchasetype ON orderdetails.intOriginNo = itempurchasetype.intOriginNo WHERE (((orderdetails.intStyleId)='".$orderId."') AND ((matitemlist.intMainCatID)='".$row_Category["intID"]."')) ORDER BY matitemlist.intMainCatID,matitemlist.strItemDescription ;";

		$result_order = $db->RunQuery($SQL_orderDetails);
		while($row_order = mysql_fetch_array($result_order))
		{
			xlsWriteLabel(++$i,0,++$index);
			xlsWriteLabel($i,1,$row_order["strItemDescription"]);			
			xlsWriteLabel($i,2,$row_order["strOriginType"]);
			xlsWriteLabel($i,3,$row_order["strUnit"]);
			xlsWriteNumber($i,4,round($row_order["reaConPc"],4));				
			xlsWriteNumber($i,5,round($row_order["dblReqQty"],0));
			xlsWriteNumber($i,6,round($row_order["reaWastage"],2));
			xlsWriteNumber($i,7,round($row_order["dblFreight"],4));
			xlsWriteNumber($i,8,round($row_order["dblTotalQty"],0));
			xlsWriteNumber($i,9,round($row_order["dblUnitPrice"],4));
			xlsWriteNumber($i,10,round($row_order["dbltotalcostpc"],4));
			xlsWriteNumber($i,11,round($row_order["dblTotalValue"],4));
			
			$countusdValue += $row_order["dblTotalValue"];
			$counttotalcostpc += $row_order["dbltotalcostpc"];				

		}

		$valueusd[$count] = $countusdValue;	
		$costpc[$count] = round($counttotalcostpc,4);
		$count++;
		
		xlsWriteNumber(++$i,10,round($counttotalcostpc,4));
		xlsWriteNumber($i,11,round($countusdValue,4));
		$countusdValue=0.0;
		$counttotalcostpc=0.0;
	}
}

xlsWriteLabel(++$i,1,"Total Direct Cost");
for($loops=0;$loops< count($costpc);$loops++)
{	 
	$TotaleDrectCost+=$costpc[$loops];				
}
xlsWriteNumber($i,10,round($TotaleDrectCost,4));
xlsWriteNumber($i,11,round(($TotaleDrectCost * $totalOrderQty),4));

xlsWriteLabel(++$i,1,"C&M Earned");
xlsWriteNumber($i,10,round($smv*$smvRate,4));
xlsWriteNumber($i,11,round((($smv*$smvRate)*$orderQty),4));

xlsWriteLabel(++$i,1,"Target FOB");
xlsWriteNumber($i,10,round($fob,4));
xlsWriteNumber($i,11,round($fob*$orderQty,4));

xlsWriteLabel(++$i,1,"REQD FOB");
$ReqFOB = $fob - $profit;
xlsWriteNumber($i,10,round($ReqFOB,4));

xlsWriteLabel(++$i,1,"Gross Profit");
xlsWriteNumber($i,10,round($profit,4));
xlsWriteNumber($i,11,round($profit*$orderQty,4));

xlsEOF();

			
function  GetBuyerName($buyerId)
{
global $db;
$array = array();
	$sql="SELECT strName,strDtFormat FROM  buyers WHERE intBuyerID = '$buyerId';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$array[0] = $row["strName"];
		$array[1] = $row["strDtFormat"];
	}
}

function GetUserName($userId)
{
global $db;
	$sql="select Name from useraccounts where intUserID='$userId';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["Name"];
	}
}

function GetBuyingOfficeId($buyingOfficeId)
{
global $db;
	$sql="select strName from buyerbuyingoffices where intBuyingOfficeId='$buyingOfficeId';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strName"];
	}
}

function GetDivisionId($divisionId)
{
global $db;
	$sql="select strDivision from buyerdivisions where intDivisionId='$divisionId';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strDivision"];
	}
}

function GetSeasonId($seasonId)
{
global $db;
	$sql="select strSeason from seasons where intSeasonId='$seasonId';";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		return $row["strSeason"];
	}
}
?>