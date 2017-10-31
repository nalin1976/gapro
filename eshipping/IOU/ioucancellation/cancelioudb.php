<?php 
	include "../../Connector.php";
	$iouno=$_GET[iouno];
	$reason=$_GET[reason];
	$request=$_GET[request];
	$dtecancel=date("y:m:d");
	$userid=$_SESSION["UserID"];
	if($request=='cancel')
	{
		$str="insert into tblioucancellation 
	(iouno, 
	dtmcanceled, 
	reason, 
	userid
	)
	values
	('$iouno', 
	'$dtecancel', 
	'$reason', 
	'$userid'
	);
";
		$results=$db->RunQuery($str);
	if($results)
	echo "Canceled";
	} 
?>
