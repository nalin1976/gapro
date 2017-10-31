<?php
include "../Connector.php";
$backwardseperator = "../";

$RequestType =$_GET["RequestType"];

if($RequestType=="Save")
{
	$FieldName = $_GET["FieldName"];
	$PermisionList = $_GET["PermisionList"];
	$UserId = $_GET["UserId"];
	
	SaveDetails($FieldName,$UserId,$PermisionList);
	echo "Saved successfully.";
}
elseif($RequestType=="Delete")
{
	$PermissionId = $_GET["PermissionId"];
	$UserId = $_GET["UserId"];
	
	DeleteItem($PermissionId,$UserId);
	echo "Deleted successfully.";
}

function SaveDetails($FieldName,$UserId,$PermisionList)
{
	global $db;
	$sql_del="delete from emails where intUserId = '$UserId' and intPermissionId = '$FieldName';";
	$db->ExecuteQuery($sql_del);
	
	$sql="insert into emails 
	(intUserId, 
	intPermissionId, 
	strUserEmails)
	values
	('$UserId', 
	'$FieldName', 
	'$PermisionList');";
	$db->ExecuteQuery($sql);
}

function DeleteItem($PermissionId,$UserId)
{
	global $db;
	$sql_del="delete from emails where intUserId = '$UserId' and intPermissionId = '$PermissionId';";
	$db->ExecuteQuery($sql_del);
}
?>