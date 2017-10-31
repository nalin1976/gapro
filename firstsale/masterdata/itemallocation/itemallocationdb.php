<?php 
include "../../../Connector.php";

$requestType = $_GET["RequestType"];

if($requestType=="AllocateFormula")
{
$buyerId			= $_GET["BuyerId"];
$subCatId			= $_GET["SubCatId"];
$upFormulaId		= $_GET["UPFormulaId"];
$conPcFormulaId	 	= $_GET["ConPcFormulaId"];

$sql="delete from firstsale_formulaallocation where intBuyerId=$buyerId and intSubCatId=$subCatId";
$result=$db->RunQuery($sql);

$sql="insert into firstsale_formulaallocation (intBuyerId,intSubCatId,intUnitPriceFormulaId,intConPcFormulaId)values('$buyerId','$subCatId',$upFormulaId,$conPcFormulaId);";
$result=$db->RunQuery($sql);
}
elseif($requestType=="AllocateMaterials")
{
$mainMatId			= $_GET["MainMatId"];
$subCatId			= $_GET["SubCatId"];
$colorCode			= $_GET["ColorCode"];
$sql="delete from fistsalesubcategoryallocation where intSubCatId=$subCatId";
$result=$db->RunQuery($sql);

$sql="insert into fistsalesubcategoryallocation (intMainCatID,intSubCatId,strColor)values('$mainMatId','$subCatId','$colorCode');";
$result=$db->RunQuery($sql);
}
elseif($requestType=="ChangeColor")
{
$mainMatId			= $_GET["MainMatId"];
$subCatId			= $_GET["SubCatId"];
$colorCode			= $_GET["ColorCode"];

$sql="update fistsalesubcategoryallocation set strColor='$colorCode' where intMainCatID=$mainMatId and intSubCatId=$subCatId;";
$result=$db->RunQuery($sql);
}
elseif($requestType=="SaveType")
{
$check			= $_GET["Check"];
$mainMatId		= $_GET["MainMatId"];
$subCatId		= $_GET["SubCatId"];

$sql="update fistsalesubcategoryallocation set intType='$check' where intMainCatID=$mainMatId and intSubCatId=$subCatId;";
$result=$db->RunQuery($sql);
}
?>