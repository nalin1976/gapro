<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Country>";
//$db =new DBManager();

$RequestType = $_GET["CountryID"];

//$RequestType =$_POST["txtbankcode"];

	$SQL="SELECT * FROM country where strCountryCode='".$RequestType."';";

	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<CountryCode><![CDATA[" . $row["strCountryCode"]  . "]]></CountryCode>\n";
        $ResponseXML .= "<CountryName><![CDATA[" . $row["strCountry"]  . "]]></CountryName>\n";
	 
	}	
	 $ResponseXML .= "</Country>";
	 echo $ResponseXML;

?>