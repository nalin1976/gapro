<?php 

	session_start();
include "../../Connector.php";

	$request		= $_GET["request"];
	$packagecode	= $_GET["packagecode"];
	$packagename	= $_GET["packagename"];
	$SearchID 		= $_GET["SearchID"];

if ($request=="update")
	{

		$sqlupdate="UPDATE packagetypes 
					SET strPackageName = '$packagename',
					strPackageCode	= '$packagecode'
					where intPackageID = '$SearchID '";
					
			
		$result = $db->RunQuery($sqlupdate);
		
		
		if ($result)
		{		
			echo "Successfully updated."; 		
		}
		
	}
	

if($request=="insert")
	{
		
		$packagecode	= $_GET["packagecode"];
		$packagename	= $_GET["packagename"];

		$sqlinsert="INSERT INTO packagetypes 
					(strPackageCode, 
					strPackageName)
					VALUES
					('$packagecode', 
					'$packagename');";

	$result = $db->RunQuery($sqlinsert);
		if ($result)
		{
			echo "Successfully saved."; 	
				
		}
		
	}


elseif ($request=="delete")
{
$Ptype=	 $_GET["ID"];
$sql = "DELETE FROM packagetypes 
	where
	intPackageID = '$Ptype'";

	$result = $db->RunQuery($sql)or die ("error");
		if ($result)
		{
			echo "Successfully deleted."; 	
		}

}



?>