<?php
session_start();

include "../../Connector.php";



$request = $_GET["request"];
header('Content-Type: text/xml'); 


if ($request == "getdata")
//die(mysql_error());	
{ 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$CustomerID = $_GET["buyer"];
	$XMLString= "<Data>";
	$XMLString .= "<Buyer>";
	
	$sql="SELECT intMainBuyerId,strBuyerId,strBuyerCode, strName, strAddress1, strAddress2,strAddress3, strCountry, strPhone, strEMail, strFax,strRemarks,strTINNo,strContactPerson  FROM buyers 
	WHERE strBuyerId = '$CustomerID'";

	$result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<MainBuyerId><![CDATA[" . $row["intMainBuyerId"]  . "]]></MainBuyerId>\n";
		$XMLString .= "<BuyerId><![CDATA[" . $row["strBuyerCode"]  . "]]></BuyerId>\n";
		$XMLString .= "<BuyerName><![CDATA[" . $row["strName"]  . "]]></BuyerName>\n";
		$XMLString .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		$XMLString .= "<Address2><![CDATA[" . $row["strAddress2"]  . "]]></Address2>\n";
		$XMLString .= "<Address3><![CDATA[" . $row["strAddress3"]  . "]]></Address3>\n";
		$XMLString .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";
		$XMLString .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		$XMLString .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		$XMLString .= "<Email><![CDATA[" . $row["strEMail"]  . "]]></Email>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<TINO><![CDATA[" . $row["strTINNo"]  . "]]></TINO>\n";
		$XMLString .= "<Cp><![CDATA[" . $row["strContactPerson"]  . "]]></Cp>\n";
		
		
		//$XMLString .= ""
		
	}
	
	$XMLString .= "</Buyer>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

else if ($request == "checkdb")
{	
	$buyername=$_GET["buyername"];
	$buyerID=$_GET["buyerid"];
	$BuyerCode=$_GET["BuyerCode"];

	if($buyerID)
	{
		$sql="SELECT strBuyerId  FROM buyers 
		WHERE strBuyerId != '$buyerID' AND strName='$buyername' AND strBuyerCode='$BuyerCode' and intDel=0";

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
		$sql="SELECT strBuyerId  FROM buyers 
			WHERE strName='$buyername' AND strBuyerCode='$BuyerCode' and intDel=0";
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


?>