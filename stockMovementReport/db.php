<?php
include "../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="LoadSubcat")
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
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}

if($RequestType=="LoadMatItemList")
{
	$mainId = $_GET["mainCat"];
	$subCat = $_GET["subCat"];
	$matItem = $_GET["matItem"];
	
	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="SELECT MIL.intItemSerial, MIL.strItemDescription 
							FROM matitemlist MIL Where MIL.intMainCatID = '$mainId' ";
	if($subCat!="")
	$sql .=" AND MIL.intSubCatID =  '$subCat'";
	
	if($matItem != '')
		$sql .=" AND MIL.strItemDescription like  '%$matItem%'";
		
	$sql .=" order by MIL.strItemDescription";
	
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

if($RequestType=="LoadColor")
{
	$styleId = $_GET["styleId"];

	$ResponseXML = "<XMLLoadColor>\n";
	
		$sql="select distinct strColor from materialratio where intStyleId='$styleId' order by strColor";
	
	$result=$db->RunQuery($sql);
		$str .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strColor"] ."\">".$row["strColor"]."</option>\n";	
	}
	$ResponseXML .= "<strColor><![CDATA[" . $str . "]]></strColor>\n";
	$ResponseXML .= "</XMLLoadColor>\n";
	echo $ResponseXML;
}

elseif($RequestType=="LoadSize")
{

	$styleId = $_GET["styleId"];
	
	$ResponseXML = "<XMLLoadSize>\n";
	
		$sql="select distinct strSize from materialratio where intStyleId='$styleId' order by strSize";
	
	$result=$db->RunQuery($sql);
		$str .= "<option value=\"". "" ."\">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strSize"] ."\">".$row["strSize"]."</option>\n";	
	}
	$ResponseXML .= "<strSize><![CDATA[" . $str . "]]></strSize>\n";
	$ResponseXML .= "</XMLLoadSize>\n";
	echo $ResponseXML;
}
 ?>