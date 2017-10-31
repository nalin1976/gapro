<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<CurrencyTypes>";


$RequestType = $_GET["CurrencyID"];

	$SQL="SELECT * FROM currencytypes where intCurID='".$RequestType."' order by strCurrency asc;";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		$dblRate=0;
		$SQL1="select intBaseCurrency from systemconfiguration where intBaseCurrency='$RequestType'";
		$result1 = $db->RunQuery($SQL1);
		while($row1 = mysql_fetch_array($result1))
		{
			$dblRate=1;
		}
		
		
		
         $ResponseXML .= "<CurrencyName><![CDATA[" . $row["strCurrency"]  . "]]></CurrencyName>\n";
         $ResponseXML .= "<Title><![CDATA[" . $row["strTitle"]  . "]]></Title>\n";
		 $ResponseXML .= "<dblExRate><![CDATA[" . $row["dblExRate"]  . "]]></dblExRate>\n";
		 $ResponseXML .= "<FractionalUnit><![CDATA[" . $row["strFractionalUnit"]  . "]]></FractionalUnit>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";  
		 $ResponseXML .= "<dblRate><![CDATA[" . $dblRate  . "]]></dblRate>\n"; 
		 $ResponseXML .= "<Country><![CDATA[" . $row["intConID"]  . "]]></Country>\n"; 
    
	}
	 $ResponseXML .= "</CurrencyTypes>";
	 echo $ResponseXML;

?>
