<?php 
session_start();
include("../../Connector.php");	

	$request=$_GET["REQUEST"];
	$amount=	$_GET['Amount'];
	$cbmceiling=$_GET['CMBCeiling'];
	$cbmfloor=	$_GET['CMBFloor'];
	$serial=$_GET['SERIAL'];
	

if($request=="insert") 
	{		
		
	$sql = "INSERT INTO transportcharges ( intSerialNo,dblCBMFloor,dblCBMCeiling, dblAmount)
	VALUES ('$serial','$cbmfloor','$cbmceiling','$amount')";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}	
		
	
}
if ($request=="update")
{	

	$sql = "UPDATE transportcharges SET intSerialNo='$serial' ,dblCBMFloor='$cbmfloor', dblCBMCeiling='$cbmceiling', dblAmount='$amount' WHERE intSerialNo='$serial'";
	$result = $db->RunQuery($sql);
	
	
		if ($result)
		{		
			echo "Successfully updated."; 		
		}

}
if ($request=="delete")
{
$sql = "DELETE FROM  transportcharges WHERE intserialNo='$serial';";

	$result = $db->RunQuery($sql);
		if ($result)
		{
			echo "Successfully deleted."; 	
		}
		else
		{
			echo "There is no record.";		
		
		}

}
	


?>