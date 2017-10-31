<?php 
session_start();
include "../../../Connector.php";
$id=$_GET["id"];
$userId		= $_SESSION["UserID"];

if ($id=="saveItemFormulaDetails")
{
	$buyer = $_GET["buyer"];
	$upriceFormula = $_GET["upriceFormula"];
	$conpcFormula = $_GET["conpcFormula"];
	$subCategory = $_GET["subCategory"];
	$matDetailId = $_GET["matDetailId"];
	$ItemMainCat = $_GET["ItemMainCat"];
	$itemType = $_GET["itemType"];
	$displayItem = $_GET["displayItem"];
	$otherPacking = $_GET["otherPacking"];
	$check = $_GET["check"];
	
	if($itemType == 'true')
		$displayItemDesc = 1;
	else
		$displayItemDesc =0;
		
	if($displayItem == 'true')
		$displayFS = 1;
	else 
		$displayFS = 0;	
		
	if($otherPacking == 'true')	
		$displayOtherPack = 1;
	else
		$displayOtherPack =0;	
			
	if($check == 'true')
	{
		deleteSaveItemAllocationData($buyer,$subCategory,$matDetailId);
		insertItemFormulaDetails($buyer,$upriceFormula,$conpcFormula,$subCategory,$matDetailId,$ItemMainCat,$displayItemDesc,$displayFS,$displayOtherPack);	
	}
	else
	{
		deleteSaveItemAllocationData($buyer,$subCategory,$matDetailId);
	}
}

if($id=="saveAllItemFormulaDetails")
{
global $db;
	$buyer = $_GET["buyer"];
	$upriceFormula = $_GET["upriceFormula"];
	$conpcFormula = $_GET["conpcFormula"];
	$subCategory = $_GET["subCategory"];
	$ItemMainCat = $_GET["ItemMainCat"];
	$itemType = $_GET["itemType"];
	$displayItem = $_GET["displayItem"];
	$otherPacking = $_GET["otherPacking"];
	$check = $_GET["check"];
	
	if($itemType == 'true')
		$displayItemDesc = 1;
	else
		$displayItemDesc =0;
		
	if($displayItem == 'true')
		$displayFS = 1;
	else 
		$displayFS = 0;	
		
	if($otherPacking == 'true')	
		$displayOtherPack = 1;
	else
		$displayOtherPack =0;
	
	if($check == 'true')
	{
		deleteSaveItemAllocationData($buyer,$subCategory,'');
		$sql = " insert into firstsale_formulaallocation (intBuyerId,intSubCatId,intUnitPriceFormulaId,intConPcFormulaId,intMatDetailId,intMainCatID,intType,intDisplayItem,intOtherPacking)
select $buyer,$subCategory,$upriceFormula,$conpcFormula,intItemSerial,$ItemMainCat,$displayItemDesc,$displayFS,$displayOtherPack  from matitemlist where intSubCatID='$subCategory' ";
		$result = $db->RunQuery($sql);
	}
	else
	{
		deleteSaveItemAllocationData($buyer,$subCategory,'');
	}	
	
	
}

function checkItemDetailsAvailability($buyer,$matDetailId)
{
	global $db;
	
	$sql = " select * from firstsale_formulaallocation where intBuyerId='$buyer' and intMatDetailId='$matDetailId' ";
	return $db->CheckRecordAvailability($sql);
}

function updateItemFormulaDetails($buyer,$upriceFormula,$conpcFormula,$subCategory,$matDetailId,$ItemMainCat,$itemType,$displayFS,$displayOtherPack)
{
	global $db;
	
	$sql = " update firstsale_formulaallocation 
	set
	intUnitPriceFormulaId = '$upriceFormula' , 
	intConPcFormulaId = '$conpcFormula' , 
	intMainCatID = '$ItemMainCat' , 
	intType = '$itemType',
	intDisplayItem = '$displayFS',
	intOtherPacking = '$displayOtherPack'
	where
	intBuyerId = '$buyer' and 
	intMatDetailId = '$matDetailId' ";
	$result = $db->RunQuery($sql);
}
function insertItemFormulaDetails($buyer,$upriceFormula,$conpcFormula,$subCategory,$matDetailId,$ItemMainCat,$itemType,$displayFS,$displayOtherPack)
{
	global $db;
	
	$sql = "insert into firstsale_formulaallocation (intBuyerId,intSubCatId,intUnitPriceFormulaId,intConPcFormulaId, 
	intMatDetailId, intMainCatID,intType,intDisplayItem,intOtherPacking) values ('$buyer',	'$subCategory','$upriceFormula', '$conpcFormula', 	'$matDetailId', '$ItemMainCat','$itemType','$displayFS','$displayOtherPack')";
	$result = $db->RunQuery($sql);
}

function deleteSaveItemAllocationData($buyer,$subCategory,$item)
{
	global $db;
	$sql = " delete from firstsale_formulaallocation 	where
	intBuyerId = '$buyer' and 	intSubCatId = '$subCategory' ";
	if($item != '')
		$sql .= " and intMatDetailId ='$item' ";
		
	$result = $db->RunQuery($sql);	
}
?>