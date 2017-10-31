<?php
session_start();

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$request = $_GET["request"];


if ($request =="getData")
{
	$bankCode = $_GET["bankCode"];
	$XMLString= "<Data>";
	$XMLString .= "<BankData>";
	
	$sql = "SELECT strBankCode, strName,strAddress1, strAddress2, strCountry, strPhone, strFax, strEMail, strContactPerson, strRemarks, strRefNo,strBankFacilityAmount,strBankFacilityCurrency, strSwiftCode, strAccName
FROM bank WHERE strBankCode = '$bankCode'";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<BankCode><![CDATA[" . $row["strBankCode"]  . "]]></BankCode>\n";
		$XMLString .= "<BankName><![CDATA[" . $row["strName"]  . "]]></BankName>\n";
		$XMLString .= "<SwiftCode><![CDATA[" . $row["strSwiftCode"]  . "]]></SwiftCode>\n";
		$XMLString .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		$XMLString .= "<Address2><![CDATA[" . $row["strAddress2"]  . "]]></Address2>\n";
		$XMLString .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";
		$XMLString .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		$XMLString .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		$XMLString .= "<Email><![CDATA[" . $row["strEMail"]  . "]]></Email>\n";
		$XMLString .= "<ContactP><![CDATA[" . $row["strContactPerson"]  . "]]></ContactP>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<RefNo><![CDATA[" . $row["strRefNo"]  . "]]></RefNo>\n";
		$XMLString .= "<AccName><![CDATA[" . $row["strAccName"]  . "]]></AccName>\n";
		$XMLString .= "<Amount><![CDATA[" . $row["strBankFacilityAmount"]  . "]]></Amount>\n";
		$XMLString .= "<Currency><![CDATA[" . $row["strBankFacilityCurrency"]  . "]]></Currency>\n";		
	}
	
	$XMLString .= "</BankData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}
else if ($request == "checkdb")
{	
	$bankCode = $_GET["bankCode"];
	$bankname = $_GET["bankname"];
	$XMLString = "<Data>";
	$XMLString .= "<BankData>";
	
$sql = "SELECT strBankCode FROM bank WHERE strBankCode = '$bankCode'";
//echo $sql;

	$result = $db->RunQuery($sql);
	$rows = mysql_num_rows($result);
	
	if($rows > 0)
		$XMLString .= "<Result><![CDATA[True]]></Result>\n";
	else
		$XMLString .= "<Result><![CDATA[False]]></Result>\n";
	
	$XMLString .= "</BankData>";
	$XMLString .= "</Data>";
	echo $XMLString;
}




?>