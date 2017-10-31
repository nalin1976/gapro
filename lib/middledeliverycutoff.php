<?php

require_once("../Connector.php");
require_once("../classes/class_delivery.php");
require_once("../classes/class_common.php");

$classDelivery 	= new DeliveryCutOff();
$classCommon	= new CommonPHP();

$classDelivery->SetConnection($db);

$Request_Type = $_GET['RequestType'];

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

if($Request_Type == 'CutOffDelivery'){
	
	$_buyerCode		= $_GET["buyercode"];
	$_cutoffdate	= $_GET["cutoff"];
	
	$_cutoffdate	= $classCommon->GetFormatDateToDB($_cutoffdate);
	
	/*$year = substr($bpoDelivery,-4);
	$month = substr($bpoDelivery,-7,-5);
	$day = substr($bpoDelivery,-10,-8);
	$bpoDelivery = $year . "-" . $month . "-" . $day;*/
	
	$res 		= $classDelivery->GetBuyerPOList($_buyerCode, $_cutoffdate);
	
	$ResponseXML = "<CutOffDeliveries>";
	
	while($row = mysql_fetch_array($res)){
	
		$ResponseXML .= "<SCNO>".$row["intSRNO"]."</SCNO>";	
		$ResponseXML .= "<StyleID>".$row["strStyle"]."</StyleID>";
		$ResponseXML .= "<Merchant>".$row["Name"]."</Merchant>";
		$ResponseXML .= "<Buyer>".$row["strName"]."</Buyer>";
		$ResponseXML .= "<BuyerPONo>".$row["intBPO"]."</BuyerPONo>";
		$ResponseXML .= "<CutOffDate>".$row["dtmCutOffDate"]."</CutOffDate>";
		$ResponseXML .= "<DeliveryDate>".date_format(date_create($row["dtDateofDelivery"]), 'Y-m-d')."</DeliveryDate>";	
		$ResponseXML .= "<Qty>".$row["dblQty"]."</Qty>";
		
	}
	
	
	$ResponseXML .= "</CutOffDeliveries>";
	
	echo $ResponseXML;
	
}


?>