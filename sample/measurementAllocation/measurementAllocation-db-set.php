<?php

include "../../Connector.php";
$requestType=$_GET['requestType'];

if($requestType=='saveData')
{
	$styleId=$_GET['styleId'];
	//$styleId=$_GET['styleId'];
	$mesId=$_GET['mesId'];
	$size=$_GET['size'];
	$dblMes=$_GET['dblMes'];
	
	
	
	$sql="INSERT INTO measurement_allocation (intStyleNo,intMeasurementId,strSize,dblMeasurement)
		  VALUES('$styleId','$mesId','$size','$dblMes')";
	//echo($sql);	  
	$result=$db->RunQuery($sql);
	if($result)
		echo "1";
		
	
	
}

else if($requestType=='DeleteData')
{
	$styleId = $_GET['styleId'];
	$sqldelete = "DELETE FROM measurement_allocation WHERE intStyleNo=$styleId";
	$db->RunQuery($sqldelete);
}
?>