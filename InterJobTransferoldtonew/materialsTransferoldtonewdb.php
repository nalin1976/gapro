<?php
session_start();
include "../Connector.php";
$RequestType	= $_GET["RequestType"];
$userID			= $_SESSION["UserID"];
$companyId		= $_SESSION["FactoryID"];
if($RequestType=="SaveDetails")
{
$newStyleID 	= $_GET["newStyleID"];
$newToScno 		= $_GET["newToScno"];
$oldStyleID 	= $_GET["oldStyleID"];
$oldToScno 		= $_GET["oldToScno"];
$matDetailID 	= $_GET["matDetailID"];
$buyerPoNo 		= $_GET["buyerPoNo"];
$color 			= $_GET["color"];
$size 			= $_GET["size"];
$units 			= $_GET["units"];
$transQty 		= $_GET["transQty"];
$unitPrice 		= $_GET["unitPrice"];
$remarks 		= $_GET["remarks"];

$mainStoreID 	= $_GET["mainStoreID"];
$subStoreID 	= $_GET["subStoreID"];
$locationID 	= $_GET["locationID"];
$biID 			= $_GET["biID"];

$stockNo		= GetNextNo($companyId);
$stockYear		= date('Y');

$sql="insert into itemtransfertoweb 
	(intTransferID,
	intTransferYear,
	strNewStyleID,
	intNewSCNO,
	strOldStyleID, 
	intOldSCNO, 
	strBuyerPoNo, 
	intMatDetailId, 
	strColor, 
	strSize, 
	strUnit, 
	dblUnitPrice, 
	dblQty, 
	dblBalance, 
	strRemarks)
	values
	($stockNo,
	 $stockYear,
	'$newStyleID',
	'$newToScno ',
	'$oldStyleID', 
	'$oldToScno', 
	'$buyerPoNo', 
	'$matDetailID', 
	'$color', 
	'$size', 
	'$units', 
	'$unitPrice', 
	'$transQty', 
	'$transQty', 
	'$remarks');";

$result=$db->RunQuery($sql);

$sql_stock="insert into stocktransactions 
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
	intUser)
	values
	('$stockYear', 
	'$mainStoreID', 
	'$subStoreID', 
	'$locationID', 
	'$biID', 
	'$oldStyleID', 
	'$buyerPoNo', 
	'$stockNo', 
	'$stockYear', 
	'$matDetailID ', 
	'$color', 
	'$size', 
	'IJTOWEB', 
	'$units', 
	'$transQty', 
	now(), 
	'$userID');";
	 
	$result=$db->RunQuery($sql_stock);
}
function GetNextNo($companyId)
{
	global $db;	
    $No=0;	
		$Sql="select intCompanyID,dblInterJobTransferToWeb from syscontrol where intCompanyID='$companyId	'";
		 
		$result =$db->RunQuery($Sql);	
		$rowcount = mysql_num_rows($result);
		
		if ($rowcount > 0)
		{	
				while($row = mysql_fetch_array($result))
				{				
					$No=$row["dblInterJobTransferToWeb"];
					$NextNo=$No+1;
					$sqlUpdate="UPDATE syscontrol SET dblInterJobTransferToWeb='$NextNo' WHERE intCompanyID='$companyId';";
					$db->executeQuery($sqlUpdate);					
				}				
		}		
		return $NextNo;
}
?>