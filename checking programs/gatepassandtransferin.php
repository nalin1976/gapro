<?php 
include "../Connector.php";

ini_set('max_execution_time', 2000000);

$sql="select intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,intGrnNo,intGrnYear,strGRNType,sum(dblQty)as A from stocktransactions 
where strType in ('SGatePass','TI')
group by intStyleId,strBuyerPoNo,intMatDetailId,strColor,strSize,intGrnNo,intGrnYear,strGRNType
having A >0;";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$orderNo = GetOrderNo($row["intStyleId"]);
	$gpQty = $row["dblQty"];
	/*echo $row["intStyleId"].'-'.$orderNo.'-'.$row["strBuyerPoNo"].'-'.$row["intMatDetailId"].'-'.$row["strColor"].'-'.$row["strSize"].'-'.$row["intGrnYear"].'/'.$row["intGrnNo"].' - '.$row["strGRNType"].'->'.round($row["q"],50);
		echo "<br/>"; */
		
	$result1 = GetDetails($row["intStyleId"],$row["strBuyerPoNo"],$row["intMatDetailId"],$row["strColor"],$row["strSize"],$row["intGrnNo"],$row["intGrnYear"],$row["strGRNType"]);
	
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

function GetDetails($styleId,$BuyerPoNo,$matId,$color,$size,$gNo,$gYear,$gType)
{
global $db;
$sql1="select strMainStoresID,strSubStores,strLocation,strBin,intDocumentNo,intDocumentYear,strType,dblQty from stocktransactions where intStyleId='$styleId' and strBuyerPoNo='$BuyerPoNo' and intMatDetailId='$matId' and strColor='$color' and strSize='$size' and intGrnNo='$gNo' and intGrnYear='$gYear' and strGRNType='$gType';";
echo $sql1;
echo "<br/>";
//return $db->RunQuery($sql1);
}
?>