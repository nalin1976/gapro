<?php
include "../../Connector.php";	
$sql="select distinct CH.intTransferNo,CH.intTransferYear,intStatus from commonstock_bulkdetails CD inner join commonstock_bulkheader CH on CH.intTransferNo=CD.intTransferNo and CH.intTransferYear=CD.intTransferYear";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	//echo $row["intTransferYear"].'/'.$row["intTransferNo"];
	$count = GetCount($row["intTransferNo"],$row["intTransferYear"]);
	$sCount = GetStockCount($row["intTransferNo"],$row["intTransferYear"]);
	if($count<>$sCount)
	{
		echo $row["intTransferYear"].'/'.$row["intTransferNo"].'-'.$count.'-'.$sCount.'->'. $row["intStatus"];
		echo "<br/>"; 
	}
	
}

function GetCount($no,$year)
{
global $db;
$count = 0;
$sql1="select count(*)as count from commonstock_bulkdetails where intTransferNo='$no' and intTransferYear='$year';";
$result1=$db->RunQuery($sql1);
while($row1=mysql_fetch_array($result1))
{
	$count = $row1["count"];
}
return $count;
}

function GetStockCount($no,$year)
{
global $db;
$count = 0;
$sql2="select count(*)as count from stocktransactions where intDocumentNo='$no' and intDocumentYear='$year' and strType='BAlloIn'";
$result2=$db->RunQuery($sql2);
while($row2=mysql_fetch_array($result2))
{
	$count = $row2["count"];
}
return $count;
}
?>