<?php	
session_start();
header('Content-Type: text/xml'); 
include "../../Connector.php";
$request	= $_GET["request"];
$userId		= $_SESSION["UserID"];

if($request=="setSubCategory")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$mainCatId = $_GET['mainCatId'];
	$ResponseXML = "<XMLloadSubCategory>";
	
	$SQL="select intSubCatNo,StrCatName from matsubcategory where intStatus=1 
		  and intCatNo='$mainCatId'";
		 
	$result =$db->RunQuery($SQL);
	$ResponseXML .= "<option value=\"".""."\">"."Select One"."</option>";
	while ($row=mysql_fetch_array($result))
	{		
		$ResponseXML .= "<option value=\"".$row["intSubCatNo"]."\">".$row["StrCatName"]."</option>";
	}
	$ResponseXML.="</XMLloadSubCategory>";
	echo $ResponseXML;
}
if($request=="updateUnitPrice")
{
	$itemCode  = $_GET['itemCode'];
	$unitPrice = $_GET['unitPrice'];
	
	$sqlCheck = "select dblUnitPrice from matitemlist where intItemSerial='$itemCode'";
	$resultChk =$db->RunQuery($sqlCheck);
	$rowChk = mysql_fetch_array($resultChk);
	$OldPrice = $rowChk['dblUnitPrice'];
	if($unitPrice==$OldPrice)
	{
		$sqlUpdate = "update matitemlist set dblUnitPrice = '$unitPrice' where intItemSerial = '$itemCode'";
		$result =$db->RunQuery($sqlUpdate);
	}
	else
	{
		$sqlUpdate = "update matitemlist set dblUnitPrice = '$unitPrice' where intItemSerial = '$itemCode'";
		$result =$db->RunQuery($sqlUpdate);
		$sqlInsHis = "insert into log_stylepricechange 
						(intMatDetailId, dblOldUnitPrice, dblNewUnitPrice, intUserId, dtmChangeDate)
						values
						('$itemCode', '$OldPrice', '$unitPrice', '$userId', now());";
		$resultInsHis =$db->RunQuery($sqlInsHis);
	}
	
}
?>