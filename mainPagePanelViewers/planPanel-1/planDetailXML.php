<?php

session_start();
$backwardseperator = "../";
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId  =$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];


if($RequestType=="loadPlanDetailsToGrid")
{		
	$ResponseXML = "";
	//$ResponseXML = "</loadPlanDetailsToGrid>";
	$sql="SELECT
					orders.intStyleId,
					orders.strOrderNo,
					orders.intBuyerCon,
					orders.dtmOCD_Date,
					orders.dtmPCD_Date
			FROM
					orders
			WHERE
					orders.intBuyerCon = 1";
	$result=$db->RunQuery($sql);	
	while($rows=mysql_fetch_array($result)){
		$ResponseXML .="<StyleId><![CDATA[" .$rows['intStyleId'] . "]]></StyleId>\n";
		$ResponseXML .="<strOrderNo><![CDATA[" .$rows['strOrderNo'] . "]]></strOrderNo>\n";
		$ResponseXML .="<dtmPCD_Date><![CDATA[" .$rows['dtmPCD_Date'] . "]]></dtmPCD_Date>\n";
		$ResponseXML .="<dtmOCD_Date><![CDATA[" .$rows['dtmOCD_Date'] . "]]></dtmOCD_Date>\n";
	
	}
	//$ResponseXML .= "</loadPlanDetailsToGrid>";
	echo $ResponseXML;

} 

function getStyleName($styleID)
{
	global $db;
	$SQL = " SELECT strOrderNo FROM orders WHERE intStyleId='$styleID' ";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strOrderNo"];	
}
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}


function getStockBalance($styleId,$buyerPo,$matID,$color,$size,$grnNo,$grnYear,$storeID,$grnType)
{
	global $db;
	$SQL = " SELECT  sum(dblQty) as dblQty 
FROM stocktransactions s inner join mainstores m on 
m.strMainID = s.strMainStoresID
WHERE intStyleId='$styleId' AND strBuyerPoNo='$buyerPo' AND intMatDetailId='$matID' 
AND strColor='$color' AND strSize='$size' 
and intGrnNo = '$grnNo' and intGrnYear = '$grnYear' and m.strMainID='$storeID' and intStatus=1 and s.strGRNType = '$grnType'";
//echo $SQL;
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}

if($RequestType=="Confirm")
{		
	$StyleID		 = $_GET['StyleID'];
	$lineNo 		 = $_GET['lineNo'];
	$DateFrom		 = $_GET['DateFrom'];
	$DateTo	 		 =$_GET['DateTo'];
	$planConfirm	 =$_GET['planConfirm'];
	
	$StyleIDarray	=explode(",",$StyleID);
	$lineNoarray	=explode(",",$lineNo);
	$DateFromarray	=explode(",",$DateFrom);
	$DateToarray	=explode(",",$DateTo);
	$planConfirmarray	=explode(",",$planConfirm);
//	echo sizeof($StyleIDarray);
    $msg="";
	for($n=0; $n<sizeof($StyleIDarray); $n++)
	{
		//$sql="SELECT orders.intStyleId,orders.intPlanConfirm FROM orders WHERE orders.intStyleId='$StyleID[$n]'";
		if($DateFromarray[$n]=="")$DateFromarray[$n]="0000-00-00";
		if($DateToarray[$n]=="")$DateToarray[$n]="0000-00-00";
		if($lineNoarray[$n]=="")$lineNoarray[$n]="";
   		$sqlUpdate="UPDATE orders SET orders.intPlanConfirm=$planConfirmarray[$n],
				orders.intLineNo='$lineNoarray[$n]',
				orders.dtmFromDate='$DateFromarray[$n]',
				orders.dtmToDate='$DateToarray[$n]'
			 WHERE orders.intStyleId='$StyleIDarray[$n]'";
		$db->RunQuery($sqlUpdate);
	}
/*	if($Check=='true'){
    	$sql="UPDATE orders SET orders.intPlanConfirm=1 WHERE orders.intStyleId='$StyleID'";
	}else{
    	$sql="UPDATE orders SET orders.intPlanConfirm=0 WHERE orders.intStyleId='$StyleID'";
	}
*/	//$db->RunQuery($sql);
}

?>