<?php
session_start();

include "../../Connector.php";



$request = $_GET["request"];
header('Content-Type: text/xml'); 




if ($request == "checkdb")
{	
	$floor=$_GET["FLOOR"];
	$ceiling=$_GET["CEILING"];
	$amoumt=$_GET["AMOUNT"];
	$serial=$_GET["SERIAL"];

	if($serial !='undefined')
	{	
		$sql="SELECT intSerialNo FROM 
	transportcharges WHERE intSerialNo!='$serial' AND dblCBMFloor='$floor' AND dblCBMCeiling='$ceiling' ";
		
		$result = $db->RunQuery($sql);
		if (mysql_num_rows($result)>0)
		{
			
			echo "cant"	;
		}
		else
		{
			echo $serial;
			
				
		}
	}
	
	else 
	{
		$sql="SELECT intSerialNo FROM 
	transportcharges WHERE dblCBMFloor='$floor' AND dblCBMCeiling='$ceiling' ";

		$result = $db->RunQuery($sql);
		
		if (mysql_num_rows($result)>0)
		{
			
	
		}
		else
		{
			echo "insert";
		}
		
		
	}
	
}


?>