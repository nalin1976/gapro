<?php
include "../Connector.php";
$sql="select dblPrice,intSerialNo from testing.genitemunitprice";

$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	Update($row["intSerialNo"],round($row["dblPrice"],4));
}

function Update($serialNo,$unitPrice)
{
	global $db;
	$sql_u="update genmatitemlist set dblLastPrice='$unitPrice' where intItemSerial='$serialNo'";
	$result=$db->RunQuery($sql_u);
}
echo "DONE";
?>