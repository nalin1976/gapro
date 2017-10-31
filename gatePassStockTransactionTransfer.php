<?php

include "Connector.php"; 

$sql = "SELECT 	gatepassdetails.intGatePassNo, gatepassdetails.intGPYear, intStyleId, strBuyerPONO, intMatDetailId, strColor, strSize, dblQty, intRTN, dblBalQty,
matitemlist.strUnit, matitemlist.intSubCatID,gatepass.dtmDate, gatepass.intUserId
FROM 
gatepassdetails INNER JOIN matitemlist ON gatepassdetails.intMatDetailId = matitemlist.intItemSerial
INNER JOIN gatepass ON gatepass.intGatePassNo = gatepassdetails.intGatePassNo AND gatepass.intGPYear = gatepassdetails.intGPYear
;";

	$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
		$year = $row["intGPYear"];
		$itemCategory = $row["intSubCatID"];
		$styleID = $row["intStyleId"];
		$bpoNo = $row["strBuyerPONO"];
		$docNo = $row["intGatePassNo"];
		$itemID = $row["intMatDetailId"];
		$color = $row["strColor"];
		$size = $row["strSize"];
		$unit = $row["strUnit"];
		$qty = $row["dblQty"];
		$dte = $row["dtmDate"];
		$usr = $row["intUserid"];

		
		
		$mainstore = "";
		$substore = "";
		$location = "";
		$binID = "";

		$sql = "SELECT strBinID,strMainID,strSubID,strLocID FROM storesbinallocation WHERE intSubCatNo = $itemCategory LIMIT 1";
		$resultBin = $db->RunQuery($sql);		
		while($rowBin = mysql_fetch_array($resultBin))
		{
			$mainstore = $rowBin["strMainID"];
			$substore = $rowBin["strSubID"];
			$location = $rowBin["strLocID"];
			$binID = $rowBin["strBinID"];
			break;
		}	
		
		$sql = "
INSERT INTO stocktransactions 
	(intYear, 
	strMainStoresID, 
	strSubStores, 
	strLocation, 
	strBin, 
	intStyleId, 
	strBuyerPoNo, 
	intDocumentNo, 
	intDocumentYear, 
	intMatDetailId, 
	strColor, 
	strSize, 
	strType, 
	strUnit, 
	dblQty, 
	dtmDate, 
	intUser
	)
	VALUES
	('$year', 
	'$mainstore', 
	'$substore', 
	'$location', 
	'$binID', 
	'$styleID', 
	'$bpoNo', 
	'$docNo', 
	'$year', 
	'$itemID', 
	'$color', 
	'$size', 
	'SGatePass', 
	'$unit', 
	'-$qty', 
	'$dte', 
	'$usr'
	);";
	$db->RunQuery($sql);	
	
	$sql = "UPDATE storesbinallocation SET dblFillQty = (dblFillQty - '$qty') WHERE strMainID ='$mainstore' AND strSubID = '$substore' AND strLocID = '$location' AND strBinID = '$binID' AND intSubCatNo = '$itemCategory'";
	$db->RunQuery($sql);	
	}
?>