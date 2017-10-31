<?php
include "../Connector.php";

	$sql="select intStyleId,strOrderNo,strOrderColorCode from orders ";			
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$orderNoLength 		= strlen($row["strOrderNo"]);
		$colorCodeLength    = strlen($row["strOrderColorCode"]);
		$intStyleId    		= $row["intStyleId"];
		
		if($colorCodeLength == 0)
			$orderNo = substr($row["strOrderNo"],0,$orderNoLength-$colorCodeLength);
		else
			$orderNo = substr($row["strOrderNo"],0,$orderNoLength-$colorCodeLength-1);
			
		$sql1="update orders set strBuyerOrderNo='$orderNo' where intStyleId='$intStyleId'";
		$result1=$db->RunQuery($sql1);			
	}
?>