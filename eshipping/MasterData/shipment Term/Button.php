<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>eShipping Web | Shipment Term</title>
</head>

<body>
<?php
	include "../../connector.php";
	
	$strButton=$_GET["q"];
	$strShipmentTermId=$_GET["strShipmentTermId"];
	 	
	//Save & Update
	if($strButton=="Save" & $strShipmentTermId != null)
	{    $strShipmentTerm=$_GET["strShipmentTerm"];
		
		
	$SQL_CheckData="SELECT strShipmentTermId FROM shipmentterms where strShipmentTermId='".$strShipmentTermId."';";
	$result = $db->RunQuery($SQL_CheckData);	

	if($row = mysql_fetch_array($result))	
	{
		$SQL_Update="UPDATE shipmentterms SET strShipmentTerm='".$strShipmentTerm."',intStatus=1 where strShipmentTermId='".$strShipmentTermId."';"; 
		
	    $db->ExecuteQuery($SQL_Update);
		echo "Updated SuccessFully";			
		//echo $SQL_Update;
	}
	elseif
	{
			
$SQL = "insert into shipmentterms ( strShipmentTermId,strShipmentTerm) values ('".$strShipmentTermId."','".$strShipmentTerm."');";

			$db->ExecuteQuery($SQL);
		    echo "Saved SuccessFully";
			//echo $SQL ;
}
			
		}
	
	
		
		//Delete
			 
		if($strButton=="Delete" & $strShipmentTermId != null)
		{		
		 $SQL="update shipmentterms set intStatus=0  where strShipmentTermId='".$strShipmentTermId."';";
		 $db->ExecuteQuery($SQL);
		
		 echo "Deleted SuccessFully.";
		 }
	
		


?>
</body>
</html>
