<?php 
include "../../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($requestType=="loadSubcategoryList")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$ResponseXML = "";
	$ResponseXML .= "<subCatList>\n";
	$mainCat = $_GET["mainCat"];
	
	$sql = "SELECT intSubCatNo,StrCatName FROM genmatsubcategory WHERE intStatus = 1 ";
	if($mainCat != '')
		$sql .= " and intCatNo = '$mainCat' ";
		
	$sql .= " order by StrCatName "	;
	$result = $db->RunQuery($sql);
	$str = "<option value=\"". "" ."\">" . "" ."</option>";
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["intSubCatNo"] ."\">" . $row["StrCatName"] ."</option>";
	}
	$ResponseXML .= "<subCategory><![CDATA[" . $str  . "]]></subCategory>\n";
	$ResponseXML .= "</subCatList>";
	echo $ResponseXML;
}
if($requestType=="SaveItem")
{
	$costCenter = $_GET["costCenter"];
	$rlevel 	= $_GET["rlevel"];
	$matDetailId = $_GET["matDetailId"];
	
	if($rlevel>0)
	{
		$chkRecAv = checkItemAvailability($costCenter,$matDetailId);
		if($chkRecAv ==1)
			updateItemDetails($costCenter,$matDetailId,$rlevel);
		else
			insertItemDetails($costCenter,$matDetailId,$rlevel);	
	}
}
function checkItemAvailability($costCenter,$matDetailId)
{
	global $db;
	$sql = "Select * from genitemwisereorderlevel where intCostCenterId='$costCenter' and intMatDetailID='$matDetailId' ";
	return $db->CheckRecordAvailability($sql);
}
function insertItemDetails($costCenter,$matDetailId,$rlevel)
{
	global $db;
	$sql = "insert into genitemwisereorderlevel (intCostCenterId, intMatDetailID, dblReorderLevel) 	values
	('$costCenter',	'$matDetailId', '$rlevel')";
	$result = $db->RunQuery($sql);
}
function updateItemDetails($costCenter,$matDetailId,$rlevel)
{
	global $db;
	$sql = "update genitemwisereorderlevel 	set dblReorderLevel = '$rlevel'
	where
	intCostCenterId = '$costCenter' and intMatDetailID = '$matDetailId' ";
	$result = $db->RunQuery($sql);
}
?>