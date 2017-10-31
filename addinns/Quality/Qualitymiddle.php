<?php

include "../../Connector.php";


$command =$_GET['requestType'];

if($command =="ShowQualityDetails")
{

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$cboQuality = $_GET["cboQuality"];

$ResponseXML .= "<Details>";

	$SQL="SELECT * FROM quality where intQualityId='".$cboQuality."' order by strQuality";
	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
         $ResponseXML .= "<QualityCode><![CDATA[" . $row["strQualityCode"]  . "]]></QualityCode>\n";
		 $ResponseXML .= "<Quality><![CDATA[" . $row["strQuality"]  . "]]></Quality>\n";
		 $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";		
	}
	 $ResponseXML .= "</Details>";
	 echo $ResponseXML;
}

?>
