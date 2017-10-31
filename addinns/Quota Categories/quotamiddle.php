<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Quota>";

$RequestType = $_GET["QuotaID"];

	$SQL="SELECT * FROM quotacategories where strCategoryID='".$RequestType."';";

	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<CategoryID><![CDATA[" . $row["strCategoryID"]  . "]]></CategoryID>\n";
        $ResponseXML .= "<Description><![CDATA[" . $row["strDescription"]  . "]]></Description>\n";
	    $ResponseXML .= "<Unit><![CDATA[" . $row["strUnit"]  . "]]></Unit>\n";
		$ResponseXML .= "<Price><![CDATA[" . $row["dblPrice"]  . "]]></Price>\n";
	}	
	 $ResponseXML .= "</Quota>";
	 echo $ResponseXML;

?>

