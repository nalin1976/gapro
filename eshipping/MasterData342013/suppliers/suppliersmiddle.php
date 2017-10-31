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
	
	$sql="SELECT strSupplierId, strName,strCity, strAddress1, strAddress2, strCountry, strPhone, strEMail, strFax,strRemarks,strTINNo  FROM suppliers 
	WHERE strSupplierId = '$CustomerID'";

	$result = $db->RunQuery($sql);
	
	while($row = mysql_fetch_array($result))
	{ 
		$row["strAddress1"]=str_replace("''","'",$row["strAddress1"]);
		$row["strAddress2"]=str_replace("''","'",$row["strAddress2"]);
		$row["strName"]=str_replace("''","'",$row["strName"]);
		$XMLString .= "<BuyerId><![CDATA[" . $row["strSupplierId"]  . "]]></BuyerId>\n";
		$XMLString .= "<BuyerName><![CDATA[" . $row["strName"]  . "]]></BuyerName>\n";
		$XMLString .= "<Address1><![CDATA[" . $row["strAddress1"]  . "]]></Address1>\n";
		$XMLString .= "<Address2><![CDATA[" . $row["strAddress2"]  . "]]></Address2>\n";
		$XMLString .= "<Country><![CDATA[" . $row["strCountry"]  . "]]></Country>\n";
		$XMLString .= "<Phone><![CDATA[" . $row["strPhone"]  . "]]></Phone>\n";
		$XMLString .= "<Fax><![CDATA[" . $row["strFax"]  . "]]></Fax>\n";
		$XMLString .= "<Email><![CDATA[" . $row["strEMail"]  . "]]></Email>\n";
		$XMLString .= "<City><![CDATA[" . $row["strCity"]  . "]]></City>\n";
		$XMLString .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$XMLString .= "<TINO><![CDATA[" . $row["strTINNo"]  . "]]></TINO>\n";
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

	if($buyerID)
	{
		$sql="SELECT strBuyerId  FROM Buyers 
		WHERE strBuyerId != '$buyerID' AND strName='$buyername'";

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
		$sql="SELECT strBuyerId  FROM Buyers 
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

else if ($request == "city")
{
   $countrycode=$_GET["COUNTRY"];

	        $sql="SELECT 	strCity,strCityCode FROM city WHERE strCountryCode='$countrycode'";
                $XMLString="<data>";
		$result = $db->RunQuery($sql);

      // $XMLString .= "<City>-Please Select-</City>\n";
       //$XMLString .= "<CityCode>hq</CityCode>\n";
	while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<CityCode><![CDATA[" . $row["strCityCode"]  . "]]></CityCode>";
		$XMLString .= "<City><![CDATA[" . $row["strCity"]  . "]]></City>\n";



	}

        $XMLString .="</data>";
        echo  $XMLString;

}

?>