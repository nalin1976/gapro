<?php

include "../../Connector.php";

header('Content-Type: text/xml');  
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

//$ResponseXML .= "<Units>"
$ResponseXML .= "<Units>";

$RequestType = $_GET["UnitsID"];


	$SQL="SELECT * FROM units where intUnitID='".$RequestType."';";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<UnitName><![CDATA[" . $row["strUnit"]  . "]]></UnitName>\n";
         $ResponseXML .= "<Title><![CDATA[" . $row["strTitle"]  . "]]></Title>\n";
		 $ResponseXML .= "<PcsForUnit><![CDATA[" . $row["intPcsForUnit"]  . "]]></PcsForUnit>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		 $ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n"; 
		 
	}
	 $ResponseXML .= "</Units>";
	 echo $ResponseXML;

?>

