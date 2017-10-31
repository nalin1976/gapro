<?php 
session_start();
$document='NI';
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
include("invoice_queries.php");	
include 'common_report.php';

$invoiceNo=$_GET['InvoiceNo'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>GSP CHECKLIST-OXYLANE</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="1000" border="0" cellspacing="0" cellpadding="2" align="center">
  
  <tr>
    <td class="head2">&nbsp;</td>
    <td height="36" class="head2">GSP Checklist - Oxylane</td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <thead>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
      <!--<th width="3%" style="visibility:hidden">&nbsp;</th>-->
        <td colspan="2" align="center" >PO Number</td>
        <th width="4%">Iman</th>
        <th width="10%">Supplier Name</th>
        <th width="18%">Means of Transport &amp; route</th>
        <th width="7%">Cartoons</th>
        <th width="3%">PCS</th>
        <th width="8%">Description</th>
        <th width="10%">HS code Criterion</th>
        <th width="10%">Net Weight (KGS)</th>
        <th width="7%">Exported to</th>
         <th width="11%">Invoice No &amp; Date</th>
        </tr>
        
        
      </thead> 
<?php

	
	  $sql_Finv="SELECT
				commercial_invoice_detail.strInvoiceNo,
				commercial_invoice_detail.strBuyerPONo,
				Sum(commercial_invoice_detail.dblAmount) AS dblAmount,
				DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate,
				commercial_invoice_detail.dblQuantity,
				commercial_invoice_detail.intNoOfCTns,
				commercial_invoice_detail.dblNetMass,
				commercial_invoice_detail.strDescOfGoods,
				commercial_invoice_detail.strHSCode,
				commercial_invoice_header.dtmInvoiceDate,
				commercial_invoice_header.strInvoiceNo,
				city.strCity,
				commercial_invoice_header.strFinalDest,
				commercial_invoice_header.strPortOfLoading,
				commercial_invoice_header.intNoOfCartons,
				commercial_invoice_header.strTransportMode,
				commercial_invoice_header.strDeliverTo,
				commercial_invoice_header.intFInvReceived
				FROM
				commercial_invoice_detail
				INNER JOIN commercial_invoice_header ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
				INNER JOIN city ON commercial_invoice_header.strFinalDest = city.strCityCode
				WHERE
				commercial_invoice_header.strInvoiceNo = '$invoiceNo'
				GROUP BY
				commercial_invoice_detail.strInvoiceNo
				 ";
				 
	$result_Finv = $db->RunQuery($sql_Finv);
	$row_Finv = mysql_fetch_array($result_Finv);
	
	$count=0;
	while($sql_Finv = mysql_fetch_array($result_Finv))
{
	
	$count		+= $count;
?>		 
    <tr bgcolor="#FFFFFF" class="normalfnt">
    	<td width="2%" ><?php $count; ?></td>
    	<td width="10%" height="20">&nbsp;</td>
    	<td >&nbsp;</td>
    	<td >&nbsp;</td>
        <td >&nbsp;</td>
        <td class="normalfntMid">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntRite">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite">&nbsp;</td>
       <!-- <td class="normalfntRite">&nbsp;</td>-->
        </tr>
<?php
	$totQuantity		+= round($row["dblQuantity"],0);
	$totGrossAmount		+= round($row["dblAmount"],2);
	$totCDNquantity		+= round($row_cdn["cdnQuantity"]);
	$totCDNAmt		+= round($row_cdn["cdnAmount"],2);
	$totFinvQty		+= round($row_Finv["finvQuantity"]);
	$totFinvAmt		+= round($row_Finv["finvAmount"],2);
}
?>
	    
<?php
$totQuantity 	= 0;
$totGrossAmount	= 0;
?> 
    </table></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
   <tr>
     <td>&nbsp;</td>
    <td><center>I here by confirm above details are correct and accurate.</center></td>
  </tr>
   <tr>
     <td>&nbsp;</td>
    <td><center>I'm aware that in case any of above details are incorrect, the consignment will be held and the shipper (herein &quot;supplier&quot;) will bear all penalties.</center></td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr>
    <td>&nbsp;</td>
  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="34%">Date - </td>
      <td width="28%">Name - </td>
      <td width="38%" class="border-bottom">&nbsp;</td>
    </tr>
     <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><center>Signature</center></td>
    </tr>
  </table></td></tr>
</table>
</body>
</html>