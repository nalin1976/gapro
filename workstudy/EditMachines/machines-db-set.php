<?php


include('../../Connector.php');	

	$type=trim($_GET["type"]);
	
	 
if($type=="save")
{
	$cboSearchID   =trim($_GET["cboSearch"]);
	$txtMachineName=trim($_GET["txtMachineName"]);

	//************************************save **************************************

	if($cboSearchID=='')
	{
    		$sql_check="SELECT * FROM ws_machines WHERE strName='$txtMachineName' AND intMacineID='$cboSearchID'";
			$result_checked=$db->ExecuteQuery($sql_check);
			if(mysql_num_rows($result_checked))
			{
				echo "Already exist.";
			}
			else
			{
		
		$query1="INSERT INTO ws_machines (strName) VALUES ('$txtMachineName')";		
		$result1 = $db->ExecuteQuery($query1);
		if($result1)
		  echo  "Saved successfully."; 
		else
		   echo "Saved Failed.";
			}
	}
	
	//************************************update **************************************

	else
	{
		$query2="UPDATE ws_machines SET  strName='$txtMachineName' WHERE intMacineID ='$cboSearchID'"; 
		        $result2 = $db->ExecuteQuery($query2);
		if($result2)
		  echo  "Updated successfully."; 
		else
		   echo "Updated Failed."; 
	}

	
}

//************************************delete **************************************
else if($type=="delete")
{	
    $machineId=$_GET["machineId"];  
	$SQL="DELETE FROM ws_machines WHERE intMacineID='$machineId'";
	$db->ExecuteQuery($SQL);
	
	echo "Deleted successfully.";
 }
//--------------------------------------------------------------------

?>