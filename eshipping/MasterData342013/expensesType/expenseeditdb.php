<?php 
session_start();
include("../../Connector.php");	
	
	$request=$_GET['REQUEST'];
	$desc=$_GET['DESC'];
	$type=$_GET['TYPE'];
	$id=$_GET['ID'];

if($request=="insert") 
	{		
		
	$sql = "INSERT INTO expensestype 
	(strDescription,strExpencesType) VALUES ('$desc','$type');";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE expensestype SET strDescription = '$desc' , 
	strExpencesType = '$type'; ";
	
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{		
			echo "Successfully updated."; 		
		}

}
if ($request=="delete")
{
$sql = "DELETE FROM expensestype 
	WHERE
	intExpensesID = '$id' ;";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}
	


?>