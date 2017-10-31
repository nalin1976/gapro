
<?php
	include "../../../Connector.php";
	
	    $strButton=trim($_GET["q"],' ');
	
	//--------------------------------------------------------------------------------------------
	
	if($strButton=="New")
	{	
		$strDes=trim($_GET["strDes"],' ');
	    $strMachType=$_GET["strMachType"];
		$intStatus=$_GET["intStatus"];
		$intmachineCapacity=$_GET['intmachineCapacity'];
		
		  $sql_insert  = "INSERT INTO was_machine (strMachineName,intMachineType,intStatus,intCapacity) values
						 ('$strDes','$strMachType','$intStatus','$intmachineCapacity')";
		  $db->ExecuteQuery($sql_insert);		
		  echo "Saved successfully";	
	
		
	}

//---------------------------------------------------------------------------------------------------
	// Update
	else if($strButton=="Save")
	{  
	    $strMachID=$_GET["strMachID"];
		$strDes=trim($_GET["strDes"],' ');
	    $strMachType=$_GET["strMachType"];
		$intStatus=$_GET["intStatus"];
		$intmachineCapacity=$_GET['intmachineCapacity'];
	 
         $SQL_Check1="SELECT * FROM was_machine where strMachineName='$strDes' AND intStatus != '10'";
	     $result_check1 = $db->RunQuery($SQL_Check1);	
	
	     $SQL ="SELECT * FROM was_machine where intMachineId='$strMachID' AND intStatus != '10'";
	     $result_check1 = $db->RunQuery($SQL_Check1);	
	     $result = $db->RunQuery($SQL);
	     $row = mysql_fetch_array($result);
		 
	 $SQL_Update="UPDATE was_machine SET  strMachineName='$strDes',
		                             intMachineType='$strMachType',
		                             intStatus='$intStatus',
									 intCapacity='$intmachineCapacity'
                 WHERE intMachineId='$strMachID'"; 
		//echo $SQL_Update;
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated successfully";			

		
  }
	
//--------------------------------------------------------------------------------------------------------	
		//Delete
			 
		else if($strButton=="Delete")
		{		
		
		$strMachID=$_GET["strMachID"];
		// $SQL="update seasons set intStatus='10' where intSeasonId='$strSeasonId';";
		$SQL = "delete from  was_machine  where intMachineId='$strMachID';";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted successfully.";
		 }
		 
else if($strButton=="LoadMachType")
{
	$SQL="SELECT was_machinetype.intMachineId,was_machinetype.strMachineType FROM was_machinetype WHERE was_machinetype.intStatus<>10 order by was_machinetype.intMachineId DESC";
	$result = $db->RunQuery($SQL);

	while($row = mysql_fetch_array($result))
	{
		echo "<option value=\"". $row["intMachineId"] ."\">" . $row["strMachineType"] ."</option>" ;
	}
}		 
?>