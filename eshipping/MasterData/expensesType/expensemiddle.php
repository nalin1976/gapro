<?php
session_start();

include "../../Connector.php";



$request = $_GET["request"];
header('Content-Type: text/xml'); 




if ($request == "checkdb")
{	
	$desc=$_GET["DESC"];
	$type=$_GET["TYPE"];
	$id=$_GET["ID"];

	if($id !='undefined')
	{	
		$sql="SELECT intExpensesID, strDescription, strExpencesType FROM expensestype
		WHERE intExpensesID!='$id' AND  strDescription='$desc' AND strExpencesType='$type'";

		$result = $db->RunQuery($sql);
		if (mysql_num_rows($result)>0)
		{
			
			echo "cant"	;
		}
		else
		{
			echo "update";
		//	echo $id;
			
				
		}
	}
	
	else 
	{
		$sql="SELECT intExpensesID, strDescription, strExpencesType FROM expensestype
		WHERE strDescription='$desc' AND strExpencesType='$type'";
		$result = $db->RunQuery($sql);
		if (mysql_num_rows($result)>0)
		{
			echo "cant";	
	
		}
		else
		{
			echo "insert";
		}
		
		
	}
	
}


?>