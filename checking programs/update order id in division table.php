<?php
include "../Connector.php";	
$sql="select intStyleId,intDivisionId from zz_division_all";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$division 	= $row["intDivisionId"];
	$styleId 	= $row["intStyleId"];
	$sql1="update orders set intDivisionId='$division' where intStyleId='$styleId'";
	$db->RunQuery($sql1);
	echo "Order Id $styleId-> Division $division<br/>";
}
echo "Finish";
?>