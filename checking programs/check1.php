<?php
include "../Connector.php";	
$sql="select intMatRequisitionNo,intYear,intStyleId,strBuyerPONO,strMatDetailID,strColor,strSize,dblQty,dblBalQty,intGrnNo,intGrnYear from matrequisitiondetails ";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$orderNo = GetOrderNo($row["intStyleId"]);
	$sCount = GetStockCount($row["intStyleId"],$row["strBuyerPONO"],$row["strMatDetailID"],$row["strColor"],$row["strSize"],$row["intGrnNo"],$row["intGrnYear"]);
	if($row["dblBalQty"]>$sCount)
	{
		echo $row["intMatRequisitionNo"].'-'.$row["intYear"].'-'.$row["intStyleId"].'--'.$orderNo.'-'.$row["strBuyerPONO"].'-'.$row["strMatDetailID"].'-'.$row["strColor"].'-'.$row["strSize"].'-'.$row["intGrnYear"].'/'.$row["intGrnNo"].'-'.$row["dblQty"].'-'.$row["dblBalQty"].'->'.$sCount;
		echo "<br/>"; 
	}
	
}

function GetStockCount($stid,$bupo,$matId,$color,$size,$grnNo,$grnYear)
{
global $db;
$count = 0;
	$sql2="select sum(dblQty)as sockQty from stocktransactions where intStyleId='$stid' and strBuyerPoNo='$bupo' and intMatDetailId='$matId' and strColor='$color' and strSize='$size' and intGrnNo='$grnNo' and intGrnYear='$grnYear';";
	$result2=$db->RunQuery($sql2);
	while($row2=mysql_fetch_array($result2))
	{
		$count = $row2["sockQty"];
	}
return $count;
}

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