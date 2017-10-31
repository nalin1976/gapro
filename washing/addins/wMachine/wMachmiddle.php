<?php

include "../../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$ResponseXML .= "<wMachload>";


$RequestType = $_GET["wMachload"];


	$SQL="SELECT was_machine.intMachineId,was_machine.strMachineName,was_machine.intMachineType,was_machinetype.strMachineType,
	      was_machine.intStatus,was_machine.intCapacity 
	      FROM was_machine INNER JOIN was_machinetype ON was_machine.intMachineType=was_machinetype.intMachineId         	
	      where was_machine.intMachineId='".$RequestType."' order by was_machine.strMachineName";
	//echo $SQL;
	$result = $db->RunQuery($SQL);
	
	while($row = mysql_fetch_array($result))
	{
		 $ResponseXML .= "<strMachineName><![CDATA[" . $row["strMachineName"]  . "]]></strMachineName>\n";
		 $ResponseXML .= "<intMachineType><![CDATA[" . $row["intMachineType"]  . "]]></intMachineType>\n";
		 $ResponseXML .= "<strMachineType><![CDATA[" . $row["strMachineType"]  . "]]></strMachineType>\n";
		 $ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
		 $ResponseXML .= "<Capacity><![CDATA[" . $row["intCapacity"]  . "]]></Capacity>\n";
		
	}
	 $ResponseXML .= "</wMachload>";
	 echo $ResponseXML;

?>
