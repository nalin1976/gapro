<?php 
session_start();
include "../../Connector.php";

$RequestType=$_GET["RequestType"];

if($RequestType=="deleteGroup")
{
 $groupid    = $_GET["groupid"];
 $groupname  = $_GET["groupname"];
 
 $SQL = "Delete from matitemgroupdetails where groupID = $groupid";
 $result=$db->RunQuery($SQL);
 
 $SQL2 = "Delete from matitemgroup where matItemGroupId = $groupid";
 $result2=$db->RunQuery($SQL2);

	if ($result==1 && $result2==1){
	echo "1";
	}else{
	echo "saving-error";
	}
}
?>
