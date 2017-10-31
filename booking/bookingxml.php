<?php
include "../Connector.php";
$requestType 	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];


if($requestType=="URLLoadPopItems")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLURLLoadPopItems>";

$mainCat 	= $_GET["MainCat"];
$subCat 	= $_GET["SubCat"];
$itemDesc 	= $_GET["ItemDesc"];
	$sql="select intMainCatID,intItemSerial,strItemDescription,strUnit from matitemlist where intStatus=1 ";
if($mainCat!="")	
	$sql .= "and intMainCatID=$mainCat ";
if($subCat!="")
	$sql .= "and intSubCatID=$subCat ";
if($itemDesc!="")
	$sql .= "and strItemDescription like '%$itemDesc%' ";
	
	$sql .= "order by strItemDescription ";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<MainCatId><![CDATA[" . $row["intMainCatID"]  . "]]></MainCatId>\n";
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
		$ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";	
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
elseif($requestType=="URLLoadSubCategory")
{

$mainCat = $_GET["MainCat"];
	$sql="select intSubCatNo,StrCatName from matsubcategory where intStatus=1 and intCatNo=$mainCat order by StrCatName";
	$result=$db->RunQuery($sql);
		echo "<option value="."".">"."All"."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		echo "<option value=".$row["intSubCatNo"].">".$row["StrCatName"]."</option>\n";
	}

}
elseif($requestType=="URLLoadDetailsToItemTbl")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$itemId 	= $_GET["ItemId"];
$ResponseXML = "<XMLURLLoadPopItems>";
	
	$sql="select intItemSerial,strItemDescription from matitemlist where intItemSerial='$itemId' order by strItemDescription";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<ItemId><![CDATA[" . $row["intItemSerial"]  . "]]></ItemId>\n";	
		$ResponseXML .= "<ItemDesc><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDesc>\n";	
	}
$ResponseXML .= "</XMLURLLoadPopItems>\n";
echo $ResponseXML;
}
?>