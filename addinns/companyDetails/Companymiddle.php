<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<CompanyDetails>";


$RequestType = $_GET["Company"];


	$SQL="SELECT * FROM companies where intCompanyID='".$RequestType."'";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
    //     $ResponseXML .= "<CompanyID><![CDATA[" . $row["intCompanyID"]  . "]]></CompanyID>\n";
         $ResponseXML .= "<CompanyCode><![CDATA[" . $row["strComCode"]  . "]]></CompanyCode>\n";
		 $ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
		 $ResponseXML .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		 $ResponseXML .= "<street><![CDATA[" . $row["strStreet"]  . "]]></street>\n";
		 $ResponseXML .= "<city><![CDATA[" . $row["strCity"]  . "]]></city>\n";
		 $ResponseXML .= "<country><![CDATA[" . $row["intCountry"]  . "]]></country>\n";
		 
		 $ResponseXML .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		 $ResponseXML .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n"; 
		 $ResponseXML .= "<EMail><![CDATA[" . $row["strEMail"]  . "]]></EMail>\n";
		 $ResponseXML .= "<Web><![CDATA[" . $row["strWeb"]  . "]]></Web>\n";
		 $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		 $ResponseXML .= "<TINNo><![CDATA[" . $row["strTINNo"]  . "]]></TINNo>\n"; 
		 $ResponseXML .= "<RegNo><![CDATA[" . $row["strRegNo"]  . "]]></RegNo>\n";
		 $ResponseXML .= "<VatAcNo><![CDATA[" . $row["strVatAcNo"]  . "]]></VatAcNo>\n";
		 $ResponseXML .= "<VatValue><![CDATA[" . $row["dblVatValue"]  . "]]></VatValue>\n";
		 $ResponseXML .= "<BOINo><![CDATA[" . $row["strBOINo"]  . "]]></BOINo>\n";            
		 $ResponseXML .= "<FactroyCostPerMin><![CDATA[" . $row["reaFactroyCostPerMin"]  . "]]></FactroyCostPerMin>\n";
		 $ResponseXML .= "<TQBNo><![CDATA[" . $row["strTQBNO"]  . "]]></TQBNo>\n";
		 $ResponseXML .= "<defaultFactory><![CDATA[" . $row["strDefaultInvoiceTo"]  . "]]></defaultFactory>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n"; 
		 $ResponseXML .= "<Currency><![CDATA[" . $row["intCurID"]  . "]]></Currency>\n"; 
		 $ResponseXML .= "<intManufac><![CDATA[" . $row["intManufacturing"]  . "]]></intManufac>\n"; 
		 $ResponseXML .= "<accountNo><![CDATA[" . $row["strAccountNo"]  . "]]></accountNo>\n"; 
		  $ResponseXML .= "<used><![CDATA[" . $row["intUsed"]  . "]]></used>\n"; 
		 
	}
	 $ResponseXML .= "</CompanyDetails>";
	 echo $ResponseXML;

?>