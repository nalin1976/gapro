<?php

include "../../Connector.php";

header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$RequestType	= $_GET["RequestType"];

if($RequestType=="SaveValidation")
{
$DeliveryCode = $_GET["DeliveryCode"];
$ResponseXML = "<SaveValidation>\n";

	$sql="select strDeliveryCode  from deliveryterms where strDeliveryCode='$DeliveryCode';";
	
	$result = $db->RunQuery($sql);
	$rowCount = mysql_num_rows($result);
	
	if($rowCount>0)
	{
		$ResponseXML .= "<Validate><![CDATA[TRUE]]></Validate>\n";
	}
	else
	{
		$ResponseXML .= "<Validate><![CDATA[FALSE]]></Validate>\n";
	}
$ResponseXML .= "</SaveValidation>";
echo $ResponseXML;
}
elseif($RequestType=="GetDetails")
{
$SearchID = $_GET["SearchID"];
$ResponseXML = "<GetDetails>\n";

	$sql="select *  from deliveryterms where intDeliveryID='$SearchID';";
	
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$ResponseXML .= "<DeliveryCode><![CDATA[" . $row["strDeliveryCode"]  . "]]></DeliveryCode>\n";
		$ResponseXML .= "<DeliveryName><![CDATA[" . $row["strDeliveryName"]  . "]]></DeliveryName>\n";
	}
$ResponseXML .= "</GetDetails>";
echo $ResponseXML;

}
?>

