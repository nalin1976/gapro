<?php	
	session_start();
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	include "../../../Connector.php";
	$RequestType	= $_GET["RequestType"];
	$companyId  	= $_SESSION["FactoryID"];
	$userId			= $_SESSION["UserID"];
if($RequestType=="LoadDetails")
{
	$deliveryNo	= $_GET["deliveryNo"];
	$ResponseXML  ="";
	$ResponseXML .= "<LoadDetails>\n";

$sql="select ". 
		"strEntryNo, ".
		"strMerchandiser, ".
		"strLocationOfGoods, ".
		"dtmClearedOn, ".
		"intClearedBy,".
		"strStyleId ".
		"from deliverynote ".
		"where intDeliveryNo='$deliveryNo'";
$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		
		$ResponseXML .= "<EntryNo><![CDATA[" . $row["strEntryNo"]  . "]]></EntryNo>\n";
		$ResponseXML .= "<Merchandiser><![CDATA[" . $row["strMerchandiser"]  . "]]></Merchandiser>\n";
		$ResponseXML .= "<LocationOfGoods><![CDATA[" . $row["strLocationOfGoods"]  . "]]></LocationOfGoods>\n";
		$ResponseXML .= "<ClearedBy><![CDATA[" . $row["intClearedBy"]  . "]]></ClearedBy>\n";
		$ResponseXML .= "<StyleId><![CDATA[" . $row["strStyleId"]  . "]]></StyleId>\n";
		$ClearedOn =substr($row["dtmClearedOn"],0,10);
						$ClearedOnArray=explode('-',$ClearedOn);
						$formatedClearedOn=$ClearedOnArray[2]."/".$ClearedOnArray[1]."/".$ClearedOnArray[0];
		$formatedClearedOn = ($ClearedOn=="" ? "":$formatedClearedOn);
		$ResponseXML .= "<ClearedOn><![CDATA[" . $formatedClearedOn . "]]></ClearedOn>\n";
	}
	$ResponseXML .= "</LoadDetails>";
	echo $ResponseXML;
}

?>