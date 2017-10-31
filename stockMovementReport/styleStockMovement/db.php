<?php 
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($RequestType=="getOrderNoList")
{
	$ResponseXML = "<XMLStylewiseDetails>\n";
	$styleNo = $_GET["styleNo"];
	$res_order = getStylewiseOrderNoList($styleNo);
	$res_sc = getStylewiseSCList($styleNo);
	
	$str_o = "<option value=\"". "" ."\">".""."</option>\n";
	while($row_o = mysql_fetch_array($res_order))
	{
		$str_o .= "<option value=\"". $row_o["intStyleId"] ."\">".$row_o["strOrderNo"]."</option>\n";
	}
	
	$str_s = "<option value=\"". "" ."\">".""."</option>\n";
	while($row_s = mysql_fetch_array($res_sc))
	{
		$str_s .= "<option value=\"". $row_s["intStyleId"] ."\">".$row_s["intSRNO"]."</option>\n";
	}
	
	$ResponseXML .= "<orderNoList><![CDATA[" . $str_o . "]]></orderNoList>\n";
	$ResponseXML .= "<scNoList><![CDATA[" . $str_s . "]]></scNoList>\n";
	$ResponseXML .= "</XMLStylewiseDetails>\n";
	echo $ResponseXML;
}
elseif($RequestType=="LoadColor")
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
elseif($RequestType=="LoadSubcat")
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
elseif($RequestType=="LoadItemDetails")
{
	/*$mainId = $_GET["mainCat"];
	
	$matItem = $_GET["matItem"];*/
	$styleId = $_GET["styleId"];
	$matItem = $_GET["matItem"];
	$subCat = $_GET["subCat"];
	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="select s.strMatDetailID, mil.strItemDescription from specificationdetails s inner join matitemlist mil on
s.strMatDetailID = mil.intItemSerial
where s.intStyleId='$styleId' ";
	
	if($subCat!="")
		$sql .=" AND mil.intSubCatID =  '$subCat'";
	if($matItem != '')
		$sql .= " and mil.strItemDescription like '%$matItem%' ";
	
	$sql .=" order by MIL.strItemDescription";
	/*
	
	if($matItem != '')
		$sql .=" AND MIL.strItemDescription like  '%$matItem%'";
		
	$sql .=" order by MIL.strItemDescription";*/
	
	$result=$db->RunQuery($sql);
	$str .= "<option value=\"". "" ."\">".""."</option>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strMatDetailID"] ."\">".$row["strItemDescription"]."</option>\n";	
	}
	$ResponseXML .= "<SubCat><![CDATA[" . $str . "]]></SubCat>\n";
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}
function getStylewiseOrderNoList($styleNo)
{
	global $db;
	$sql = "select intStyleId,strOrderNo from orders ";
	if($styleNo != '')
		$sql .= " where strStyle = '$styleNo' ";
	$sql .=" order by strOrderNo ";
		
	return $db->RunQuery($sql);
}
function getStylewiseSCList($styleNo)
{
	global $db;
	$sql = "select s.intSRNO,s.intStyleId from specification s inner join orders o on 
o.intStyleId = s.intStyleId  ";
	if($styleNo != '')
		$sql .= " where o.strStyle='$styleNo'";
	$sql .= " order by s.intSRNO desc";	
	return $db->RunQuery($sql);
}
?>