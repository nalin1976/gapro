<?php
include "../../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="LoadSubcatList")
{
	$mainId = $_GET["mainCat"];
		
	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="select intSubCatNo, StrCatName from matsubcategory
			where intCatNo='$mainId' ";
			
	$sql .=" order by StrCatName";
	
	$result=$db->RunQuery($sql);
	$str .= "<option value=\"". "" ."\">".""."</option>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["intSubCatNo"] ."\">".$row["StrCatName"]."</option>\n";	
	}
	$ResponseXML .= "<SubCat><![CDATA[" . $str . "]]></SubCat>\n";
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}

if($RequestType=="LoadMatItemList")
{
	$mainId = $_GET["mainCat"];
	$subCat = $_GET["subCat"];
	$matItem = $_GET["matItem"];
	
	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="SELECT MIL.intItemSerial, MIL.strItemDescription FROM matitemlist MIL Where MIL.intMainCatID = '$mainId' ";
				
	if($subCat != '')
		$sql .= " and MIL.intSubCatID = '$subCat' ";
		
	if($matItem != '')
		$sql .= " and MIL.strItemDescription like '%$matItem%' ";
		
	$sql .=" order by MIL.strItemDescription";
	$result=$db->RunQuery($sql);
	$str1 .= "<option value=\"". "" ."\">".""."</option>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$str1 .= "<option value=\"". $row["intItemSerial"] ."\">".$row["strItemDescription"]."</option>\n";	
	}
	$ResponseXML .= "<matItemList><![CDATA[" . $str1 . "]]></matItemList>\n";
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}
?>