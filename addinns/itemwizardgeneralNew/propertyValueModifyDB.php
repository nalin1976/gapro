<?php
	session_start();
	include"../../Connector.php";

 	$strButton=$_GET["q"];
	
	if($strButton=="Save")
	{ 
		$intSubPropertyNo=$_GET["intSubPropertyNo"];		
		$strSubPropertyName=$_GET["strSubPropertyName"];	
		
		$sql1="SELECT count(intSubPropertyNo) as num FROM matpropertyvalues WHERE strSubPropertyName='".$strSubPropertyName."';";		
		$result1=$db->RunQuery($sql1);	
		$message="";
		
		if($row1 = mysql_fetch_array($result1))
		{
			if($row1["num"]>0)
				$message = "Property Value is already exist";
			
			else{
		
				$sql="update matpropertyvalues set strSubPropertyName = '$strSubPropertyName' , dtmDate = now() where intSubPropertyNo = '$intSubPropertyNo' ;";		
				$result=$db->RunQuery($sql);	
				if($result==1)
					$message = "Property Value modified successfully";		
				else
					$message = "Unable to modify";		
			}
		}		
		echo $message;	
	}
	
	elseif($strButton=="Delete")
	{ 
		$intSubPropertyNo=$_GET["intSubPropertyNo"];
			
		$sql="delete from matpropertyvalues where intSubPropertyNo = '$intSubPropertyNo';";
							
		$result=$db->RunQuery($sql);	
		if($result==1)
			$message = "Property Value deleted successfully";		
		else
			$message = "Unable to delete";			
			
		echo $message;
	}
	

?>
