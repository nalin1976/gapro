<?php
session_start();
include "../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType			= $_GET["RequestType"];
$CompanyId				= $_SESSION["FactoryID"];
$UserID					= $_SESSION["UserID"];

if($RequestType=="LoadSubCategory")
{
	$MainCatID			= $_GET["MainCatID"];
	
	$ResponseXML .="<LoadSubCategory>\n";	
	
	$SQL="select intSubCatNo,StrCatName from matsubcategory where intCatNo='$MainCatID';";
	
	$result=$db->RunQuery($SQL);	
		while ($row=mysql_fetch_array($result)){		
			 $ResponseXML .= "<SubCatNo><![CDATA[" . $row["intSubCatNo"]  . "]]></SubCatNo>\n";		
			 $ResponseXML .= "<CatName><![CDATA[" . $row["StrCatName"]  . "]]></CatName>\n";
		}
	$ResponseXML .="</LoadSubCategory>";
	echo $ResponseXML;
}	
elseif($RequestType=="LoadMatDescription")
{
	$MainCatID			= $_GET["MainCatID"];
	$MatSubCatID		= $_GET["MatSubCatID"];
	
	$ResponseXML .="<LoadSubCategory>\n";
		
	$SQL="select distinct intItemSerial,strItemDescription from matitemlist where intMainCatID='$MainCatID' AND intSubCatID='$MatSubCatID';";
	
	$result=$db->RunQuery($SQL);	
		while ($row=mysql_fetch_array($result)){		
			 $ResponseXML .= "<MatDetaiID><![CDATA[" . $row["intItemSerial"]  . "]]></MatDetaiID>\n";		
			 $ResponseXML .= "<ItemDescription><![CDATA[" . $row["strItemDescription"]  . "]]></ItemDescription>\n";
		}
	$ResponseXML .="</LoadSubCategory>";
	echo $ResponseXML;
}	