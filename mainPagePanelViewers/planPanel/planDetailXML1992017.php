<?php

session_start();
$backwardseperator = "../";
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType=$_GET["RequestType"];
$companyId  =$_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];


function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}




if($RequestType=="Confirm")
{		
	$StyleID		 = $_GET['StyleID'];
	$bpno 		 = $_GET['bpno'];

	



		 $sqlUpdates="UPDATE deliveryschedule
SET deliveryschedule.intPlanConfirm = '1'
WHERE
	(
		deliveryschedule.intStyleId = '$StyleID'
	)
AND (
		deliveryschedule.intBPO = '$bpno'
     )";
				
		$db->RunQuery($sqlUpdates);
		
		
	
	
}

?>