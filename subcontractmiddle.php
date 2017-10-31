<?php
session_start();
include "Connector.php";

header('Content-Type: text/xml'); 

$RequestType = $_GET["RequestType"];

if ($RequestType == "saveSubcontractDetails")
{
	$styleID = $_GET["styleID"];
	$buyerPO = $_GET["buyerPO"];
	$contractor = $_GET["contractor"];
	$fob = $_GET["fob"];
	$cm = $_GET["cm"];
	$delDate = $_GET["delDate"];
	$qty = $_GET["qty"];
	$year = substr($delDate,-4);
	$month = substr($delDate,-7,-5);
	$day = substr($delDate,-10,-8);
	$dtDateofDelivery = $year . "-" . $month . "-" . $day;
	
	$sql = "INSERT INTO subcontractororders 
	(intStyleId, 
	intSubContractorID, 
	strBuyerPONO, 
	intQty, 
	fob, 
	cm, 
	deliveryDate
	)
	VALUES
	('$styleID', 
	'$contractor', 
	'$buyerPO', 
	'$qty', 
	'$fob', 
	'$cm', 
	'$dtDateofDelivery'
	);";	

	echo $db->executeQuery($sql);	
	
}
else if ($RequestType == "showSubContractDetails")
{
	$styleID = $_GET["styleID"];
	$buyerPO = $_GET["buyerPO"];
	$sql = "SELECT intSubContractorID,intQty,fob,cm, DATE_FORMAT(deliveryDate, '%d/%m/%Y') as deliveryDate  FROM subcontractororders WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPO'";
	$result = $db->RunQuery($sql);
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	echo "<RequestDetails>\n";
	while($row = mysql_fetch_array($result))
  	{
  		echo "<Subcontractor><![CDATA[" . $row["intSubContractorID"]  . "]]></Subcontractor>\n";
  		echo "<Qty><![CDATA[" . $row["intQty"]  . "]]></Qty>\n";
		echo "<Fob><![CDATA[" . $row["fob"]  . "]]></Fob>\n";
		echo "<CM><![CDATA[" . $row["cm"]  . "]]></CM>\n";
		echo "<DelDate><![CDATA[" . $row["deliveryDate"]  . "]]></DelDate>\n";
  	}
	echo "</RequestDetails>";
}
else if ($RequestType == "deleteSubContractDetails")
{
	$styleID = $_GET["styleID"];
	$buyerPO = $_GET["buyerPO"];
	$sql = "DELETE FROM subcontractororders WHERE intStyleId = '$styleID' AND strBuyerPONO = '$buyerPO'";
	echo $db->executeQuery($sql);
		
	
}

?>