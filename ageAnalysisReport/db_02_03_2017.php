<?php
include "../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="LoadSubCategory")
{
	$mainId = $_GET["mainCat"];

	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="SELECT MSC.intSubCatNo, MSC.StrCatName FROM matsubcategory MSC WHERE MSC.intCatNo<>''";
	if($mainId!="")
	$sql .=" AND MSC.intCatNo = '$mainId'";
	
	$sql .=" order by MSC.StrCatName";
	$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intSubCatNo"] ."\">".$row["StrCatName"]."</option>\n";	
	}
	//$ResponseXML .= "<SubCat><![CDATA[" . $str . "]]></SubCat>\n";
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}

elseif($RequestType=="LoadMaterials")
{

$mainId = $_GET["mainId"];
$subCatId = $_GET["subCatId"];
$txtMatItem = $_GET["txtMatItem"];

$ResponseXML = "<XMLLoadMaterial>\n";

	$sql="SELECT MIL.intItemSerial, MIL.strItemDescription FROM matitemlist MIL WHERE MIL.intMainCatID <>'' ";
if($mainId!="")
	$sql .=" AND MIL.intMainCatID =  '$mainId'";
if($subCatId!="")
	$sql .=" AND MIL.intSubCatID =  '$subCatId'";
if($txtMatItem!="")
	$sql .=" AND MIL.strItemDescription like '%$txtMatItem%'";
$sql .= " Order By strItemDescription";
 
$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["intItemSerial"] ."\">".$row["strItemDescription"]."</option>\n";	
}

	//$ResponseXML .= "<itemList><![CDATA[" . $str . "]]></itemList>\n";
$ResponseXML .= "</XMLLoadMaterial>\n";
echo $ResponseXML;
}

?>