<?php
session_start();
include "../../Connector.php";

$request = $_GET["request"];
header('Content-Type: text/xml'); 


if ($request == "getdata")
{ 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$company= $_GET["COMPANYID"];
	$XMLString= "<Data>";
	$XMLString .= "<Buyer>";
	
	$sql="SELECT intSequenceNo,strCustomerID,strName,strMLocation,strAddress1,strAddress2,strCountry,strPhone,strFax,strEMail,strRemarks,
	strTIN,strCode,strLocation,strTQBNo,strExportRegNo,strRefNo,strCompanyCode,RecordType,strPPCCode,bitLocatedAtAZone, 
	strAuthorizedPerson,strVendorCode,strMIDCode,bitMailClearanceInfo,strLicenceNo,strFacCode FROM customers WHERE strCustomerID='$company'";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{ 
		$XMLString .= "<CompanyId><![CDATA[" . $row["strCustomerID"]  . "]]></CompanyId>\n";
		$XMLString .= "<companyname><![CDATA[" . $row["strName"]  . "]]></companyname>\n";
		$XMLString .= "<Mlocation><![CDATA[" . $row["strMLocation"]  . "]]></Mlocation>";
		$XMLString .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		$XMLString .= "<Address2><![CDATA[" . $row["strAddress2"]  . "]]></Address2>\n";
		$XMLString .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";
		$XMLString .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		$XMLString .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		$XMLString .= "<Email><![CDATA[" . $row["strEMail"]  . "]]></Email>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<TINO><![CDATA[" . $row["strTIN"]  . "]]></TINO>\n";
		$XMLString .= "<Sequenceno><![CDATA[" . $row["strCode"]  . "]]></Sequenceno>\n";
		$XMLString .= "<Location><![CDATA[" . $row["strLocation"]  . "]]></Location>\n";
		$XMLString .= "<TQBNo><![CDATA[" . $row["strTQBNo"]  . "]]></TQBNo>\n";
		$XMLString .= "<ExportRegNo><![CDATA[" . $row["strExportRegNo"]  . "]]></ExportRegNo>\n";	
		$XMLString .= "<RefNo><![CDATA[" . $row["strRefNo"]  . "]]></RefNo>\n";
		$XMLString .= "<MailClearanceInfo><![CDATA[" . $row["bitMailClearanceInfo"]  . "]]></MailClearanceInfo>\n";
		$XMLString .= "<PPCCode><![CDATA[" . $row["strPPCCode"]  . "]]></PPCCode>\n";
		$XMLString .= "<AuthorizedPerson><![CDATA[" . $row["strAuthorizedPerson"]  . "]]></AuthorizedPerson>\n";
		$XMLString .= "<LocatedAtAZone><![CDATA[" . $row["bitLocatedAtAZone"]  . "]]></LocatedAtAZone>\n";
		$XMLString .= "<VendorCode><![CDATA[" . $row["strVendorCode"]  . "]]></VendorCode>\n";
		$XMLString .= "<MIDCode><![CDATA[" . $row["strMIDCode"]  . "]]></MIDCode>\n";
		//$XMLString .= "<Sequenceno><![CDATA[" . $row["intSequenceNo"]  . "]]></Sequenceno>\n";
		$XMLString .= "<LicenceNo><![CDATA[" . $row["strLicenceNo"]  . "]]></LicenceNo>\n";
		$XMLString .= "<FacCode><![CDATA[" . $row["strFacCode"]  . "]]></FacCode>\n";
		
			
		
		//$XMLString .= ""
		
	}
	
	$XMLString .= "</Buyer>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

else if ($request == "checkdb")
{	
		$companyname=$_GET["COMPANYNAME"];
		$companycode= $_GET["COMPANYID"];
		$location= $_GET["location"];
	
	
	if($companycode)
	{
		$sql="SELECT strCustomerID FROM customers
		WHERE strCustomerID != '$companycode' AND strMLocation='$location'";

		$result = $db->RunQuery($sql);
		if (mysql_num_rows($result)>0)
		{
			
			echo "cant"	;
		}
		else
		{
			echo "update" ;
			
				
		}
	}
	
	else
	{
	
	{
		$sql="SELECT strMLocation FROM customers 
		WHERE strMLocation='$location'";
		
		$result = $db->RunQuery($sql);
		
		if (mysql_num_rows($result)>0)
		{
			echo "cant";	
	
		}
		else
		{
			echo "insert";
		}
		
	}	
	}
	
}
?>