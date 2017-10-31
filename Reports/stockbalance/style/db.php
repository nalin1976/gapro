<?php
include "../../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="LoadSubCategory")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$mainId = $_GET["mainId"];

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
elseif($RequestType=="LoadMaterial")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$mainId = $_GET["mainId"];
$subCatId = $_GET["subCatId"];
$matItem = $_GET["matItem"];

$ResponseXML = "<XMLLoadMaterial>\n";

	$sql="SELECT MIL.intItemSerial, MIL.strItemDescription FROM matitemlist MIL WHERE MIL.intMainCatID <>'' ";
if($mainId!="")
	$sql .=" AND MIL.intMainCatID =  '$mainId'";
if($subCatId!="")
	$sql .=" AND MIL.intSubCatID =  '$subCatId'";
if($matItem != "")
	$sql .=" AND MIL.strItemDescription like  '%$matItem%'";
	
$sql .= " Order By strItemDescription";
 
$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["intItemSerial"] ."\">".$row["strItemDescription"]."</option>\n";	
}
$ResponseXML .= "</XMLLoadMaterial>\n";
echo $ResponseXML;
}
elseif($RequestType=="LoadStyle")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$status = $_GET["status"];

$ResponseXML = "<XMLLoadStyle>\n";

	$sql="select O.intStyleId,O.strOrderNo from orders O
 where O.intStyleId<>''";
 
 if($status!=0)
 	$sql .= " AND intStatus='$status'";
	
$sql .= " Order By strOrderNo";

$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
}
$ResponseXML .= "</XMLLoadStyle>\n";
echo $ResponseXML;
}
elseif($RequestType=="LoadSc")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$status = $_GET["status"];

$ResponseXML = "<XMLLoadSc>\n";

	$sql="select O.intStyleId,intSRNO from orders O inner join specification S on O.intStyleId=S.intStyleId where strStyle<>''";
 
 if($status!=0)
 	$sql .= " AND intStatus='$status'";
	
$sql .= " Order By intSRNO DESC";
$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
}
$ResponseXML .= "</XMLLoadSc>\n";
echo $ResponseXML;
}
elseif($RequestType=="LoadColor")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleId = $_GET["styleId"];

$ResponseXML = "<XMLLoadColor>\n";

	$sql="select distinct strColor from materialratio where intStyleId='$styleId' order by strColor";

$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["strColor"] ."\">".$row["strColor"]."</option>\n";	
}
$ResponseXML .= "</XMLLoadColor>\n";
echo $ResponseXML;
}
elseif($RequestType=="LoadSize")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleId = $_GET["styleId"];

$ResponseXML = "<XMLLoadSize>\n";

	$sql="select distinct strSize from materialratio where intStyleId='$styleId' order by strSize";

$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["strSize"] ."\">".$row["strSize"]."</option>\n";	
}
$ResponseXML .= "</XMLLoadSize>\n";
echo $ResponseXML;
}

elseif($RequestType=="LoadOrderNoStylewise")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleNo = $_GET["styleNo"];
$status  = $_GET["status"];
$ResponseXML = "<XMLStyleDetails>\n";

	
	$sql="select O.intStyleId,O.strOrderNo from orders O inner join specification S on O.intStyleId=S.intStyleId where strOrderNo<>''";
 
 if($status!=0)
 	$sql .= " AND intStatus='$status'";
if($styleNo != "")	
	$sql .= " AND strStyle ='$styleNo'";
	
$sql .= " Order By strOrderNo";

$result=$db->RunQuery($sql);
	$str .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$str .= "<option value=\"". $row["intStyleId"] ."\">".$row["strOrderNo"]."</option>\n";	
}
	

	$sql="select O.intStyleId,intSRNO from orders O inner join specification S on O.intStyleId=S.intStyleId where strStyle<>''";
 
 if($status!=0)
 	$sql .= " AND intStatus='$status'";
if($styleNo != "")	
	$sql .= " AND strStyle ='$styleNo'";
	
$sql .= " Order By intSRNO DESC";
$result=$db->RunQuery($sql);
	$str_sc .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$str_sc .= "<option value=\"". $row["intStyleId"] ."\">".$row["intSRNO"]."</option>\n";	
}

 $ResponseXML .= "<orderNo><![CDATA[" . $str . "]]></orderNo>\n";
 $ResponseXML .= "<SCNo><![CDATA[" . $str_sc . "]]></SCNo>\n";
$ResponseXML .= "</XMLStyleDetails>\n";
echo $ResponseXML;
}

elseif($RequestType=="loadStyleNo")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$status  = $_GET["status"];
$ResponseXML = "<XMLStyleDetails>\n";

	$sql = " select distinct O.strStyle from orders O
inner join specification S on O.intStyleId=S.intStyleId ";

	if($status != 0)
		$sql .= " where intStatus='$status'";
	$sql .= " Order By strStyle";

$result=$db->RunQuery($sql);
	$str_sc .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$str_sc .= "<option value=\"". $row["strStyle"] ."\">".$row["strStyle"]."</option>\n";	
}

 $ResponseXML .= "<styleNoList><![CDATA[" . $str_sc . "]]></styleNoList>\n";		
$ResponseXML .= "</XMLStyleDetails>\n";
echo $ResponseXML;
}
elseif($RequestType=="getReportType")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$type  = $_GET["type"];
$ResponseXML = "<XMLReportList>\n";

 	$sqlReport_bulk = "select strValue from settings where strKey='BulkReportId' ";
	$resultReport_bulk = $db->RunQuery($sqlReport_bulk);
	$rowB = mysql_fetch_array($resultReport_bulk);
	$bulkReportId =  $rowB["strValue"];
	
	if($type == 'bulk')
		$sql = "select strReportCode,strReportType from reporttype where intReportId  in ($bulkReportId) ";
	else
		$sql = "select strReportCode,strReportType from reporttype where intReportId not in ($bulkReportId) ";	
	$result = $db->RunQuery($sql); 
	while($row = mysql_fetch_array($result))
	{
		$str .= "<option value=\"". $row["strReportCode"] ."\">" . trim($row["strReportType"]) ."</option>"; 
	}
 $ResponseXML .= "<reportType><![CDATA[" . $str . "]]></reportType>\n";		
$ResponseXML .= "</XMLReportList>\n";
echo $ResponseXML;
}
?>
