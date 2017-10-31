<?php
session_start();
include"../../Connector.php";
$strButton=$_GET["q"];
	
if($strButton=="Save")
{ 
$intPropertyId	 = $_GET["intPropertyId"];		
$strPropertyName = $_GET["strPropertyName"];	
	
	$sql1="SELECT count(intPropertyId) as num FROM genmatproperties WHERE strPropertyName='".$strPropertyName."';";		
	$result1=$db->RunQuery($sql1);	
	$message="";
	
	if($row1 = mysql_fetch_array($result1))
	{
		if($row1["num"]>0)
			$message = "Property is already exist";		
		else{	
			$sql="update genmatproperties set strPropertyName = '$strPropertyName' , dtmDate = now() where intPropertyId = '$intPropertyId' ;";		
			$result=$db->RunQuery($sql);	
			
			if($result==1)
				$message = "Property modified successfully";		
			else
				$message = "Unable to modify";		
		}
	}		
	echo $message;	
}
elseif($strButton=="Delete")
{ 
	$intPropertyId=$_GET["intPropertyId"];
		
	$sql="delete from genmatproperties where intPropertyId = '$intPropertyId';";						
	$result=$db->RunQuery($sql);	
	if($result==1)
		$message = "Property deleted successfully";		
	else
		$message = "Unable to delete";			
		
	echo $message;
}
?>
