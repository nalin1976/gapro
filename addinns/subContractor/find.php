<?php
include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<SubContractor>";

$RequestType = $_GET["q"];

	$SQL="SELECT * FROM subcontractors where strSubContractorID=".$RequestType."";
	//$ResponseXML .= $_GET["q"];
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<strName><![CDATA[" . $row["strName"]  . "]]></strName>\n";
		 $ResponseXML .= "<strAddress1><![CDATA[" . $row["strAddress1"]  . "]]></strAddress1>\n";  
		 
		 $ResponseXML .= "<strStreet><![CDATA[" . $row["strStreet"]  . "]]></strStreet>\n";
		 $ResponseXML .= "<strCity><![CDATA[" . $row["strCity"]  . "]]></strCity>\n";
		 $ResponseXML .= "<strCountry><![CDATA[" . $row["strCountry"]  . "]]></strCountry>\n";
		 $ResponseXML .= "<strPhone><![CDATA[" . $row["strPhone"]  . "]]></strPhone>\n";
		 $ResponseXML .= "<strEmail><![CDATA[" . $row["strEMail"]  . "]]></strEmail>\n";
		 $ResponseXML .= "<strWeb><![CDATA[" . $row["strWeb"]  . "]]></strWeb>\n";
		 $ResponseXML .= "<strRemarks><![CDATA[" . $row["strRemarks"]  . "]]></strRemarks>\n";
		 $ResponseXML .= "<strState><![CDATA[" . $row["strState"]  . "]]></strState>\n";
		 $ResponseXML .= "<strZipCode><![CDATA[" . $row["strZipCode"]  . "]]></strZipCode>\n";
		 $ResponseXML .= "<strFax><![CDATA[" . $row["strFax"]  . "]]></strFax>\n";
		 $ResponseXML .= "<strContPerson><![CDATA[" . $row["strContPerson"]  . "]]></strContPerson>\n";
		 $ResponseXML .= "<strContPhone><![CDATA[" . $row["strContPersonPhone"]  . "]]></strContPhone>\n";
		 $ResponseXML .= "<vatReg><![CDATA[" . $row["strVatNo"]  . "]]></vatReg>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}
	 $ResponseXML .= "</SubContractor>";
	 echo $ResponseXML;
	 
?>	
