<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<shipment>";


$RequestType = $_GET["shipmentload"];


	$SQL="SELECT * FROM shipmentmode where intShipmentModeId ='".$RequestType."'  order by strDescription;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<ShipmentModeId><![CDATA[" . $row["intShipmentModeId"]  . "]]></ShipmentModeId>\n";
        $ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
		$ResponseXML .= "<strCode><![CDATA[" . $row["strCode"]  . "]]></strCode>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		 
		
	}
	 $ResponseXML .= "</shipment>";
	 echo $ResponseXML;

?>