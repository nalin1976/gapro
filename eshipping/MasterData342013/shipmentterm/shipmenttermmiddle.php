<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Shipment>";


$RequestType = $_GET["Shipmentload"];

	$SQL="SELECT * FROM shipmentterms where strShipmentTermId='".$RequestType."';";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<ShipmentTermId><![CDATA[" . $row["strShipmentTermId"]  . "]]></ShipmentTermId>\n";
         $ResponseXML .= "<ShipmentTerm><![CDATA[" . $row["strShipmentTerm"]  . "]]></ShipmentTerm>\n";
	}
	 $ResponseXML .= "</Shipment>";
	 echo $ResponseXML;

?>