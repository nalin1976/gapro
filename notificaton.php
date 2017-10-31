<?php 
$sql="select count(*) as count from notification where intStatus=0";
$result=$db->RunQuery($sql);
$row=mysql_fetch_array($result);
if($row["count"]>0)
	return "New Notification";
else
	return "";
?>