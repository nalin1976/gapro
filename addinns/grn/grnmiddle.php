<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<GRN>";

$RequestType = $_GET["GRNNo"];

	$SQL="SELECT * FROM grnexcessqty where intNo =".$RequestType.";";

	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<From><![CDATA[" . $row["intFrom"]  . "]]></From>\n";
        $ResponseXML .= "<To><![CDATA[" . $row["strTo"]  . "]]></To>\n";
	    $ResponseXML .= "<Percentage><![CDATA[" . $row["dblPercentage"]  . "]]></Percentage>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}	
	 $ResponseXML .= "</GRN>";
	 echo $ResponseXML;

?>

