<?php
include "../../Connector.php";
$requestType 	= $_GET["RequestType"];
if($requestType=="LoadOrderAndScNo")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleNo	= $_GET["StyleNo"];
$status		= $_GET["Status"];
$ResponseXML = "<XMLLoadOrderAndScNo>\n";
	$sql="select  o.intStyleId,o.strOrderNo from orders o inner join 
firstsalecostworksheetheader fs on o.intStyleId = fs.intStyleId
where fs.intStatus=0 ";
	if($styleNo!="")
		$sql .= "and o.strStyle='$styleNo' ";
		$sql .= "order by o.strOrderNo";
	//echo $sql;	
	$result=$db->RunQuery($sql);
		$orderNo = "<option value="."".">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$orderNo .= "<option value=".$row["intStyleId"].">".$row["strOrderNo"]."</option>\n";
	}
	
		$sql="select  o.intStyleId,s.intSRNO from orders o inner join 
firstsalecostworksheetheader fs on o.intStyleId = fs.intStyleId
inner join specification s on s.intStyleId = o.intStyleId
and s.intStyleId = fs.intStyleId
where fs.intStatus=0  ";
	if($styleNo!="")
		$sql .= "and o.strStyle='$styleNo' ";
		$sql .= "order by s.intSRNO desc";
	$result=$db->RunQuery($sql);
		$ScNo = "<option value="."".">".""."</option>\n";
	while($row=mysql_fetch_array($result))
	{
		$ScNo .= "<option value=".$row["intStyleId"].">".$row["intSRNO"]."</option>\n";
	}
		$ResponseXML .= "<OrderNo><![CDATA[" . $orderNo  . "]]></OrderNo>\n";
		$ResponseXML .= "<ScNo><![CDATA[" . $ScNo  . "]]></ScNo>\n";
$ResponseXML .= "</XMLLoadOrderAndScNo>\n";
echo $ResponseXML;
}

else if($requestType=="loadOrderDetails")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$orderNo	= $_GET["orderNo"];
$ResponseXML = "<XMLLoadOrderDetails>\n";
	
	$fabricDesc = getItemDescription($orderNo,1);
	$pocketingDesc = getItemDescription($orderNo,2);
	$result = getStyleName($orderNo);
	$row = mysql_fetch_array($result);
	
$ResponseXML .= "<fabric><![CDATA[" . $fabricDesc  . "]]></fabric>\n";
$ResponseXML .= "<pocketing><![CDATA[" . $pocketingDesc  . "]]></pocketing>\n";
$ResponseXML .= "<styleName><![CDATA[" . $row["strStyle"]  . "]]></styleName>\n";
$ResponseXML .= "</XMLLoadOrderDetails>\n";
echo $ResponseXML;

} 

else if($requestType=="saveOrderDetails")
{
$orderNo	= $_GET["orderNo"];
$fabConpc   = $_GET["fabConpc"];
$pocketConpc = $_GET["pocketConpc"];
$threadConpc = $_GET["threadConpc"];
$smv		 = $_GET["smv"];
$dryWashPrice	= $_GET["dryWashPrice"];
$wetWashPrice	= $_GET["wetWashPrice"];

//check record available in firstsale_actualdata
	$chkOrderAv=0;
	$chkOrderAv = checkOrderDetailsAv($orderNo);
	if($chkOrderAv!=1)
		$response = insertActualData($orderNo);

	if($fabConpc != '')
		$response = updateActualData($orderNo,$fabConpc,'dblFabricConpc');
	if($pocketConpc != '')		
		$response = updateActualData($orderNo,$pocketConpc,'dblPocketConpc');
	if($threadConpc != '')		
		$response = updateActualData($orderNo,$threadConpc,'dblThreadConpc');
	if($smv != '')		
		$response = updateActualData($orderNo,$smv,'dblSMV');
	if($dryWashPrice != '')
		$response = updateActualData($orderNo,$dryWashPrice,'dblDryWashPrice');	
	if($wetWashPrice != '')
		$response = updateActualData($orderNo,$wetWashPrice,'dblWetWashPrice');		
	
	if($response == '1')
		echo 'saved';
	else
		echo 'fail';		
}
else if($requestType=="getPendingDetails")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$orderNo	= $_GET["styleId"];
$ResponseXML = "<XMLLoadOrderDetails>\n";
	
	$fabricDesc = getItemDescription($orderNo,1);
	$pocketingDesc = getItemDescription($orderNo,2);
	$result = getOrderDetails($orderNo);
	
	$rows = mysql_fetch_array($result);
	$fabConpc = $rows["dblFabricConpc"];
	$poConpc = $rows["dblPocketConpc"];
	$threadConpc = $rows["dblThreadConpc"];
	$smv = $rows["dblSMV"];
	$dryWash = $rows["dblDryWashPrice"];
	$wetWash = $rows["dblWetWashPrice"];	
	
$ResponseXML .= "<fabric><![CDATA[" . $fabricDesc  . "]]></fabric>\n";
$ResponseXML .= "<pocketing><![CDATA[" . $pocketingDesc  . "]]></pocketing>\n";
$ResponseXML .= "<fabConpc><![CDATA[" . $fabConpc  . "]]></fabConpc>\n";
$ResponseXML .= "<poConpc><![CDATA[" . $poConpc  . "]]></poConpc>\n";
$ResponseXML .= "<threadConpc><![CDATA[" . $threadConpc  . "]]></threadConpc>\n";
$ResponseXML .= "<smv><![CDATA[" . $smv  . "]]></smv>\n";
$ResponseXML .= "<dryWash><![CDATA[" . $dryWash  . "]]></dryWash>\n";
$ResponseXML .= "<wetWash><![CDATA[" . $wetWash  . "]]></wetWash>\n";
$ResponseXML .= "<styleNo><![CDATA[" . $rows["strStyle"]  . "]]></styleNo>\n";
$ResponseXML .= "<styleDescription><![CDATA[" . $rows["strDescription"]  . "]]></styleDescription>\n";
$ResponseXML .= "</XMLLoadOrderDetails>\n";
echo $ResponseXML;

}
else if($requestType=="getPrevStyleDetails")
{
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$styleName	= $_GET["styleName"];
$styleId = $_GET["styleId"];

$ResponseXML = "<XMLLoadStyleDetails>\n";

	$sql = "select fs.dblDryWashPrice,fs.dblWetWashPrice,fs.dblSMV,o.strStyle,o.strDescription from firstsale_actualdata fs inner join 
orders o on o.intStyleId = fs.intStyleId
where o.strStyle='$styleName' ";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);

	$ResponseXML .= "<smv><![CDATA[" . $row["dblSMV"]  . "]]></smv>\n";
	$ResponseXML .= "<dryWash><![CDATA[" . $row["dblDryWashPrice"]  . "]]></dryWash>\n";
	$ResponseXML .= "<wetWash><![CDATA[" . $row["dblWetWashPrice"]  . "]]></wetWash>\n";
	
	$rowO = mysql_fetch_array(getStyleName($styleId));
	$ResponseXML .= "<styleNo><![CDATA[" . $rowO["strStyle"]  . "]]></styleNo>\n";
$ResponseXML .= "<styleDescription><![CDATA[" . $rowO["strDescription"]  . "]]></styleDescription>\n";
$ResponseXML .= "</XMLLoadStyleDetails>\n";
echo $ResponseXML;

}
function getItemDescription($styleId,$categoty)
{
	global $db;
	$sql = "select id.strItemCode,mil.strItemDescription from invoicecostingdetails id 
inner join matitemlist mil on mil.intItemSerial = id.strItemCode
inner join invoicecostingcategory ic on ic.intCategoryId= id.strType
where id.intStyleId='$styleId' and id.strType ='$categoty' ";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	
	return $row["strItemDescription"];
}

function getOrderDetails($orderNo)
{
	global $db;
	$sql = "select fs.intStyleId,fs.strOrderNo,fsa.dblFabricConpc,fsa.dblPocketConpc,fsa.dblThreadConpc,fsa.dblSMV,
fsa.dblDryWashPrice,fsa.dblWetWashPrice,o.strStyle,o.strDescription
from firstsalecostworksheetheader fs inner join firstsale_actualdata fsa on
fs.intStyleId = fsa.intStyleId and fs.intStatus=0 
inner join orders o on o.intStyleId=fs.intStyleId and fs.intStyleId='$orderNo'";
	return $db->RunQuery($sql);
}

function checkOrderDetailsAv($orderNo)
{
global $db;

	$sql = "select * from firstsale_actualdata where intStyleId='$orderNo'"	;
	return $db->CheckRecordAvailability($sql);
}
function insertActualData($orderNo)
{
	global $db;
	
	$sql = "insert into firstsale_actualdata 
	(intStyleId	)values	('$orderNo')";
	return $db->RunQuery($sql);
}
function updateActualData($orderNo,$value,$fieldName)
{
	global $db;
	
	$sql = "update firstsale_actualdata 
	set
	$fieldName = '$value' 	
	where
	intStyleId = '$orderNo' ";
	
	return $db->RunQuery($sql);
	
}
function getStyleName($orderNo)
{
	global $db;
	$sql= "select strStyle,strDescription from orders where intStyleId='$orderNo' ";
	$result = $db->RunQuery($sql);
	//$row = mysql_fetch_array($result);
	
	return $result;
}
?>