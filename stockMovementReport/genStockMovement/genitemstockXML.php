<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="LoadSubcat")
{
	$mainId = $_GET["mainCat"];

	$ResponseXML = "<XMLloadMainCategory>\n";
	
	$sql="SELECT GSC.intSubCatNo,GSC.StrCatName FROM genmatsubcategory GSC WHERE GSC.intCatNo <>'' ";
	if($mainId!="")
		$sql .=" AND GSC.intCatNo = '$mainId'";
		
	$sql .=" order by GSC.StrCatName";
	$result=$db->RunQuery($sql);

		$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intSubCatNo"] ."\">".$row["StrCatName"]."</option>\n";	
	}
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}

if($RequestType=="LoadMatItemList")
{
	$mainId = $_GET["mainCat"];
	$subCat = $_GET["subCat"];
	$matItem = $_GET["matItem"];
	
	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="SELECT GMIL.intItemSerial, GMIL.strItemDescription 
							FROM genmatitemlist GMIL Where GMIL.intMainCatID = '$mainId' ";
	if($subCat!="")
	$sql .=" AND GMIL.intSubCatID =  '$subCat'";
	
	if($matItem != '')
		$sql .=" AND GMIL.strItemDescription like  '%$matItem%'";
		
	$sql .=" order by GMIL.strItemDescription";
	
	$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intItemSerial"] ."\">".$row["strItemDescription"]."</option>\n";	
	}
	$ResponseXML .= "<SubCat><![CDATA[" . $str . "]]></SubCat>\n";
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}
 ?>