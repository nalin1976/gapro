<?php

include "Connector.php"; 

$sql = "SELECT 	grndetails.intGrnNo, grndetails.intGRNYear, grnheader.dtmRecievedDate, grndetails.intStyleId, grndetails.strBuyerPONO, grndetails.intMatDetailID, grndetails.strColor, grndetails.strSize, grndetails.dblQty, grndetails.dblExcessQty, grndetails.dblAditionalQty, grndetails.dblBalance, 
dblValueBalance, dblUnauthorizedQty, dblAllowableQty, intInspected, dblInspPercentage, intInspApproved, strComment, intReject, 
strReason, intSpecialApp, strSpecialAppReason, intPreInsp, intPreInspQty, intVisInspQty, intApprovedQty, intRejectQty, intSpecialAppQty,
matitemlist.intSubCatID, grnheader.intUserId, matitemlist.strUnit	 
FROM grndetails 
INNER JOIN matitemlist ON grndetails.intMatDetailID = matitemlist.intItemSerial
INNER JOIN grnheader ON grnheader.intGrnNo = grndetails.intGrnNo AND grnheader.intGRNYear = grndetails.intGRNYear;";

	$result = $db->RunQuery($sql);		
	while($row = mysql_fetch_array($result))
	{
		$year = $row["intGRNYear"];
		$itemCategory = $row["intSubCatID"];
		$styleID = $row["intStyleId"];
		$bpoNo = $row["strBuyerPONO"];
		$docNo = $row["intGrnNo"];
		$itemID = $row["intMatDetailID"];
		$color = $row["strColor"];
		$size = $row["strSize"];
		$unit = $row["strUnit"];
		$qty = $row["dblQty"];
		$dte = $row["dtmRecievedDate"];
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
	'GRN', 
	'$unit', 
	'$qty', 
	'$dte', 
	'$usr'
	);";
	$db->RunQuery($sql);	
	
	$sql = "UPDATE storesbinallocation SET dblFillQty = '$qty' WHERE strMainID ='$mainstore' AND strSubID = '$substore' AND strLocID = '$location' AND strBinID = '$binID' AND intSubCatNo = '$itemCategory'";
	$db->RunQuery($sql);	
	}
?>