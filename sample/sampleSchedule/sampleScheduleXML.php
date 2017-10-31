<?php
session_start();
include "../../Connector.php";


$RequestType = $_GET['RequestType'];

if($RequestType == "save")
{
	$fab     = $_GET['fab'];
	$styleid = $_GET['styleid'];
	$duedate = $_GET['duedate'];

	
	$sql     = "UPDATE sampleschedule
			    SET strFabricDue='$fab',dtmDueDate='$duedate'
			    WHERE intStyleId=$styleid";
				
	$db->RunQuery($sql);
}

?>