<?php
	include "../../Connector.php";
	
	$strButton=$_GET["q"];
	$strBrandCode=$_GET["strBrandCode"];
	$id = $_GET["id"];
    //New & Save
    if($strButton=="New")
	{
	  
	
			
			$SQL_Check="SELECT strBrand,intStatus,intId FROM brand where strBrand='".$strBrandCode."';";
			$result_check = $db->RunQuery($SQL_Check);	
		
			if($row_check = mysql_fetch_array($result_check))
			{
				if($row_check["intStatus"]==0)
				{
					$SQL_Update="UPDATE brand SET intStatus=1 where intId=".$row_check["intId"]; 
				
					$db->ExecuteQuery($SQL_Update);
					echo "Saved SuccessFully";		
				}
				else
					echo "Record all ready Exsists.";
			}
			else
			{
			  
				$SQL="insert into brand (strBrand,intStatus) values('".$strBrandCode."',1)";
		  
		  		$db->ExecuteQuery($SQL);
		    	echo "Saved SuccessFully";
			  
			}
			
	}

	 	
	// Update
	if($strButton=="Save")
	{   
		
			
				$SQL_Update="UPDATE brand SET strBrand='".$strBrandCode."', intStatus=1 where intId=$id"; 
				
				$db->ExecuteQuery($SQL_Update);
				echo "Saved SuccessFully";			
				//echo $SQL_Update;
			
				
	}
	
	
		
		//Delete
		 
	if($strButton=="Delete" && $id !=null)
	{		
	 $SQL="update brand set intStatus=0  where intId=$id";
	 
	 $db->ExecuteQuery($SQL);
	
	 echo "Deleted SuccessFully.";
	 }
	
		


?>





