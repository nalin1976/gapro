<?php
include '../../../Connector.php';
$reportType	= $_GET["ReportType"];
$checkDate	= $_GET["CheckDate"];
$dateFrom	= $_GET["DateFrom"];
$dateTo		= $_GET["DateTo"];
$supplier	= $_GET["Supplier"];
$disInvoice	= $_GET["DisInvoice"];
$factory	= $_GET["Factory"];
$deci		= 4;

if($reportType=="E")
{
	header('Content-Type: application/vnd.ms-word');
	header('Content-Disposition: attachment;filename="rptPaymentDiscrepancy.xls"');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>GaPro | Style Payment Discrepancy Report</title>

<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../js/jquery-1.4.2.min.js"></script>
<style type="text/css">
table.fixHeader {
	border: solid #FFFFFF;
	border-width: 1px 1px 1px 1px;
	width: 1050px;
}

tbody.ctbody {
	height: 580px;
	overflow-y: auto;
	overflow-x: hidden;
}
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th width="100%" colspan="7" class="head2">Style Payment Discrepancy Report</th>
  </tr>
  <tr>
    <td colspan="7"><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000" id="tblMain">
	<thead>
      
      <tr bgcolor="#CCCCCC">
        <th width="2%" height="25" scope="col" class="normalfntMid">No</th>
        <th width="25%" class="normalfntMid">Supplier Name </th>
        <th width="7%"  class="normalfntMid">Invoice No </th>
        <th width="7%" class="normalfntMid">Invoice Date </th>
        <th width="8%" class="normalfntMid">PO Value </th>
        <th width="8%" class="normalfntMid">GRN Value </th>
        <th width="9%" class="normalfntMid">Invoice Value </th>
        <th width="13%" nowrap="nowrap" class="normalfntMid">Variance<br/>GRN Val. Vs Inv Val.</th>
        <th width="19%" class="normalfntMid">Remarks</th>
        <th width="2%" class="normalfntMid">&nbsp;</th>
      </tr>
	  </thead>
	  <tbody class="ctbody">
<?php
	$sql="select S.strTitle,GH.strInvoiceNo,GH.dtmConfirmedDate,GH.dblGRNValue,GH.dblInvoiceValue,PH.dblPOValue,strPayDisReason
		from grnheader GH
		inner join purchaseorderheader PH on PH.intPONo=GH.intPONo and PH.intYear=GH.intYear
		inner join suppliers S on S.strSupplierID=PH.strSupplierID ";
if($supplier!="")
	$sql .= " and S.strSupplierID=$supplier ";
if($factory!="")
	$sql .= "and GH.intCompanyID='$factory' ";
if($checkDate=='true')
	$sql .= " and date(GH.dtmConfirmedDate)>='$dateFrom' and date(GH.dtmConfirmedDate) <='$dateTo'";
if($disInvoice=='true')
	$sql .= " and GH.dblGRNValue<>GH.dblInvoiceValue";	
$result=$db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$varianceFontColor	= '';
	$poValue		= round($row["dblPOValue"],4);
	$grnValue 		= round($row["dblGRNValue"],4);
	$invoiceValue	= round($row["dblInvoiceValue"],4);
	$variance		= round($grnValue-$invoiceValue,4);
	
	if($grnValue<$invoiceValue)
		$varianceFontColor	= '#FF0000';
	elseif($grnValue>$invoiceValue)
		$varianceFontColor	= '#00CC00';
	else
		$varianceFontColor	= '#000000';
?>
      <tr bgcolor="#FFFFFF">
        <td height="20" class="normalfntRite"><?php echo ++$i.'.';?></td>
        <td nowrap="nowrap" class="normalfnt" ><?php echo $row["strTitle"];?></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strInvoiceNo"]?></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["dtmConfirmedDate"]?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($poValue,4) ?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($grnValue,4) ?></td>
        <td nowrap="nowrap" class="normalfntRite"><?php echo number_format($invoiceValue,4) ?></td>
        <td nowrap="nowrap" class="normalfntRite" style="color:<?php echo $varianceFontColor ?>"><b><?php echo number_format($variance,4) ?></b></td>
        <td nowrap="nowrap" class="normalfnt"><?php echo $row["strPayDisReason"]?></td>
        <td nowrap="nowrap" class="normalfntRite">&nbsp;&nbsp;</td>
      </tr>
<?php
}
?>
	<tr class="bcgcolor-tblrowWhite">
        <td colspan="10" class="normalfntRite">&nbsp;</td>
        </tr>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td colspan="7" >&nbsp;</td>
  </tr>
</table>
</body>
</html>
