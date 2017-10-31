<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Agents>";

$RequestType = $_GET["AgentId"];

	$SQL="SELECT * FROM shipping_agents where intAgentId = ".$RequestType.";";
	
	$result = $db->RunQuery($SQL);
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
		 $ResponseXML .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		 $ResponseXML .= "<Address2><![CDATA[" . $row["strAddress2"]  . "]]></Address2>\n";
		 $ResponseXML .= "<Street><![CDATA[" . $row["strStreet"]  . "]]></Street>\n";
		 $ResponseXML .= "<City><![CDATA[" . $row["strCity"]  . "]]></City>\n";
		 $ResponseXML .= "<State><![CDATA[" . $row["strState"]  . "]]></State>\n";
		 $ResponseXML .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";
		 $ResponseXML .= "<ZipCode><![CDATA[" . $row["strZipCode"]  . "]]></ZipCode>\n";         
		 $ResponseXML .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		 $ResponseXML .= "<EMail><![CDATA[" . $row["strEMail"]  . "]]></EMail>\n";
		 $ResponseXML .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		 $ResponseXML .= "<Web><![CDATA[" . $row["strWeb"]  . "]]></Web>\n";
		 $ResponseXML .= "<ContactPerson><![CDATA[" . $row["strContactPerson"]  . "]]></ContactPerson>\n";
		 $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		     
	}
	 $ResponseXML .= "</Agents>";
	 echo $ResponseXML;

?>
