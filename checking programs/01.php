<?php 
include "../Connector.php";	

$sql="select ROUND(sum(dblQty),4)as q ,intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,intGrnNo,intGrnYear,strGRNType from stocktransactions 
group by intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,intGrnNo,intGrnYear,strGRNType
having q<0";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$orderNo = GetOrderNo($row["intStyleId"]);
	echo $row["intStyleId"].'-'.$orderNo.'-'.$row["strBuyerPoNo"].'-'.$row["intMatDetailId"].'-'.$row["strColor"].'-'.$row["strSize"].'-'.$row["intGrnYear"].'/'.$row["intGrnNo"].' - '.$row["strGRNType"].'->'.round($row["q"],50);
		echo "<br/>"; 
}
echo 'DONE';
function GetOrderNo($styleId)
{
global $db;
	$sql3="select strOrderNo from orders where intStyleId='$styleId'";
	$result3=$db->RunQuery($sql3);
	while($row3=mysql_fetch_array($result3))
	{
		return $row3["strOrderNo"];
	}
}
?>