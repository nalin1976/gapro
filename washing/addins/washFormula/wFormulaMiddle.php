<?php

include "../../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<Dry>";


$RequestType = $_GET["formulaload"];


	$SQL="SELECT * FROM was_washformula where intSerialNo='".$RequestType."'";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        // $ResponseXML .= "<SeasonId><![CDATA[" . $row["strSeasonId"]  . "]]></SeasonId>\n";
         $ResponseXML .= "<strProcessName><![CDATA[" . $row["strProcessName"]  . "]]></strProcessName>\n";
		 $ResponseXML .= "<dblTemp><![CDATA[" . $row["dblTemp"]  . "]]></dblTemp>\n";
		 $ResponseXML .= "<dblLiqour><![CDATA[" . $row["dblLiqour"]  . "]]></dblLiqour>\n";
		 $ResponseXML .= "<dblTime><![CDATA[" . $row["dblTime"]  . "]]></dblTime>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		 $ResponseXML .= "<ProcType><![CDATA[" . $row["intProcType"]  . "]]></ProcType>\n";
		
	}
	 $ResponseXML .= "</Dry>";
	 echo $ResponseXML;

?>
