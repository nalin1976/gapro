<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<CurrencyTypes>";


$RequestType = $_GET["CurrencyID"];

	$SQL="SELECT * FROM currencytypes where strCurrency='".$RequestType."';";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<CurrencyName><![CDATA[" . $row["strCurrency"]  . "]]></CurrencyName>\n";
         $ResponseXML .= "<Title><![CDATA[" . $row["strTitle"]  . "]]></Title>\n";
		 $ResponseXML .= "<Rate><![CDATA[" . $row["dblRate"]  . "]]></Rate>\n";
		 $ResponseXML .= "<FractionalUnit><![CDATA[" . $row["strFractionalUnit"]  . "]]></FractionalUnit>\n";
    
	}
	 $ResponseXML .= "</CurrencyTypes>";
	 echo $ResponseXML;

?>
