<?php

include "../../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML = "<XMLOperators>";

$operatorCode = $_GET["OperatorCode"];

	$SQL="SELECT intMachineId,strShift,strName,strRemarks,intStatus,intSection,strEpfNo FROM was_operators where intOperatorID='".$operatorCode."';";	
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
        $ResponseXML .= "<MachineName><![CDATA[" . $row["intMachineId"]  . "]]></MachineName>\n";
        $ResponseXML .= "<Shift><![CDATA[" . $row["strShift"]  . "]]></Shift>\n";
		$ResponseXML .= "<Name><![CDATA[" . $row["strName"]  . "]]></Name>\n";
	    $ResponseXML .= "<Remarks><![CDATA[" . $row["strRemarks"]  . "]]></Remarks>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		$ResponseXML .= "<Section><![CDATA[" . $row["intSection"]  . "]]></Section>\n";
		$ResponseXML .= "<EpfNo><![CDATA[" . $row["strEpfNo"]  . "]]></EpfNo>\n";
	}	
	 $ResponseXML .= "</XMLOperators>";
	 echo $ResponseXML;

?>
