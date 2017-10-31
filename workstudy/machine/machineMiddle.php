<?php

include "../../Connector.php";

header('Content-Type: text/xml'); 
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";

$command = $_GET["q"];

if($command =="machines"){

	$ResponseXML .= "<Machines>";
	//$db =new DBManager();
	
	$RequestType = $_GET["machineID"];
	//$RequestType =$_POST["txtbankcode"];
	
	$SQL="SELECT * FROM ws_machinetypes where intMachineTypeId='$RequestType' order by strMachineName asc";
	
		
		$result = $db->RunQuery($SQL);
		
		while($row = mysql_fetch_array($result))
		{
		$ResponseXML .= "<Code><![CDATA[" . $row["strMachineCode"]  . "]]></Code>\n";
		$ResponseXML .= "<Name><![CDATA[" . $row["strMachineName"]  . "]]></Name>\n";
		$ResponseXML .= "<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n"; 
		 
		}	
		 $ResponseXML .= "</Machines>";
		 echo $ResponseXML;
}

?>