<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	$strGenderCode=$_GET["strGenderCode"];
	$id = $_GET["id"];
    //New & Save
    if($strButton=="New")
	{
	  
	
			
			$SQL_Check="SELECT strGender,intStatus,intId FROM gender where strGender='".$strGenderCode."';";
			$result_check = $db->RunQuery($SQL_Check);	
		
			if($row_check = mysql_fetch_array($result_check))
			{
				if($row_check["intStatus"]==0)
				{
					$SQL_Update="UPDATE gender SET intStatus=1 where intId=".$row_check["intId"]; 
				
					$db->ExecuteQuery($SQL_Update);
					echo "Saved SuccessFully";		
				}
				else
					echo "Record all ready Exsists.";
			}
			else
			{
			  
				$SQL="insert into gender (strGender,intStatus) values('".$strGenderCode."',1)";
		  
		  		$db->ExecuteQuery($SQL);
		    	echo "Saved SuccessFully";
			  
			}
			
	}

	 	
	// Update
	if($strButton=="Save")
	{   
		
			
				$SQL_Update="UPDATE gender SET strGender='".$strGenderCode."', intStatus=1 where intId=$id"; 
				
				$db->ExecuteQuery($SQL_Update);
				echo "Saved SuccessFully";			
				//echo $SQL_Update;
			
				
	}
	
	
		
		//Delete
		 
	if($strButton=="Delete" && $id !=null)
	{		
	 $SQL="update gender set intStatus=0  where intId=$id";
	 
	 $db->ExecuteQuery($SQL);
	
	 echo "Deleted SuccessFully.";
	 }
	
		


?>





