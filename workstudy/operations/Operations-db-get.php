<?php
include "../../Connector.php";

$request=$_GET['type'];
if($request=="loadOperationsDetails");
{
    header('Content-Type: text/xml'); 
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    $operationId=$_GET['operationId'];

        $ResponseXML="<XMLoperationstype>";
		$SQL="SELECT ws_operations.strOpCode,strOperation,ws_operations.intMachineType,ws_operations.intStatus,ws_operations.dblSMV,ws_operations.dblTMU,ws_operations.intComponent,ws_operations.intMachineTypeId, ws_machinetypes.intMachineId,  components.intCategory
			  FROM ws_operations 
			  inner join components on  ws_operations.intComponent=components.intComponentId
			  inner join ws_machinetypes on ws_operations.intMachineTypeId=ws_machinetypes.intMachineTypeId  
			  WHERE intOpID='".$operationId."'";
			
			$result = $db->RunQuery($SQL);	
			while($row = mysql_fetch_array($result))
				{
					$ResponseXML .="<OperationCode><![CDATA[" . $row["strOpCode"]  . "]]></OperationCode>\n";
					$ResponseXML .="<category><![CDATA[" . $row["intCategory"]  . "]]></category>\n";
					$ResponseXML .="<Component><![CDATA[" . $row["intComponent"]  . "]]></Component>\n";
					$ResponseXML .="<Operation><![CDATA[" . $row["strOperation"]  . "]]></Operation>\n";
					$ResponseXML .="<OperationMode><![CDATA[" . $row["intMachineType"]  . "]]></OperationMode>\n";
					$ResponseXML .="<MachineTypeID><![CDATA[" . $row["intMachineTypeId"]  . "]]></MachineTypeID>\n";
					$ResponseXML .="<Machine><![CDATA[" . $row["intMachineId"]  . "]]></Machine>\n";
					$ResponseXML .="<SMV><![CDATA[" . $row["dblSMV"]  . "]]></SMV>\n";
					$ResponseXML .="<TMU><![CDATA[" . $row["dblTMU"]  . "]]></TMU>\n";
					$ResponseXML .="<Status><![CDATA[" . $row["intStatus"]  . "]]></Status>\n";
				}
		$ResponseXML .="</XMLoperationstype>"; 
		echo $ResponseXML;
} 


?>

