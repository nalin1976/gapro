<?php
include "../../Connector.php";
$requestType	= $_GET["RequestType"];
header('Content-Type: text/xml'); 

if($requestType=="URLGetOrderType")
{
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
$ResponseXML = "<XMLGetOrderType>";
$orderTypeId	= $_GET["OrderTypeId"];
	$sql = "select strTypeName,intStatus from orders_ordertype where intTypeId='$orderTypeId'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<Description><![CDATA[" . $row["strTypeName"]  . "]]></Description>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}
$ResponseXML .= "</XMLGetOrderType>";
echo $ResponseXML;
}
elseif($requestType=="URLSaveOrderType")
{
$orderTypeId	= $_GET["OrderTypeId"];
$description	= $_GET["Description"];
$status			= $_GET["Status"];

	if($orderTypeId=="")
	{
		$result = Insert($description,$status);
		if($result)
			echo "Saved successfully.";
		else
			echo "Error occur while saving data. Please save it again.";
	}
	else
	{
		$result = Update($orderTypeId,$description,$status);
		if($result)
			echo "Updated successfully.";
		else
			echo "Error occur while updating data. Please save it again.";
	}
}

//BEGIN
function Insert($description,$status)
{
global $db;
	$sql = "insert into orders_ordertype (strTypeName, intStatus)values('$description', '$status');";
	return $db->RunQuery($sql);
}

function Update($orderTypeId,$description,$status)
{
global $db;
	$sql = "update orders_ordertype set strTypeName = '$description' ,intStatus = '$status' where intTypeId = '$orderTypeId' ;";
	return $db->RunQuery($sql);
}
//END
?>