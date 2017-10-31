<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="LoadSubCategory")
{
	$mainId = $_GET["mainCat"];

	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="SELECT GMSC.intSubCatNo, GMSC.StrCatName FROM genmatsubcategory GMSC WHERE GMSC.intCatNo<>''";
	if($mainId!="")
	$sql .=" AND GMSC.intCatNo = '$mainId'";
	
	$sql .=" order by GMSC.StrCatName";
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

	$sql="SELECT GMIL.intItemSerial, GMIL.strItemDescription FROM genmatitemlist GMIL WHERE GMIL.intMainCatID <>'' ";
if($mainId!="")
	$sql .=" AND GMIL.intMainCatID =  '$mainId'";
if($subCatId!="")
	$sql .=" AND GMIL.intSubCatID =  '$subCatId'";
if($txtMatItem!="")
	$sql .=" AND GMIL.strItemDescription like '%$txtMatItem%'";
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