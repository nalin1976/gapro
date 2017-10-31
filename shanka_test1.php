<?php
include "Connector.php";
$hi	= array();
$sql="select intQty,strOrderNo from orders limit 0,10";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$loop++;
	$hi[$loop][0] = $row["strOrderNo"];
	$hi[$loop][1] = $row["intQty"];
}

for($i=1;$i<=count($hi);$i++)
{
	if($hi[$i][0]=='4100116319')
	{
		echo $hi[$i][1];
	}
}
?>