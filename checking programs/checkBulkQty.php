<?php 
include "../Connector.php";	

$sql = " select gd.intBulkGrnNo,gd.intYear,gd.intMatDetailID,gd.strColor,gd.strSize,gd.strUnit,gd.dblQty from bulkgrndetails gd inner join bulkgrnheader gh on 
gh.intBulkGrnNo = gd.intBulkGrnNo and gh.intYear = gd.intYear
where gh.intStatus=1
order by gh.intBulkGrnNo" ;
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$stockQty = getStockQty($row["intBulkGrnNo"],$row["intYear"],$row["intMatDetailID"],$row["strColor"],$row["strSize"],$row["strUnit"]);
		$bulkQty = $row["dblQty"];
		if($stockQty>$bulkQty)
			echo 'GRN Qty: '.$bulkQty.' Stock Qty : '.$stockQty.'grnNo : '.$row["intBulkGrnNo"].'</br>';
	}
	

function getStockQty($grnNo,$grnYear,$matdetailId,$color,$size,$unit)
{
	global $db;
	$sql_s = " select sum(dblQty) as Qty from stocktransactions_bulk where intMatDetailId='$matdetailId' and strColor ='$color' and  strSize='$size' and strType='GRN' and  strUnit ='$unit' and  intBulkGrnNo='$grnNo'  and intBulkGrnYear ='$grnYear'" ;
	$result_s=$db->RunQuery($sql_s);
	$rowS = mysql_fetch_array($result_s);
	return $rowS["Qty"];
}	
?>