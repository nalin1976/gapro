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
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>FORM &quot;B&quot;</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body class="body_bound">
<table width="800" border="0" cellspacing="0" cellpadding="0" style="font-family:Verdana;font-size:14px;line-height:18px;">
  <tr>
    <td>&nbsp;</td>
    <td style="font-family:Verdana;font-size:25px;line-height:25px;text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="font-family:Verdana;font-size:25px;line-height:25px;text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="font-family:Verdana;font-size:25px;line-height:25px;text-align:center"><strong><u>FORM  &quot; B &quot;</u></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>The Secretary -General</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>The Ceylon Chamber of Commerce</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>50, Nawam Mawatha</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Colombo 02.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table cellspacing="0" cellpadding="0">
      <tr>
        <td width="58">Dear Sir</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>We enclose a copy of the Certificate of Origin/Invoices relating to the shipment</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>details as set out below.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2" style="font-family:Verdana;font-size:14px;line-height:18px;">
      <tr>
        <td width="20%" class="border-Left-Top-right-fntsize12"><strong>ITEM EXPORTED</strong></td>
        <td width="20%" class="border-top-right-fntsize12"><strong>QUANTITY</strong></td>
        <td width="20%" class="border-top-right-fntsize12"><strong>MARKS &amp; NOS</strong></td>
        <td width="20%" class="border-top-right-fntsize12" nowrap="nowrap"><strong>VESSEL &amp; SAILING DATE</strong></td>
        <td width="20%" class="border-top-right-fntsize12"><strong>DESTINATION</strong></td>
      </tr>
      <tr>
        <td class="border-Left-Top-right-fntsize12">&nbsp;</td>
        <td class="border-top-right-fntsize12">&nbsp;</td>
        <td class="border-top-right-fntsize12">&nbsp;</td>
        <td class="border-top-right-fntsize12">&nbsp;</td>
        <td class="border-top-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top" class="border-left-right-fntsize12" height="350"><?php  echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?></td>
        <td valign="top" class="border-right-fntsize12">
		<?php echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?> CTNS<br />
		<?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity')." ".$r_summary->summary_string($invoiceNo,'strUnitID');?><br />
        <br /><br /><br />G.WT:<br /><?php echo number_format($dataholder['gross'],2);?> Kgs.<br />
        <br /> N.WT:<br />
         <?php echo number_format($dataholder['net'],2);?> Kgs.</td>
        <td valign="top" class="border-right-fntsize12">AS PER INVOICE</td>
        <td valign="top" class="border-right-fntsize12"><?php echo $dataholder['strCarrier']." ".$dataholder['strVoyegeNo'];?><br />OF<br /><?php echo $dateInvoice ;?></td>
        <td valign="top" class="border-right-fntsize12"><?php echo $dataholder['city'];?></td>
        </tr>
      <tr>
        <td colspan="5" class="border-top">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>We hereby certify that the particulars set out above are correct and that the item</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>exported has been produced/manufactured in Sri Lanka</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>We hereby undertake to indemnify the Ceylon Chamber of Commerce for any</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>damages it may incur signing the above document.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Yours faithfully,</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>..................................</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="95%">Date, Company Stamp &amp; Signature of Exporter / Agent</td>
  </tr>
</table>
</body>
</html>