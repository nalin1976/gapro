<?php

include "Connector.php"; 

$sql = "SELECT 	returntostoresdetails.intReturnNo, returntostoresdetails.intReturnYear, intIssueNo, intIssueYear, intStyleId, strBuyerPoNo, intMatdetailID, strColor, 
strSize, dblReturnQty, dblBalQty , matitemlist.strUnit, matitemlist.intSubCatID, returntostoresheader.intUserId, returntostoresheader.dtmRetDate
FROM 
returntostoresdetails INNER JOIN matitemlist ON returntostoresdetails.intMatdetailID = matitemlist.intItemSerial
INNER JOIN returntostoresheader ON returntostoresheader.intReturnNo = returntostoresdetails.intReturnNo AND
returntostoresheader.intReturnYear = returntostoresdetails.intReturnYear
;";

	$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
		$year = $row["intReturnYear"];
		$itemCategory = $row["intSubCatID"];
		$styleID = $row["intStyleId"];
		$bpoNo = $row["strBuyerPoNo"];
		$docNo = $row["intReturnNo"];
		$itemID = $row["intMatdetailID"];
		$color = $row["strColor"];
		$size = $row["strSize"];
		$unit = $row["strUnit"];
		$qty = $row["dblReturnQty"];
		$dte = $row["dtmRetDate"];
		$usr = $row["intUserId"];

		
		
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
	'SRTS', 
	'$unit', 
	'$qty', 
	'$dte', 
	'$usr'
	);";
	$db->RunQuery($sql);	
	
	$sql = "UPDATE storesbinallocation SET dblFillQty = (dblFillQty + '$qty') WHERE strMainID ='$mainstore' AND strSubID = '$substore' AND strLocID = '$location' AND strBinID = '$binID' AND intSubCatNo = '$itemCategory'";
	$db->RunQuery($sql);	
	}
?>