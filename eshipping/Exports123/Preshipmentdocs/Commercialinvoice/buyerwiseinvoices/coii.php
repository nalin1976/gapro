<?php 
session_start();
include "../../../../Connector.php";
include 'common_report.php';
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$invoiceNo=$_GET['InvoiceNo'];
include("invoice_queries.php");	



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CO-II</title>
<?PHP //$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="900" border="0" cellspacing="0" cellpadding="2" style="font-family:Book Antiqua;font-size:14px;">
  <tr>
    <td colspan="3" style="font-family:forte;font-size:56px;border-bottom-style:solid;border-bottom-width:1px;" > Orit Trading Lanka (Pvt) Ltd</td>
  </tr>
  <tr>
    <td colspan="3" style="font-family:forte;font-size:13px;" nowrap="nowrap"><span class="border-left-fntsize10"><?php echo $Address;?></span>,<?php echo $City;?>. Tel: <?php echo $phone;?> Fax: <?php echo $Fax;?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><?php echo $dateInvoice;?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" style="font-family:Book Antiqua;font-size:16px;"><strong><u>CERTIFICATE OF ORIGIN</u></strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="242">INVOICE NO</td>
    <td colspan="2"><span class="normalfnt_size12"><?php echo $invoiceNo;?>  </span></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>QUANTITY</td>
    <td width="111"><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity')." ".$r_summary->summary_string($invoiceNo,'strUnitID');?> ONLY</td>
    <td width="485"><?php echo number_format(($r_summary->summary_sum($invoiceNo,'dblQuantity')/12),2);?> DZN</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>U.S. DOLLAR AMOUNT $</td>
    <td colspan="2"><?php echo number_format($r_summary->summary_sum($invoiceNo,'dblAmount'),2);?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">WE HEREBY CERTIFY THAT THE ABOVE MENTIONED CONSIGNMENT IS OF SRI LANKA ORIGIN.</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" style="font-family:Book Antiqua;font-size:20px;"><strong>ORIT TRADING LANKA (PVT) LTD</strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Commercial Manager</strong></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>