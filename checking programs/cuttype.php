<?php
include "../Connector.php";
$sql="select intCutBundleNo,intCutType from testing.cuttype1";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	Update($row["intCutBundleNo"],$row["intCutType"]);
}

function Update($serialNo,$cutType)
{
	global $db;
	$sql_u="update productionbundleheader set cut_type='$cutType' where intCutBundleSerial='$serialNo'";
	$result=$db->RunQuery($sql_u);
}
echo "DONE";
?>