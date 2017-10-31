<?php

session_start();

include "../../Connector.php";
$request = $_GET["request"];
$code=$_GET["city"];
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$XMLString .= "<Data>";
	$XMLString .= "<CityData>";

if ($request == "getdata")
{
	
	
	$sql="SELECT  strCityCode, strCity,strPortOfLoading 
FROM city WHERE strCountryCode='$code';";

	$result = $db->RunQuery($sql);
	
		while($row = mysql_fetch_array($result))
	{
		$XMLString .= "<CityCode><![CDATA[" . $row["strCityCode"]  . "]]></CityCode>";
		$XMLString .= "<City><![CDATA[" . $row["strCity"]  . "]]></City>\n";
		$XMLString .= "<Loading><![CDATA[" . $row["strPortOfLoading"]  . "]]></Loading>\n";
		
		
	}


}



	else if ($request == "viewdata")
	{
	$sql="SELECT  strCityCode, strCity,strPortOfLoading ,strDC ,strtoLocation,strDestination
	FROM city WHERE strCityCode='$code';";
	$result = $db->RunQuery($sql);
	   
	while($row = mysql_fetch_array($result))
			{		
                         $XMLString .= "<City><![CDATA[" . $row["strCity"]  . "]]></City>";
			$XMLString .= "<Port><![CDATA[" . $row["strPortOfLoading"]  . "]]></Port>\n";
			$XMLString .= "<DC><![CDATA[" . $row["strDC"]  . "]]></DC>\n";
			$XMLString .= "<ISD><![CDATA[" . $row["strtoLocation"]  . "]]></ISD>\n";
			$XMLString .= "<DES><![CDATA[" . $row["strDestination"]  . "]]></DES>\n";	
			}
	}
	$XMLString .= "</CityData>";
	$XMLString .= "</Data>";
	echo $XMLString;

?>