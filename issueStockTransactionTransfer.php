<?php

include "Connector.php"; 

$sql = "
SELECT 	issuesdetails.intIssueNo, issuesdetails.intIssueYear, intGrnNo, intGrnYear, intMatRequisitionNo, intMatReqYear, intStyleId, strBuyerPONO, 
	intMatDetailID,strColor, strSize, strIssuedTo, dblQty, dblBalanceQty, matitemlist.strUnit, issues.dtmIssuedDate, issues.intUserid, matitemlist.intSubCatID
	FROM 
	issuesdetails INNER JOIN matitemlist ON issuesdetails.intMatDetailID = matitemlist.intItemSerial
	INNER JOIN issues ON issuesdetails.intIssueNo= issues.intIssueNo AND issuesdetails.intIssueYear= issues.intIssueYear ;";

	$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
		$year = $row["intIssueYear"];
		$itemCategory = $row["intSubCatID"];
		$styleID = $row["intStyleId"];
		$bpoNo = $row["strBuyerPONO"];
		$docNo = $row["intIssueNo"];
		$itemID = $row["intMatDetailID"];
		$color = $row["strColor"];
		$size = $row["strSize"];
		$unit = $row["strUnit"];
		$qty = $row["dblQty"];
		$dte = $row["dtmIssuedDate"];
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
	'ISSUE', 
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