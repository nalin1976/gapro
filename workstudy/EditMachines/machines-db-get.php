<?php

include "../../Connector.php";


$request=$_GET['type'];


// commented by suMitH HarShan . This script not use now***************************************************
if($request=="loadMachineDetails")
{
	header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	
	$machineId=$_GET['machineId'];
	
	$ResponseXML="<XMLmachines>";
	 $SQL="SELECT ws_machines.intMacineID, ws_machines.strName FROM ws_machines WHERE
ws_machines.intMacineID ='$machineId'";
	
	$result = $db->RunQuery($SQL);	
	while($row = mysql_fetch_array($result))
		{
		$ResponseXML .="<machinID><![CDATA[".$row["intMacineID"]."]]></machinID>\n";
	    $ResponseXML .="<machineName><![CDATA[".$row["strName"]."]]></machineName>\n";
	  	}
$ResponseXML .="</XMLmachines>"; 
echo $ResponseXML;
} 



//suMitH HarShan 2011-04-29**********************************************************************
//load machine details grid 
if($request=="loadGrid")
{
$ResponseXML ="";
		 $ResponseXML .= "<table style=\"width:500px\" id=\"tblmachinegrid\" class=\"thetable\" border=\"1\" cellspacing=\"1\">
        						<caption>Machine Details</caption>
					<thead>
                    <tr>
								<th width=\"53\">Edit</th>
								<th width=\"56\">Del</th>
								<th width=\"74\">ID</th>
								<th width=\"294\">Name</th>
						  </tr>
                    </thead>			 		
		    <tbody>";
				
	$SQL2="SELECT intMacineID ,strName FROM ws_machines ORDER BY strName ASC";		
			$result2 = $db->RunQuery($SQL2);	 
			$i=1;
			
			while($row2 = mysql_fetch_array($result2))
			{	
			//create dynamically machine details grid
			
			 $ResponseXML.="<tr id=\"".$row2["intMacineID"]."\" onclick=\"rowclickColorChangetbl(this)\">
					<td><img src=\"../../images/edit.png\" name=\"butEdit\" class=\"mouseover\" id=\"butEdit\" onClick=\"editRowMachine('".$row2["intMacineID"]."','".$row2["strName"]."');\"/></td>
					<td><img src=\"../../images/deletered.png\" name=\"butDel\" width=\"12\" class=\"mouseover\" id=\"butDel\" onClick=\"deleteRowMachine('".$row2["intMacineID"]."');\"/></td>
					<td style=\"padding-left:20px;\">".$i."</td>
					<td style=\"padding-left:20px;\">".$row2["strName"]."</td>
					</tr>"; 
   $i++;
	 
			}	//end of the while loop
			
					 
	$ResponseXML .= "</tbody></table>";
	echo $ResponseXML;
	
}

?>
