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
	
	$sql="SELECT intForwaderID, strName, strAddress1, strAddress2,dblDOCharges ,strCountry, strPhone, strEMail, strFax,strRemarks FROM forwaders
	WHERE intForwaderID='$CustomerID' ;";

	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{ 
		$XMLString .= "<ForwaderId><![CDATA[" . $row["intForwaderId"]  . "]]></ForwaderId>\n";
		$XMLString .= "<Forwader><![CDATA[" . $row["strName"]  . "]]></Forwader>\n";
		$XMLString .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		$XMLString .= "<Address2><![CDATA[" . $row["strAddress2"]  . "]]></Address2>\n";
		$XMLString .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";
		$XMLString .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		$XMLString .= "<Charg><![CDATA[" . $row["dblDOCharges"]  . "]]></Charg>\n";
		$XMLString .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		$XMLString .= "<Email><![CDATA[" . $row["strEMail"]  . "]]></Email>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		
		
		
	}
	
	$XMLString .= "</Buyer>";
	$XMLString .= "</Data>";
	echo $XMLString;

}

else if ($request == "checkdb")
{	
	$buyername=$_GET["buyername"];
	$buyerID=$_GET["buyerid"];

	if($buyerID)
	{
		$sql="SELECT intForwaderID  FROM forwaders
		WHERE intForwaderID != '$buyerID' AND strName='$buyername'";

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
		$sql="SELECT intForwaderID  FROM forwaders
			WHERE strName='$buyername'";
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