<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Item>";


$RequestType = $_GET["OriginID"];

	$SQL="SELECT * FROM itempurchasetype where intOriginNo=".$RequestType.";";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<OriginNo><![CDATA[" . $row["intOriginNo"]  . "]]></OriginNo>\n";
         $ResponseXML .= "<OriginType><![CDATA[" . $row["strOriginType"]  . "]]></OriginType>\n";
		 $ResponseXML .= "<intType><![CDATA[" . $row["intType"]  . "]]></intType>\n";
		 $ResponseXML .= "<intStatus><![CDATA[" . $row["intStatus"]  . "]]></intStatus>\n";
		 $ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n"; 
		  $ResponseXML .= "<originDescription><![CDATA[" . $row["strDescription"]  . "]]></originDescription>\n"; 
	}
	 $ResponseXML .= "</Item>";
	 echo $ResponseXML;

?>
