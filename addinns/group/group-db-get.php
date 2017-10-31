<?php
include "../../Connector.php";


$request=$_GET['type'];

 // Edit by suMitH HarShan 2011-04-29
 
// ***********************************Load selected machine detals to the grid ****************************************
if($request=="loadMachineDetails")
{
	/*header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";*/
	
	$machineId=$_GET['machineId'];
	$tableMachine="<table style=\"width:500px\" id=\"tblmachinegrid\" class=\"thetable\" border=\"1\" cellspacing=\"1\">
        						<caption>Machine Details</caption>
					<thead>
                    <tr>
								<th width=\"26\">Edit</th>
								<th width=\"34\">Del</th>
								<th width=\"121\">Type</th>
								<th width=\"108\">Code</th>
								<th width=\"122\">Name</th>
                                <th width=\"43\">Active</th>
					</tr>
                    </thead>			 		
		    <tbody>";
	/*$ResponseXML="<XMLmachinestype>";*/
	 $SQL1="SELECT
				ws_machinetypes.intMachineTypeId,
				ws_machinetypes.strMachineCode,
				ws_machinetypes.strMachineName,
				ws_machinetypes.intMachineId,
				ws_machinetypes.intStatus,
				ws_machinetypes.intHelper,
				ws_machines.strName
				FROM
				ws_machinetypes
				INNER JOIN ws_machines ON ws_machines.intMacineID = ws_machinetypes.intMachineId
				WHERE
				ws_machines.intMacineID = '$machineId'";
	
	$result1 = $db->RunQuery($SQL1);	
	while($row1 = mysql_fetch_array($result1))
		{
		/*$ResponseXML .="<MachineCode><![CDATA[".$row["strMachineCode"]."]]></MachineCode>\n";
	    $ResponseXML .="<Machine><![CDATA[".$row["strMachineName"]."]]></Machine>\n";
	    $ResponseXML .="<MachineID><![CDATA[".$row["intMachineId"]."]]></MachineID>\n";
        $ResponseXML .="<Status><![CDATA[".$row["intStatus"]."]]></Status>\n";
        $ResponseXML .="<intHelper><![CDATA[".$row["intHelper"]."]]></intHelper>\n";*/
		
		$tableMachine .="<tr id=\"".$row1["intMachineTypeId"]."\" onclick=\"rowclickColorChangetbl(this)\">
					<td><img src=\"../../images/edit.png\" name=\"butEdit\" class=\"mouseover\" id=\"butEdit\" onClick=\"editRowMachine('".$row1["intMachineTypeId"]."','".$row1["intMachineId"]."','".$row1["strMachineCode"]."','".$row1["intHelper"]."','".$row1["strMachineName"]."','".$row1["intStatus"]."');\"/></td>
					<td><img src=\"../../images/deletered.png\" name=\"butDel\" width=\"12\" class=\"mouseover\" id=\"butDel\" onClick=\"deleteRowMachine('".$row1["intMachineTypeId"]."');\"/></td>
					<td>".$row1["strName"]."</td>
					<td>".$row1["strMachineCode"]."</td>
					<td>".$row1["strMachineName"]."</td>
                    <td><input type=\"checkbox\"";
					if($row1["intStatus"]==1)
					{
					$tableMachine .="checked=\"checked\"";
					}
					$tableMachine .="disabled=\"disabled\" class=\"txtbox\" /></td>
				</tr>";

	  			}
/*$ResponseXML .="</XMLmachinestype>"; */
/*echo $ResponseXML;
*/
echo $tableMachine;
} 



//************************suMitH HarShan 2011-04-29***************************

//**************************Load all machine details grid when details was saved******************************************
if($request=="loadGrid")
{
$ResponseXML ="";
		 $ResponseXML .= "<table style=\"width:500px\" id=\"tblmachinegrid\" class=\"thetable\" border=\"1\" cellspacing=\"1\">
        						<caption>Machine Details</caption>
					<thead>
                    <tr>
								<th width=\"26\">Edit</th>
								<th width=\"34\">Del</th>
								<th width=\"121\">Type</th>
								<th width=\"108\">Code</th>
								<th width=\"122\">Name</th>
                                <th width=\"43\">Active</th>
					</tr>
                    </thead>			 		
		    <tbody>";
				
	$SQL2="SELECT
				ws_machines.intMacineID,
				ws_machines.strName,
				ws_machinetypes.strMachineCode,
				ws_machinetypes.strMachineName,
				ws_machinetypes.intHelper,
				ws_machinetypes.intMachineTypeId,
				ws_machinetypes.intStatus
				FROM ws_machines INNER JOIN ws_machinetypes ON ws_machinetypes.intMachineId = ws_machines.intMacineID
				ORDER BY ws_machines.strName ASC";		
			$result2 = $db->RunQuery($SQL2);	 
			//$i=0;
			
			while($row2 = mysql_fetch_array($result2))
			{	
			//create dynamically machine details grid
			
			 $ResponseXML.="<tr id=\"".$row2["intMachineTypeId"]."\" onclick=\"rowclickColorChangetbl(this)\">
					<td><img src=\"../../images/edit.png\" name=\"butEdit\" class=\"mouseover\" id=\"butEdit\" onClick=\"editRowMachine('".$row2["intMachineTypeId"]."','".$row2["intMacineID"]."','".$row2["strMachineCode"]."','".$row2["intHelper"]."','".$row2["strMachineName"]."','".$row2["intStatus"]."');\"/></td>
					<td><img src=\"../../images/deletered.png\" name=\"butDel\" width=\"12\" class=\"mouseover\" id=\"butDel\" onClick=\"deleteRowMachine('".$row2["intMachineTypeId"]."');\"/></td>
					<td>".$row2["strName"]."</td>
					<td>".$row2["strMachineCode"]."</td>
					<td>".$row2["strMachineName"]."</td>
                    <td>"; 
					
			if($row2["intStatus"]==1)
			{
				$ResponseXML .="<input type=\"checkbox\" checked=\"checked\" disabled=\"disabled\" class=\"txtbox\" /></td>";	
			} 
			
			else
			{
				$ResponseXML .="<input type=\"checkbox\" disabled=\"disabled\" class=\"txtbox\" /></td>";
			}					
				
				$ResponseXML .="</tr>";
	 
			}	//end of the while loop
			
					 
	$ResponseXML .= "</tbody></table>";
	echo $ResponseXML;
	
}

else if($request = "loadExUsersForGroups"){
 $groupID = $_GET["groupID"];
    header('Content-Type: text/xml'); 
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
 $ResponseXML ="";
		 $ResponseXML .= "<thead>
                    <tr>
							<th width=\"46\">Del</th>
							<th width=\"446\">Name</th>
					</tr>
                    </thead>			 		
		    <tbody>";
			
 $sql = "SELECT
			events_group.strGroupName,
			useraccounts.Name,
			useraccounts.intUserID
			FROM
			events_group
			Inner Join events_user_groups ON events_group.intGroupId = events_user_groups.intGroupId
			Inner Join useraccounts ON events_user_groups.intUserId = useraccounts.intUserID WHERE events_group.intGroupId='$groupID' order by useraccounts.Name";
 $result = $db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{	
	 			 $ResponseXML.="<tr>
					<td><img src=\"../../images/del.png\" name=\"butDel\" width=\"12\" class=\"mouseover\" id=\"butDel\" onClick=\"deleteRow();\"/></td>
					<td id=\"".$row["intUserID"]."\" align=\"left\">".$row["Name"]."</td>";


				$ResponseXML .="</tr>";
	}
	echo $ResponseXML;
}

?>
