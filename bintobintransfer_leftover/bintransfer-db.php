<?php
session_start();
$userId		=	$_SESSION["UserID"];
$year		= date("Y");
include "../Connector.php";

$id			=$_GET["id"];

if($id=="save")
{
$styleId			= $_GET["styleId"];
$buyerPoNo			= $_GET["buyerPoNo"];
$itemCode			= $_GET["itemCode"];
$color				= $_GET["color"];
$size				= $_GET["size"];
$unit				= $_GET["unit"];
$transferQty		= $_GET["transferQty"];

$sourceMainId		= $_GET["sourceMainId"];
$sourceSubId		= 90; //dummy no
$sourceLocation		= 90; //dummy no
$sourceBinId		= 90; //dummy no

$desMainId			= $_GET["desMainId"];
$desSubId			= $_GET["desSubId"];
$desLocation		= $_GET["desLocation"];
$desBinId			= $_GET["desBinId"];
$no					= $_GET["no"];

SaveSourceStock($year,$styleId,$buyerPoNo,$itemCode,$color,$size,$unit,$transferQty,$sourceMainId,$sourceSubId,$sourceLocation,$sourceBinId,$userId,$no);
SaveDestinationStock($year,$styleId,$buyerPoNo,$itemCode,$color,$size,$unit,$transferQty,$desMainId,$desSubId,$desLocation,$desBinId,$userId,$no);

$sql="select intSubCatID  from matitemlist
 where intItemSerial='$itemCode'";	
$result	= $db->RunQuery($sql);	
$row	= mysql_fetch_array($result);
	$matCatId =$row["intSubCatID"];
	
UpdateSourseBinAllocation($sourceMainId,$sourceSubId,$sourceLocation,$sourceBinId,$matCatId,$transferQty);
UpdateDestinationBinAllocation($desMainId,$desSubId,$desLocation,$desBinId,$matCatId,$transferQty);
}
function SaveSourceStock($year,$styleId,$buyerPoNo,$itemCode,$color,$size,$unit,$transferQty,$sourceMainId,$sourceSubId,$sourceLocation,$sourceBinId,$userId,$no)
{
global $db;
$outQty	= $transferQty*-1;
$sql="insert into stocktransactions
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
		('$year', 
		'$sourceMainId', 
		'$sourceSubId', 
		'$sourceLocation', 
		'$sourceBinId', 
		'$styleId', 
		'$buyerPoNo', 
		'$no', 
		'$year', 
		'$itemCode', 
		'$color', 
		'$size', 
		'BINTROUT', 
		'$unit', 
		'$outQty', 
		now(), 
		'$userId')";
	$result = $db->RunQuery($sql);
}
function SaveDestinationStock($year,$styleId,$buyerPoNo,$itemCode,$color,$size,$unit,$transferQty,$desMainId,$desSubId,$desLocation,$desBinId,$userId,$no)
{
global $db;
	$sql="insert into stocktransactions
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
		('$year', 
		'$desMainId', 
		'$desSubId', 
		'$desLocation', 
		'$desBinId', 
		'$styleId', 
		'$buyerPoNo', 
		'$no', 
		'$year', 
		'$itemCode', 
		'$color', 
		'$size', 
		'BINTRIN', 
		'$unit', 
		'$transferQty', 
		now(), 
		'$userId')";
	$result = $db->RunQuery($sql);
}
function UpdateSourseBinAllocation($sourceMainId,$sourceSubId,$sourceLocation,$sourceBinId,$matCatId,$transferQty)
{
global $db;
		$sql = "UPDATE storesbinallocation SET dblFillQty=dblFillQty-$transferQty
				WHERE 	strMainID= '$sourceMainId' AND
				strSubID= '$sourceSubId' AND
				strLocID= '$sourceLocation' AND
				strBinID= '$sourceBinId' AND
				intSubCatNo= '$matCatId' ";
		$result = $db->RunQuery($sql);
}
function UpdateDestinationBinAllocation($desMainId,$desSubId,$desLocation,$desBinId,$matCatId,$transferQty)
{
global $db;
		$sql = "UPDATE storesbinallocation SET dblFillQty=dblFillQty+$transferQty
				WHERE 	strMainID= '$desMainId' AND
				strSubID= '$desSubId' AND
				strLocID= '$desLocation' AND
				strBinID= '$desBinId' AND
				intSubCatNo= '$matCatId' ";
		$result = $db->RunQuery($sql);
}
?>