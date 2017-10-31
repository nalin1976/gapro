<?php 
include "../Connector.php";	

$sql = " select gd.intGrnNo,gd.intGRNYear,gd.intMatDetailID,gd.strColor,gd.strSize,gd.dblQty,intStyleId 
from grndetails gd inner join grnheader gh on 
gh.intGrnNo = gd.intGrnNo and gh.intGRNYear = gd.intGRNYear
 where gh.intStatus=1
order by gh.intGrnNo,gd.intGRNYear " ;
	$result=$db->RunQuery($sql);
	while($row = mysql_fetch_array($result))
	{
		$stockQty = getStockQty($row["intGrnNo"],$row["intGRNYear"],$row["intMatDetailID"],$row["strColor"],$row["strSize"],$row["intStyleId"]);
		$bulkQty = $row["dblQty"];
		if($stockQty>$bulkQty)
			echo 'GRN Qty: '.$bulkQty.' Stock Qty : '.$stockQty.' GRN no : '.$row["intGrnNo"].'</br>';
	}
	

function getStockQty($grnNo,$grnYear,$matdetailId,$color,$size,$styleId)
{
	global $db;
	$sql_s = " select sum(dblQty) as Qty from stocktransactions where intMatDetailId='$matdetailId' and strColor ='$color' and  strSize='$size' and strType='GRN' and  strGRNType ='S' and  intGrnNo='$grnNo'  and intGrnYear ='$grnYear' and intStyleId = '$styleId'" ;
	$result_s=$db->RunQuery($sql_s);
	$rowS = mysql_fetch_array($result_s);
	return $rowS["Qty"];
}
echo "Finish";
?>
