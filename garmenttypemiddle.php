<?php

include "../../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLGarmenttype>";

$garmenttypeCode =$_GET["GarmenttypeCode"];

	$SQL="SELECT intGamtID,strGarmentName,strGamtDesc,intStatus FROM was_garmenttype where intGamtID='".$garmenttypeCode."';";		
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<Descrtiption><![CDATA[" . $row["strGamtDesc"]  . "]]></Descrtiption>\n";
        $ResponseXML .= "<GarmentName><![CDATA[" . $row["strGarmentName"]  . "]]></GarmentName>\n";
	    $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
	}	
	 $ResponseXML .= "</XMLGarmenttype>";
	 echo $ResponseXML;

?>
