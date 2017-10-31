<?php 
session_start();
include("../../Connector.php");
header('Content-Type: text/xml'); 	
$request 	= $_GET["request"];
$userId		= $_SESSION["UserID"];

if($request=="saveRevise")
{
	$PLNo     = $_GET["PLNo"];
	$reason   = $_GET["reason"];
	$date     = $_GET["date"];
	$dateArry = explode('/',$date);
	$newDate  = $dateArry[2].'-'.$dateArry[1].'-'.$dateArry[0];
	
	$sql = "insert into shipmentplrevise 
			( 
			strRevisePLNo, 
			dtmReviseDate, 
			strReviseReason, 
			dtmSaveDate, 
			intUserId
			)
			values
			(
			'$PLNo', 
			'$newDate', 
			'$reason', 
			now(), 
			'$userId'
			)";
	$result = $db->RunQuery($sql);
	if($result)
	{
		$sql_update ="update shipmentplheader 
				set
				intConfirmaed = '0'
				where
				strPLNo = '$PLNo';";
		$result_update = $db->RunQuery($sql_update);
		if($result_update)
		{
			echo "revised";
		}
		else
			 echo "error";
	}
	else
		echo "error";
}

?>