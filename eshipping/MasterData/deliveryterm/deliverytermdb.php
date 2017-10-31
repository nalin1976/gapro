<?php 

session_start();
include "../../Connector.php";

	$request		= $_GET["request"];
	$deliverycode	= $_GET["deliverycode"];
	$deliveryname	= $_GET["deliveryname"];
	$SearchID 		= $_GET["SearchID"];
	
	if ($request=="update")
	{

		$sqlupdate="UPDATE deliveryterms 
					SET strDeliveryName = '$deliveryname',
					strDeliveryCode	= '$deliverycode'
					where intDeliveryID = '$SearchID '";
					
			
		$result = $db->RunQuery($sqlupdate);
	
	
		if ($result)
		{		
			echo "Successfully updated."; 		
		}
		
	}

	if($request=="insert")
	{
		
		$deliverycode	= $_GET["deliverycode"];
		$deliveryname	= $_GET["deliveryname"];

		$sqlinsert="INSERT INTO deliveryterms 
					(strDeliveryCode, 
					strDeliveryName)
					VALUES
					('$deliverycode', 
					'$deliveryname');";

	$result = $db->RunQuery($sqlinsert);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}
		
	}


elseif($request=="deletedata")
{	
	
	$dccode=$_GET['SearchID'];
	
	$sqldelete="DELETE FROM deliveryterms WHERE intDeliveryID='$dccode'";
	$result_delete = $db->RunQuery($sqldelete);
	
	if ($result_delete)
		{
			echo "Successfully deleted.";
		}
}





?>