<script type="text/javascript">

<?php

session_start();
include "../../../../Connector.php";
include 'common_report.php';
include("invoice_queries.php");	

$invoiceNo=$_GET['InvoiceNo'];
$str_pl="select strPLno from commercial_invoice_detail where strInvoiceNo='$invoiceNo'";
$result_pl=$db->RunQuery($str_pl);
	
while($row_pl=mysql_fetch_array($result_pl))
{
	$plno=$row_pl['strPLno'];
	?>
window.open('zolla_dpl_excel.php?plno=<?php echo $plno;?>&invoiceNo=<?php echo $invoiceNo;?>','<?php echo $plno;?>');	//plno is used as the page name.
	<?php
}

?>

</script>