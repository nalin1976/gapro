
<?php
	include "../../Connector.php";
	

	$strButton=$_GET["q"];
	$cboMachineList=trim($_GET["cboMachineList"],' ');
	$cboMachineCode=trim($_GET["cboMachineCode"],' ');
	$strMachine=trim($_GET["strMachine"],' ');
	$intStatus=trim($_GET["intStatus"],' ');
	
if($strButton=="New")
{
  $sql_insert  = "INSERT INTO ws_machinetypes (strMachineCode,strMachineName,intStatus)
				  VALUES
				 ('$cboMachineCode','$strMachine',$intStatus)";
  $db->ExecuteQuery($sql_insert);		
  echo "Saved successfully.";		  
  
}

else if($strButton=="Save")
{ 
  $SQL_Update="UPDATE ws_machinetypes SET 
					strMachineCode = '$cboMachineCode',
					strMachineName = '$strMachine',
					intStatus      = '$intStatus'
			     WHERE intMachineTypeId='$cboMachineList'"; 
  $db->ExecuteQuery($SQL_Update);	
  	
  echo " Updated successfully.";			
}	

else if($strButton=="Delete")
{	
 $cboMachineList = $_GET["cboMachineList"]; 	
 $SQL="DELETE FROM ws_machinetypes  where intMachineTypeId='$cboMachineList'";
// echo $SQL;
 $result = $db->RunQuery2($SQL);
 if(gettype($result)=='string')
 {
	echo $result;
	return;
 }

 echo "Deleted successfully.";
}	
	 
else if($strButton =="machines")
{
	$SQL = "SELECT ws_machinetypes.intMachineTypeId, ws_machinetypes.strMachineName FROM ws_machinetypes  order by strMachineName asc;";	
	$result = $db->RunQuery($SQL);
		echo "<option value=\"". "" ."\">" . "" ."</option>" ;
	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intMachineTypeId"] ."\">" . $row["strMachineName"] ."</option>" ;
	}
}
?>