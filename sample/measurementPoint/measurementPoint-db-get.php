<?php
session_start();
include "../../Connector.php";
$requestType=$_GET['requestType'];
	
	if($requestType=='saveData')
	{
		$id=$_GET['id'];
		$description=$_GET['description'];
		$status			  = $_GET["status"];
		
		$sql1="SELECT * FROM measurementpoint WHERE intId='$id'";
		$result1 = $db->RunQuery($sql1);
		
		if(mysql_num_rows($result1)==0)
		{
		$sql="INSERT INTO measurementpoint(intId,strDescription,intStatus)
			  VALUES('$id','$description',$status)";
			  
		$result = $db->RunQuery($sql);
			if($result)
					echo "Saved successfully.";
				else
					echo "Data saving error.";
		}
		else
		{
			$SQL_Update="UPDATE measurementpoint SET strDescription='$description',intStatus=$status WHERE intId='$id'";
	 		$db->ExecuteQuery($SQL_Update);		
  	    	echo "Updated successfully.";
		}
			
	}
	
	if($requestType=='delete')
	{
	
		$id=$_GET['id'];
		
		$sql="DELETE FROM measurementpoint
			  WHERE intId='$id'";
			  
		$result = $db->RunQuery($sql);
		
		echo "Deleted successfully.";
		
	}
	
?>
