<?php 
session_start();
include "../../../../Connector.php";
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



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PRE-INVOICE</title>
</head>

<body>

<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfn" style="text-align:left">
	<?php echo $Company;?><br />
    <?php echo $Address;?><br />
    <?php echo $City;?><br /><br /><br />
    </td>
  </tr>
  <tr>
    <td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  			<tr>
            	<td colspan="3" style="text-align:center"><b>COMMERCIAL INVOICE</b></td>
            </tr>
            
            <tr>
            	<td width="34%" class="border-top-left">Purchaser / Invoice to :</td>
                <td width="33%" class="border-top-left">Invoice No :</td>
                <td width="33%" class="border-Left-Top-right">Invoice Date :</td>
            </tr>
            
            <tr>
            	<td rowspan="4" class="border-top-left border-bottom">&nbsp;</td>
                <td colspan="2" class="border-Left-Top-right">Contact :</td>
            </tr>
            
            <tr>
            	<td class="border-top-left">DPO No :</td>
                <td class="border-Left-Top-right">Commitment No :</td>
            </tr>
            
            <tr>
            	<td class="border-top-left">Terms of Sale :</td>
                <td class="border-Left-Top-right">Payment Method :</td>
            </tr>
            
            <tr>
            	<td class="border-top-left border-bottom">Country of Origin :</td>
                <td class="border-Left-Top-right border-bottom">L/C No :</td>
            </tr>
        </table>
    </td>
  </tr><br /><br />
  <tr>
  	<td style="text-align:left">Ship to address :<br /></td>
  </tr>
  <tr>
  	<td style="text-align:left">Exporter address :<br /></td>
  </tr>
   <tr>
  	<td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  			<tr>
            	<td width="50%" class="border-top-left">Port of Loading :</td>
                <td width="50%" class="border-Left-Top-right">Ship Mode :</td>
            </tr>
            
            <tr>
            	<td class="border-top-left border-bottom">Final Destination :</td>
                <td class="border-Left-Top-right border-bottom">Shipment Date :</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
  	<td><br /><b><u>Description of Goods :</u></b><br /><br /></td>
  </tr>
  <tr>
  	<td>Tariff Number (HTS Code) :<br /></td>
  </tr>
   <tr>
  	<td>Fabric Content :<br /></td>
  </tr>
   <tr>
  	<td>Quota Category (if applicable) :<br /></td>
  </tr>
   <tr>
  	<td>Brief Description :<br /></td>
  </tr>
   <tr>
  	<td>Full Style Description :<br /></td>
  </tr>
   <tr>
  	<td>COLOR :<br /></td>
  </tr>
   <tr>
  	<td>Discount Statement :<br /><br /></td>
  </tr>
  <tr>
  	<td><b>Set item Breakdown :</b><br /><br /></td>
  </tr>
  <tr>
  	<td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  			<tr>
            	<td width="25%" style="text-align:center" class="border-top-left"><b>Gender / item</b></td>
                <td width="20%" style="text-align:center" class="border-top-left"><b>H.S. Code No</b></td>
                <td width="12%" style="text-align:center" class="border-top-left"><b>Quantity (PCS)</b></td>
                <td width="12%" style="text-align:center" class="border-top-left"><b>Dozen</b></td>
                <td width="15%" style="text-align:center" class="border-top-left"><b>Unit Price</b></td>
                <td width="15%" style="text-align:center" class="border-Left-Top-right"><b>Total Amt</b></td>
            </tr>
            <tr>
            	<td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td style="text-align:center" class="border-left"><b>(USD$)</b></td>
                <td style="text-align:center" class="border-left-right"><b>(USD$)</b></td>
            </tr>
            <tr>
            	<td class="border-top-left border-bottom">&nbsp;</td>
                <td style="text-align:center" class="border-top-left border-bottom">&nbsp;</td>
                <td style="text-align:center" class="border-top-left border-bottom">&nbsp;</td>
                <td style="text-align:center" class="border-top-left border-bottom">&nbsp;</td>
                <td style="text-align:right" class="border-top-left border-bottom">&nbsp;</td>
                <td style="text-align:right" class="border-Left-Top-right border-bottom">&nbsp;</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="border-left-right border-bottom">&nbsp;</td>
            </tr>
        </table>
    </td>
  </tr>
  <tr>
  	<td><br /><br /></td>
  </tr>
   <tr>
  	<td>
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  			<tr>
            	<td width="25%" style="text-align:center" class="border-top-left">Style #</td>
                <td width="20%" style="text-align:center" class="border-top-left">Prepack #</td>
                <td colspan="2" class="border-top-left" style="text-align:center">Quantity (Units)</td>
                <td width="15%" style="text-align:center" class="border-top-left">Total</td>
                <td width="15%" style="text-align:center" class="border-top-left">Unit Price</td>
                <td width="15%" style="text-align:center" class="border-Left-Top-right">Extended</td>
            </tr>
            <tr>
            	<td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td width="12%" class="border-left border-top" style="text-align:center">Prepack</td>
                <td width="12%" class="border-left border-top" style="text-align:center">Bulk</td>
                <td style="text-align:center" class="border-left">Quantity</td>
                <td style="text-align:center" class="border-left">&nbsp;</td>
                <td width="15%" style="text-align:center" class="border-left-right">Price</td>
            </tr>
            <tr>
            	<td class="border-left border-bottom">&nbsp;</td>
                <td style="text-align:center" class="border-left border-bottom">&nbsp;</td>
                <td style="text-align:center" class="border-left border-bottom">&nbsp;</td>
                <td style="text-align:center" class="border-left border-bottom">&nbsp;</td>
                <td style="text-align:center" class="border-left border-bottom">(units)</td>
                <td style="text-align:center" class="border-left border-bottom">(USD$)</td>
                <td width="15%" style="text-align:center" class="border-left-right border-bottom">(USD$)</td>
            </tr>
            <tr>
            	<td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td class="border-left">&nbsp;</td>
                <td width="15%" style="text-align:center" class="border-left-right">&nbsp;</td>
            </tr>
            <tr>
            	<td colspan="2" class="border-top-bottom-left">Subtotal Prepack &amp; Bulk</td>
                <td class="border-top-bottom">&nbsp;</td>
                <td class="border-top-bottom">&nbsp;</td>
                <td class="border-top-bottom">&nbsp;</td>
                <td class="border-top-bottom">&nbsp;</td>
                <td width="15%" style="text-align:center" class="border-top-bottom border-right">&nbsp;</td>
            </tr>
        </table>
    </td>
  </tr>
</table>