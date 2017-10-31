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
<title>BENEFICIARY' S STATEMENT</title>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="850" border="0" cellspacing="0" cellpadding="2" style="font-family:Book Antiqua;font-size:14px;">
  <tr>
    <td colspan="5" style="font-family:forte;font-size:52px;" nowrap="nowrap"> <?php echo $Company; ?></td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:forte;font-size:13px;" nowrap="nowrap"><?php echo $Address; ?><?php echo $City; ?>. Tel:<?php echo $phone;  ?> Fax: <?php echo $Fax; ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><?php echo "DATE " .$dateInvoice;?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:Book Antiqua;font-size:16px;"><strong><u>BENEFICIARY' S  STATEMENT</u></strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="249">INVOICE NO</td>
    <td width="49" colspan="3"><?php echo $invoiceNo;?></td>
    <td width="241"></td>
  </tr>
   
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>QUANTITY</td>
    <td width="149"><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity')?> PCS</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td>L/C NO</td>
    <td colspan="4"><?php echo $dataholder['LCNO'];?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">WE HEREBY CERTIFY THAT ONE COMPLETE SET OF ALL DOCUMENTS,  INCLUDING</td>
  </tr>
  <tr>
    <td colspan="5"> COPIES OF THE BILL OF LADING, COMMERCIAL INVOICE, AND PACKING LIST </td>
  </tr>
  <tr>
    <td colspan="5">WERE SENT TO  BEATRICE VUONG VIA E-MAIL AT BVUONG@HYBRIDAPPAREL.COM AND </td>
  </tr>
  <tr>
    <td colspan="5">ONE SET WAS SENT  VIA CARRIER TO EXPEDITORS INTERNATIONAL, 5757W, CENTURY BLVD., </td>
  </tr>
  <tr>
    <td colspan="5">SUITE  200, LOS ANGELES, CA 90045, ATTN : JUN OR JACQUELINE, TEL : 310-343-6664.</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:Book Antiqua;font-size:20px;"><strong>ORIT TRADING LANKA (PVT) LTD</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><strong>Commercial Manager</strong></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
</body>
</html>