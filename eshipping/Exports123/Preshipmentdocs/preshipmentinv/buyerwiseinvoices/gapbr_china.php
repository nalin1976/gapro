<?php 
session_start();
include "../../../../Connector.php";
include "common_report.php";
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo="EXP/4.1";//$_GET['InvoiceNo'];
include "invoice_queries.php";
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>GAP-CHINA- 150633-EXP58308</title>
<style>
.s0 { text-align:center;vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000;font-weight:bold; }
.s1 { text-align:center;vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000; }
.s2 { text-align:right;vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000; }
.s3 { vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000;font-weight:bold; }
.s4 { vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000; }
.s5 { vertical-align:bottom;font-family:Arial;font-size:12px;color:#000000; }
.s6 { text-align:right;vertical-align:bottom;font-family:Arial;font-size:12px;color:#000000; }
.s7 { text-align:right;vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000;font-weight:bold; }
.s8 { vertical-align:bottom;font-family:Arial;font-size:12px;color:#000000;font-weight:bold;text-decoration:underline; }
.s9 { text-align:right;vertical-align:bottom;font-family:Arial;font-size:12px;color:#000000;font-weight:bold; }
.s10 { text-align:left;vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000; }
.s11 { vertical-align:bottom;font-family:Tahoma;font-size:13px;color:#000000; }
.s12 { text-align:left;vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000;font-weight:bold; }
.s13 { text-align:right;vertical-align:bottom;font-family:Arial;font-size:13px;color:#000000;font-weight:bold;text-decoration:underline; }
.s14 { text-align:right;vertical-align:top;font-family:Arial;font-size:13px;color:#000000; }
.s15 { text-align:right;vertical-align:top;font-family:Arial;font-size:13px;color:#000000;font-weight:bold; }
.s16 { text-align:right;vertical-align:bottom;font-family:Arial;font-size:11px;color:#000000;font-weight:bold; }
.s17 { text-align:right;vertical-align:bottom;font-family:Arial;font-size:11px;color:#000000; }
.s18 { vertical-align:top;font-family:Arial;font-size:13px;color:#000000;font-weight:bold; }

.b1 { border-bottom:1px solid #000000; }
.b2 { border-bottom:3px double #000000; }
</style>
</head>
<body bgcolor="#FFFFFF">
<table width="872" cols="14" border="0" cellpadding="0" cellspacing="0" align="center">
<tr height="17">
<td colspan="14" class="s0 b0"><?php echo $Company; ?></td>
</tr>
<tr height="17">
<td colspan="14" class="s1 b0"><?php echo $Address; ?></td>
</tr>
<tr height="17">
<td colspan="14" class="s1 b0"><?php echo $City; ?></td>
</tr>
<tr height="17">
<td colspan="14" class="s1 b0"></td>
</tr>
<tr height="17">
<td colspan="14" class="s0 b0">COMMERCIAL INVOICE</td>
</tr>
<?php
 
?>
<tr height="17">
<td width="299" class="s2 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Purchaser/Invoice to:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td colspan="6" class="s3 b0">Invoice No:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="normalfnt"><?php echo $invoiceNo;?></span></td>
<td colspan="2" class="s3 b0">Invoice Date:</td>
<td colspan="3" class="s4 b0">&nbsp;<?php echo $dateInvoice ;?></td>
</tr>
<tr height="17">
<td width="299" rowspan="6" class="s5 b0" style="vertical-align:text-top">&nbsp;
<br />
<?php echo $dataholder['BuyerAName'];?><br />
<?php echo $dataholder['buyerAddress1'];?><br />
<?php echo $dataholder['buyerAddress2'];?><br />
<?php echo $dataholder['BuyerCountry'];?><br />
</td>
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="63" class="s3 b0">Contact:</td>
<td colspan="5" class="s2 b0" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $BuyerContactPerson; ?></td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="63" class="s3 b0">PO No:&nbsp;</td>
<td colspan="5" class="s2 b0" style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="normalfnt"><?php  echo $r_summary->summary_string($invoiceNo,'strBuyerPONo');?></span></td>
<td colspan="2" class="s3 b0">Payment Terms:</td>
<td colspan="3" class="s4 b0">&nbsp;<span class="normalfnt"><?php echo $PayTerm; ?></span></td>
</tr>
<tr height="17">
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td colspan="6" class="s3 b0">Terms of Sale:&nbsp;<span class="normalfnt"><?php echo $Inco_terms;?></span></td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td colspan="6" class="s3 b0">Country of Origin:&nbsp;<span class="normalfnt">SRI LANKA</span></td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s7 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s7 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s6 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s7 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Ship To Address:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" rowspan="6" class="s2 b0" style="text-align:left; vertical-align:text-top">&nbsp;
<br />
<?php echo $dtoName; ?><br />
<?php echo $dtoAddress1; ?><br />
<?php echo $dtoAddress2; ?><br />
<?php echo $dtoCountry; ?><br />

</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s6 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Port of Loading:&nbsp;<span class="normalfnt"><?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></span></td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s4 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td colspan="3" class="s2 b0" style="text-align:left"><span class="s3 b0" style="text-align:left">Ship Mode:</span></td>
<td colspan="4" class="s2 b0" style="text-align:left">&nbsp;<span class="normalfnt"><?php echo $TransportMode; ?></span></td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Final Destination:&nbsp;<span class="normalfnt"><?php echo $dataholder['city'];?></span></td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s4 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td colspan="3" class="s3 b0">Shipment Date:</td>
<td colspan="4" class="s4 b0">&nbsp;<span class="normalfnt"><?php echo $SailingDate; ?></span></td>
</tr>
<tr height="17">
<td width="299" class="s2 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td colspan="3" class="s3 b0">&nbsp;</td>
<td width="64" class="s4 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s8 b0">DESCRIPTION OF GOODS (SEE BELOW)</td>
<td width="4" class="s9 b0">&nbsp;</td>
<td width="37" class="s9 b0">&nbsp;</td>
<td width="63" class="s9 b0">&nbsp;</td>
<td width="104" class="s9 b0">&nbsp;</td>
<td width="37" class="s9 b0">&nbsp;</td>
<td width="11" class="s9 b0">&nbsp;</td>
<td width="21" class="s9 b0">&nbsp;</td>
<td width="47" class="s9 b0">&nbsp;</td>
<td width="47" class="s9 b0">&nbsp;</td>
<td width="64" class="s9 b0">&nbsp;</td>
<td width="57" class="s9 b0">&nbsp;</td>
<td width="8" class="s9 b0">&nbsp;</td>
<td width="73" class="s9 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s7 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Tariff No (HTS Code):</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td colspan="9" class="s2 b0 normalfnt" style="text-align:left">&nbsp;<?php  echo $r_summary->summary_string($invoiceNo,'strHSCode');?></td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Fabric Content:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td colspan="9" class="s2 b0 normalfnt" style="text-align:left">&nbsp;<?php  echo $r_summary->summary_string($invoiceNo,'strFabric');?></td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Style:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td colspan="9" class="s2 b0 normalfnt" style="text-align:left">&nbsp;<?php  echo $r_summary->summary_string($invoiceNo,'strStyleID');?></td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Product  Description:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td colspan="9" class="s2 b0 normalfnt" style="text-align:left">&nbsp;<?php  echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?></td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
  <td width="299" class="s7 b0">&nbsp;</td>
  <td width="4" class="s2 b0">&nbsp;</td>
  <td width="37" class="s2 b0">&nbsp;</td>
  <td width="63" class="s5 b0">&nbsp;</td>
  <td width="104" class="s6 b0">&nbsp;</td>
  <td width="37" class="s6 b0">&nbsp;</td>
  <td width="11" class="s6 b0">&nbsp;</td>
  <td width="21" class="s6 b0">&nbsp;</td>
  <td width="47" class="s6 b0">&nbsp;</td>
  <td width="47" class="s6 b0">&nbsp;</td>
  <td width="64" class="s2 b0">&nbsp;</td>
  <td width="57" class="s2 b0">&nbsp;</td>
  <td width="8" class="s2 b0">&nbsp;</td>
  <td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
  <td width="299" class="s2 b1">&nbsp;</td>
  <td width="4" class="s2 b1">&nbsp;</td>
  <td width="37" class="s2 b1">&nbsp;</td>
  <td width="63" class="s6 b1">&nbsp;</td>
  <td width="104" class="s6 b1">&nbsp;</td>
  <td width="37" class="s6 b1">&nbsp;</td>
  <td width="11" class="s6 b1">&nbsp;</td>
  <td width="21" class="s6 b1">&nbsp;</td>
  <td width="47" class="s6 b1">&nbsp;</td>
  <td width="47" class="s6 b1">&nbsp;</td>
  <td width="64" class="s2 b1">&nbsp;</td>
  <td width="57" class="s2 b1">&nbsp;</td>
  <td width="8" class="s2 b1">&nbsp;</td>
  <td width="73" class="s2 b1">&nbsp;</td>
</tr>

<tr height="17">
  <td colspan="14" class="s2 b0" style="text-align:center">
  	
    <table width="100%" align="center" style="text-align:center" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td width="14%" class="normalfnt-center_size12">ITEM  #</td>
            <td width="13%" class="normalfnt-center_size12">ITEM QTY.</td>
            <td width="30%" class="normalfnt-center_size12">ITEM DESCRIPTION</td>
            <td width="9%" class="normalfnt-center_size12">PIECES</td>
            <td width="10%" class="normalfnt-center_size12">TOTAL</td>
            <td width="12%" class="normalfnt-center_size12">ITEM PRICE</td>
            <td width="12%" class="normalfnt-center_size12">EXTENDED</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="normalfnt-center_size12">(color/size/units per size)</td>
            <td class="normalfnt-center_size12">per item</td>
            <td class="normalfnt-center_size12">Pcs/Qty</td>
            <td class="normalfnt-center_size12">(USD)</td>
            <td class="normalfnt-center_size12">ITEM PRICE</td>
        </tr>
        <tr>
        	<td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom" style="text-align:center">(USD)</td>
        </tr>
		<?php
$sqlData="SELECT
strPLno,
strInvoiceNo,
strColor,
dblGrossMass,
dblNetMass,
dblNetNet,
intNoOfCTns
FROM
commercial_invoice_detail
WHERE strInvoiceNo='$invoiceNo';";

$resultData=$db->RunQuery($sqlData);
$totAmt=0;
$totQty=0;
$grossMass=0;
$netMass=0;
$netnetMass=0;
$noOfCtns=0;

while($rowData=mysql_fetch_array($resultData))
{
$plNo=$rowData['strPLno'];
$color=$rowData['strColor'];

$sql_detail="SELECT DISTINCT
shipmentplsizeindex.intColumnNo,
shipmentpldetail.dblNoofCTNS,
shipmentpldetail.strPLNo,
shipmentpldetail.strColor,
shipmentplsizeindex.strSize,
(SELECT strSKU FROM orderspecdetails WHERE strColor=shipmentpldetail.strColor AND strSize=shipmentplsizeindex.strSize) AS itemNo,
(SELECT dblPrice FROM orderspecdetails WHERE strColor=shipmentpldetail.strColor AND strSize=shipmentplsizeindex.strSize) AS itemPrice
FROM
shipmentpldetail
INNER JOIN shipmentplsizeindex ON shipmentpldetail.strPLNo = shipmentplsizeindex.strPLNo
right JOIN shipmentplsubdetail ON shipmentplsubdetail.strPLNo = shipmentpldetail.strPLNo AND shipmentplsubdetail.intRowNo = shipmentpldetail.intRowNo AND shipmentplsubdetail.intColumnNo = shipmentplsizeindex.intColumnNo
WHERE shipmentpldetail.strPLNo='$plNo' AND shipmentpldetail.strColor='$color'
ORDER BY shipmentplsizeindex.intColumnNo;";

$result_detail=$db->RunQuery($sql_detail);
?>
		
        <?php
		while($row_detail=mysql_fetch_array($result_detail))
		{
		$qty=0;
		$columnNo=$row_detail['intColumnNo'];
		
			$sqlQty="SELECT DISTINCT 
shipmentplsubdetail.dblPcs
FROM
shipmentplsubdetail
INNER JOIN shipmentpldetail ON shipmentpldetail.strPLNo = shipmentplsubdetail.strPLNo
WHERE
shipmentplsubdetail.strPLNo = '$plNo' AND
shipmentplsubdetail.intColumnNo =$columnNo 
";
		$resultQty=$db->RunQuery($sqlQty);
		while($rowQty=mysql_fetch_array($resultQty))
		{
			$qty=$qty+$rowQty['dblPcs'];
			$totQty=$totQty+$qty;
		}
		?>
        <tr>
        	<td class="normalfnt" style="text-align:center">&nbsp;<?php echo $row_detail['itemNo'] ;?></td>
            <td class="normalfnt" style="text-align:center">&nbsp;<?php echo $qty ;?></td>
            <td class="normalfnt" style="text-align:center">&nbsp;<?php echo $row_detail['strColor']."/".$row_detail['strSize'] ;?></td>
            <td class="normalfnt" style="text-align:center">&nbsp;1</td>
            <td class="normalfnt" style="text-align:center">&nbsp;<?php echo $qty ;?></td>
            <td class="normalfnt" style="text-align:center">&nbsp;<?php echo $row_detail['itemPrice'] ;?></td>
            <td class="normalfnt" style="text-align:center">&nbsp;<?php echo $row_detail['itemPrice']*$qty ;?></td>
        </tr>
		<?php
		$totAmt=$totAmt+($row_detail['itemPrice']*$qty);
		}
		$grossMass=$grossMass+$rowData['dblGrossMass'];
		$netMass=$netMass+$rowData['dblNetMass'];
		$netnetMass=$netnetMass+$rowData['dblNetNet'];
		$noOfCtns=$noOfCtns+$rowData['intNoOfCTns'];
	}
	$discount=($totAmt*2.5)/100;
		?>
        <tr>
        	<td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
            <td class="border-bottom">&nbsp;</td>
        </tr>
    </table> 
  
  </td>
  </tr>
<tr height="17">
<td width="299" class="s3 b0">Total  Pieces:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0" style="text-align:center"><?php echo $totQty; ?></td>
<td colspan="2" class="s2 b0" style="text-align:center"><span class="s3 b0">SubTotal:</span></td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0" style="text-align:right"><?php echo $totAmt; ?></td>
</tr>
<tr height="17">
<td width="299" class="s2 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td colspan="2" class="s12 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s4 b0"><font style="font-family:Arial;font-size:13px;">Less early payment discount of 2.5% per terms and conditions of Purchase Order&nbsp;</font><font style="font-family:Arial;font-size:13px;"><b>(if applicable)</b></font></td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s1 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s13 b0"><?php echo $discount?></td>
</tr>
<tr height="18">
<td width="299" class="s2 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s1 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td colspan="2" class="s3 b0" style="text-align:center">Grand Total:</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b2">$<?php echo $totAmt-$discount; ?></td>
</tr>
<tr height="18">
<td width="299" class="s7 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s7 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Total Number of pieces :</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s6 b0"><?php echo $totQty; ?></td>
<td width="104" class="s4 b0">pieces</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Total Number of Cartons:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s6 b0"><?php echo $noOfCtns; ?></td>
<td width="104" class="s4 b0">Cartons.</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Gross Weight in Kgs:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s6 b0"><?php echo $grossMass; ?></td>
<td width="104" class="s4 b0">kg</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s14 b0">&nbsp;</td>
<td width="64" class="s14 b0">&nbsp;</td>
<td width="57" class="s14 b0">&nbsp;</td>
<td width="8" class="s14 b0">&nbsp;</td>
<td width="73" class="s14 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Net Weight in Kgs:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s6 b0"><?php echo $netMass; ?></td>
<td width="104" class="s4 b0">kg</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s15 b0">&nbsp;</td>
<td width="64" class="s14 b0">&nbsp;</td>
<td width="57" class="s14 b0">&nbsp;</td>
<td width="8" class="s14 b0">&nbsp;</td>
<td width="73" class="s14 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">Net Net Weight:</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s6 b0"><?php echo $netnetMass; ?></td>
<td width="104" class="s4 b0">kg</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s16 b0">&nbsp;</td>
<td width="64" class="s14 b0">&nbsp;</td>
<td width="57" class="s14 b0">&nbsp;</td>
<td width="8" class="s14 b0">&nbsp;</td>
<td width="73" class="s14 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s7 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s6 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s17 b0">&nbsp;</td>
<td width="57" class="s17 b0">&nbsp;</td>
<td width="8" class="s17 b0">&nbsp;</td>
<td width="73" class="s17 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s3 b0">I hereby certify that all information provided are true and correct.</td>
<td width="4" class="s14 b0">&nbsp;</td>
<td width="37" class="s14 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s17 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s7 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s17 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s2 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s2 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s6 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s2 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s7 b0">&nbsp;</td>
<td width="57" class="s6 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s2 b0">&nbsp;</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s7 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s17 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s15 b0">&nbsp;</td>
<td width="4" class="s14 b0">&nbsp;</td>
<td width="37" class="s14 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="47" class="s15 b0">&nbsp;</td>
<td width="64" class="s7 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s15 b0">&nbsp;</td>
<td width="4" class="s14 b0">&nbsp;</td>
<td width="37" class="s14 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s15 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s15 b0">&nbsp;</td>
<td width="4" class="s14 b0">&nbsp;</td>
<td width="37" class="s14 b0">&nbsp;</td>
<td width="63" class="s2 b0">&nbsp;</td>
<td width="104" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s17 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s4 b0">……………………………………………………………</td>
<td width="4" class="s2 b0">&nbsp;</td>
<td width="37" class="s2 b0">&nbsp;</td>
<td width="63" class="s6 b0">&nbsp;</td>
<td width="104" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="11" class="s2 b0">&nbsp;</td>
<td width="21" class="s2 b0">&nbsp;</td>
<td width="47" class="s15 b0">&nbsp;</td>
<td width="47" class="s7 b0">&nbsp;</td>
<td width="64" class="s2 b0">&nbsp;</td>
<td width="57" class="s2 b0">&nbsp;</td>
<td width="8" class="s2 b0">&nbsp;</td>
<td width="73" class="s2 b0">&nbsp;</td>
</tr>
<tr height="17">
<td width="299" class="s18 b0">Company Seal & Signature</td>
<td width="4" class="s14 b0">&nbsp;</td>
<td width="37" class="s14 b0">&nbsp;</td>
<td width="63" class="s6 b0">&nbsp;</td>
<td width="104" class="s6 b0">&nbsp;</td>
<td width="37" class="s6 b0">&nbsp;</td>
<td width="11" class="s6 b0">&nbsp;</td>
<td width="21" class="s6 b0">&nbsp;</td>
<td width="47" class="s6 b0">&nbsp;</td>
<td width="47" class="s6 b0">&nbsp;</td>
<td width="64" class="s6 b0">&nbsp;</td>
<td width="57" class="s6 b0">&nbsp;</td>
<td width="8" class="s6 b0">&nbsp;</td>
<td width="73" class="s6 b0">&nbsp;</td>
</tr>
</table>
</body>
</html>
