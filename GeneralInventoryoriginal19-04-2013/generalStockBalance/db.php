<?php
include "../../Connector.php";
$RequestType	= $_GET["RequestType"];
$companyId  	= $_SESSION["FactoryID"];
$userId			= $_SESSION["UserID"];

if($RequestType=="LoadSubCategory")
{
header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$mainId = $_GET["mainId"];

$ResponseXML = "<XMLloadMainCategory>\n";

$sql="SELECT MSC.intSubCatNo, MSC.StrCatName FROM genmatsubcategory MSC WHERE MSC.intCatNo<>''";
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

$ResponseXML = "<XMLLoadMaterial>\n";

	$sql="SELECT MIL.intItemSerial, MIL.strItemDescription FROM genmatitemlist MIL WHERE MIL.intMainCatID <>'' ";
if($mainId!="")
	$sql .=" AND MIL.intMainCatID =  '$mainId'";
if($subCatId!="")
	$sql .=" AND MIL.intSubCatID =  '$subCatId'";
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

	$sql="select O.intStyleId,O.strStyle from orders O
inner join specification S on O.intStyleId=S.intStyleId where strStyle<>''";
 
 if($status!=0)
 	$sql .= " AND intStatus='$status'";
	
$sql .= " Order By strStyle";

$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["intStyleId"] ."\">".$row["strStyle"]."</option>\n";	
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
elseif($RequestType=="LoadMatItemList")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$mainId = $_GET["mainCat"];
	$subCat = $_GET["subCat"];
	$matItem = $_GET["matItem"];
	
	$ResponseXML = "<XMLloadMainCategory>\n";

	$sql="SELECT MIL.intItemSerial, MIL.strItemDescription 
							FROM genmatitemlist MIL Where MIL.intMainCatID = '$mainId' ";
	if($subCat!="")
	$sql .=" AND MIL.intSubCatID ='$subCat'";
	
	if($matItem !="")
	$sql .=" AND MIL.strItemDescription like  '%$matItem%'";
		
	$sql .=" order by MIL.strItemDescription";
	
	$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
	
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<option value=\"". $row["intItemSerial"] ."\">".$row["strItemDescription"]."</option>\n";	
	}
	$ResponseXML .= "</XMLloadMainCategory>\n";
	echo $ResponseXML;
}
elseif($RequestType=="URLLoadCostCenter")
{
$factoryId = $_GET["FactoryId"];

	$sql="select intCostCenterId,strDescription from costcenters where intFactoryId='$factoryId' and intStatus=1 order by strDescription";

$result=$db->RunQuery($sql);
	$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
while($row=mysql_fetch_array($result))
{
	$ResponseXML .= "<option value=\"". $row["intCostCenterId"] ."\">".$row["strDescription"]."</option>\n";	
}
echo $ResponseXML;
}
elseif($RequestType=="URLLoadGLCode")
{
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$ResponseXML = "<XMLLoadGLCode>\n";
	
	$costCenterId = $_GET["costCenterId"];
	if($costCenterId!="")
	{
		$sql = "select GLA.GLAccAllowNo,GA.strDescription
				from glallowcation GLA
				inner join glaccounts GA on GA.intGLAccID = GLA.GLAccNo
				inner join costcenters C on C.intCostCenterId=GLA.FactoryCode
				where C.intCostCenterId='$costCenterId' 
				order by GA.strDescription";

		$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=\"". $row["GLAccAllowNo"] ."\">".$row["strDescription"]."</option>\n";	
		}
	}
	else
	{
		$sql = "select intGLAccID,strDescription from glaccounts where intStatus=1 
				order by strDescription ";

		$result=$db->RunQuery($sql);
		$ResponseXML .= "<option value=\"". "" ."\">".""."</option>\n";
		while($row=mysql_fetch_array($result))
		{
			$ResponseXML .= "<option value=\"". $row["intGLAccID"] ."\">".$row["strDescription"]."</option>\n";	
		}
	}
	$ResponseXML .= "</XMLLoadGLCode>\n";
	echo $ResponseXML;
}
?>
