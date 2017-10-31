<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Seasons>";


$RequestType = $_GET["Seasonload"];


	$SQL="SELECT * FROM seasons where intSeasonId='".$RequestType."' order by strSeason";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        // $ResponseXML .= "<SeasonId><![CDATA[" . $row["strSeasonId"]  . "]]></SeasonId>\n";
         $ResponseXML .= "<SeasonCode><![CDATA[" . $row["strSeasonCode"]  . "]]></SeasonCode>\n";
		 $ResponseXML .= "<SeasonName><![CDATA[" . $row["strSeason"]  . "]]></SeasonName>\n";
		 $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		
	}
	 $ResponseXML .= "</Seasons>";
	 echo $ResponseXML;

?>
