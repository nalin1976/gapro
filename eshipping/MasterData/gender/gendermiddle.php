<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Gender>";
//$db =new DBManager();

$RequestType = $_GET["GenderID"];

//$RequestType =$_POST["txtbankcode"];

	$SQL="SELECT * FROM gender where intId='".$RequestType."';";

	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<GenderName><![CDATA[" . $row["strGender"]  . "]]></GenderName>\n";
	 
	}	
	 $ResponseXML .= "</Gender>";
	 echo $ResponseXML;

?>