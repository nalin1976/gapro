<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

//------View selected bank details----------------------------------------------------------------------------
$ResponseXML .= "<Bank>";

$bankID = $_GET["bankID"];


	$SQL="SELECT * FROM bank where intBankId='".$bankID."';";

	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<BankCode><![CDATA[" . $row["strBankCode"]  . "]]></BankCode>\n";
        $ResponseXML .= "<BankName><![CDATA[" . $row["strBankName"]  . "]]></BankName>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n"; 
		$ResponseXML .= "<Used><![CDATA[" . $row["intUsed"]  . "]]></Used>\n"; 
	}	
	 $ResponseXML .= "</Bank>";
	 echo $ResponseXML;
//----------------------------------------------------------------------------------------------	 

?>