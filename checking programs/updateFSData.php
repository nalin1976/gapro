<?php 
include "../Connector.php";	

$sql = " select intStyleId,buyerCode,invoiceNo,ORDERCONTRACTNO,
concat(buyerCode,'/',country,'/',comcode,'/PO/',ORDERCONTRACTNO,'/',DATE_FORMAT(dtmDate, '%m/%y')) as strOCNo
from firstsale_oc ";
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{	
	updateFSData($row["intStyleId"],$row["invoiceNo"],$row["ORDERCONTRACTNO"],$row["strOCNo"]);
}

function updateFSData($styleId,$invoiceNo,$ocNo,$strOCNo)
{
	global $db;
	$sql = " update firstsalecostworksheetheader set dblOrderContractNo=$ocNo, strOrderContractNo='$strOCNo', dblInvoiceId='$invoiceNo' where intStyleId ='$styleId' ";
	echo $sql.'</br>';
	$result=$db->RunQuery($sql);

}
?>
