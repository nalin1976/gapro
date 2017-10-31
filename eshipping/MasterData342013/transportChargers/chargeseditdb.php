<?php 
session_start();
include("../../Connector.php");	
	
	$request=$_GET['REQUEST'];
	$floor=$_GET["FLOOR"];
	$ceiling=$_GET["CEILING"];
	$amoumt=$_GET["AMOUNT"];
	$serial=$_GET["SERIAL"];


if($request=="insert") 
	{		
		
	$sql = "INSERT INTO transportcharges 
	(dblCBMFloor, dblCBMCeiling, dblAmount ) VALUES	('$floor', '$ceiling', '$amoumt')";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE transportcharges SET	dblCBMFloor = '$floor' , dblCBMCeiling = '$ceiling' , 	dblAmount = '$amoumt' 
		WHERE intSerialNo = '$serial'  ";
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{		
			echo "Successfully updated."; 		
		}

}
if ($request=="delete")
{
$sql = "DELETE FROM transportcharges 
	WHERE	intSerialNo =  '$serial' ;";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>