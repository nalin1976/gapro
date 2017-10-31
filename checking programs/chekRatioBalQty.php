<?php 
include "../Connector.php";	
ini_set('max_execution_time', 20000000);
$sql_o = "select intStyleId,strOrderNo from orders where intStatus not in (13,14) order by strOrderNo";
$result_o=$db->RunQuery($sql_o);
while($rowO=mysql_fetch_array($result_o))
{
	$sql_mat = "select * from materialratio where intStyleId='".$rowO["intStyleId"]."' ";
	$result_mat=$db->RunQuery($sql_mat);
	while($rowM=mysql_fetch_array($result_mat))
	{
		$ratioQty = $rowM["dblQty"];
		$balQty = $rowM["dblBalQty"];
		
		$itemID = $rowM["strMatDetailID"];
		$color = $rowM["strColor"];
		$size = $rowM["strSize"];	
		
		$POQty = getConfirmPOQty($rowO["intStyleId"],$itemID,$color,$size);
		$leftAlloQty = getLeftOverAllocationQty($rowO["intStyleId"],$itemID,$color,$size);
		$bulkAlloQty = getBulkAllocationQty($rowO["intStyleId"],$itemID,$color,$size);
		
		$calQty = $ratioQty - ($POQty +$leftAlloQty +$bulkAlloQty);
		//echo $rowO["intStyleId"];
		if($balQty != $calQty)
			echo $rowO["strOrderNo"].'-'.$rowO["intStyleId"].' MatDetailID - '.$itemID.' Ratio Qty- '.$ratioQty.' BalQty -'.$balQty.' PO Qty -'.$POQty.' left AlloQty-'.$leftAlloQty.' bulk AlloQty-'.$bulkAlloQty.' - calQty '.$calQty.'</br>';
		
	}
}
function getConfirmPOQty($styleID,$itemID,$color,$size)
{
global $db;
	$SQL_orderqty="SELECT sum(purchaseorderdetails.dblQty)as qty
		 FROM purchaseorderdetails
		 Inner Join purchaseorderheader ON purchaseorderheader.intPONo = purchaseorderdetails.intPoNo
		 AND purchaseorderheader.intYear = purchaseorderdetails.intYear
		 WHERE purchaseorderdetails.intStyleId =  '$styleID'
		 AND purchaseorderdetails.intMatDetailID =  '$itemID'
		 AND purchaseorderdetails.strColor =  '$color'
		 AND purchaseorderdetails.strSize =  '$size' 	 
		 AND purchaseorderheader.intStatus =  '10' ";		 
//echo $SQL_orderqty;
	$result_orderqty = $db->RunQuery($SQL_orderqty);
	$row_orderqty=mysql_fetch_array($result_orderqty);
	return $row_orderqty["qty"];
}
function getLeftOverAllocationQty($styleID,$itemID,$color,$size)
{
	global $db;
	$sql = "select COALESCE(sum(LD.dblQty),0) as dblQty from commonstock_leftoverdetails LD inner join  commonstock_leftoverheader LH on
LH.intTransferNo = LD.intTransferNo and LD.intTransferYear = LH.intTransferYear 
where LH.intStatus=1  and LD.intMatDetailId='$itemID' and LD.strColor='$color' and LD.strSize='$size' and LH.intToStyleId='$styleID' ";
	
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
function getBulkAllocationQty($styleID,$itemID,$color,$size)
{
global $db;
	$sql = " select COALESCE(sum(dblQty),0) as dblQty  
		from commonstock_bulkdetails BD inner join commonstock_bulkheader BH on
		BD.intTransferNo = BH.intTransferNo and 
		BD.intTransferYear = BH.intTransferYear 
		where intMatDetailId='$itemID' and BH.intToStyleId='$styleID' and strColor='$color'
               and strSize='$size' and intStatus =1 ";
	//echo $sql;		   
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["dblQty"];
}
?>