<?php 
session_start();
include "Connector.php";
$xmldoc=simplexml_load_file('config.xml');
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
<link href="css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PRE-INVOICE</title>
</head>

<body>
<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size10" style="text-align:left" bgcolor="" height="10">
    	<table>
        	<tr>
            	<td>
                	<?php echo $Company; ?> <br /> <?php echo $Address; ?> <br /> <?php echo $City; ?>
                </td>
            </tr>
        </table>
    
    </td>
  </tr>
  <tr>
  	<td style="text-align:center; font-size:24px;"><b>COMMERCIAL INVOICE</b></td>
  </tr>
  
   <tr>
  	<td style="text-align:left;">
    
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="normalfnt_size12">
        	<tr>
            	<td class="border-top-left" >Purchaser/ Invoice to :</td>
                <td class="border-top-left">Invoice No :</td>
                <td class="border-Left-Top-right">Invoice Date :</td>
            </tr>
            <tr>
            	<td class="border-left">&nbsp;</td>
                <td class="border-top-left">Contact :</td>
                <td class="border-top-right">&nbsp;</td>
            </tr>
            <tr>
            	<td class="border-left">&nbsp;</td>
                <td class="border-top-left">DPO No :</td>
                <td class="border-Left-Top-right">Commitment No :</td>
            </tr>
            <tr>
            	<td class="border-left">&nbsp;</td>
                <td class="border-top-left">Terms of Sale :</td>
                <td class="border-Left-Top-right">Payment Method :</td>
            </tr>
            <tr>
            	<td class="border-left border-bottom">&nbsp;</td>
                <td class="border-top-left border-bottom">Country of Origin :</td>
                <td class="border-Left-Top-right border-bottom">L/C No :</td>
            </tr>
 
        </table>
    
    </td>
  </tr>
  <tr>
  		<td>&nbsp;</td>
  </tr>
  <tr>
  		<td>Ship to address :</td>
  </tr>
  <tr>
  		<td>&nbsp;</td>
  </tr>
  <tr>
  		<td>Exporter address :</td>
  </tr>
  <tr>
  		<td>&nbsp;</td>
  </tr>
  <tr>
  		<td>&nbsp;</td>
  </tr>
  <tr>
  	<td style="text-align:left;">
    
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="normalfnt_size12">
        	
            <tr>
            	<td class="border-top-left" >Port of Loading :</td>
                <td class="border-top-left border-right">Ship Mode :</td>
            </tr>
            <tr>
            	<td class="border-top-left border-bottom">Final Destination :</td>
                <td class="border-top-left border-bottom border-right">Shipment Date :</td>
            </tr>
           
        </table>
    
    </td>
  </tr>
  <tr>
  		<td>&nbsp;</td>
  </tr>
  <tr>
  		<td style="font-size:18px"><u><b>Description of Goods :</b></u></td>
  </tr>
   <tr>
  		<td>&nbsp;</td>
  </tr>
   <tr>
  		<td>Tariff Number (HTS Code) :</td>
  </tr>
   <tr>
  		<td>Fabric Content :</td>
  </tr>
   <tr>
  		<td>Quota Category (if applicable) :</td>
  </tr>
   <tr>
  		<td>Brief Description :</td>
  </tr>
   <tr>
  		<td>Full Style Description :</td>
  </tr>
   <tr>
  		<td>COLOR :</td>
  </tr>
   <tr>
  		<td>Discount Statement :</td>
  </tr>
  <tr>
  		<td>&nbsp;</td>
  </tr>
  <tr>
  	<td style="text-align:center;">
    
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="normalfntMid">
        	
            <tr>
            	<td width="20%" rowspan="2" class="border-top-bottom-left normalfntMid">Style #</td>
                <td width="15%" rowspan="2" class="border-top-bottom-left normalfntMid">Prepack #</td>
                <td colspan="2" class="border-top-bottom-left normalfntMid">Quantity (Units)</td>
                <td width="16%" rowspan="2" class="border-top-bottom-left normalfntMid">Total Quantity (units)</td>
                <td width="16%" rowspan="2" class="border-top-bottom-left normalfntMid">Unit Price (USD$)</td>
                <td width="16%" rowspan="2" class="border-Left-bottom-right border-top normalfntMid">Extended Price (USD$)</td>
            </tr>
             <tr>
            	<td width="9%" class="border-Left-bottom-right normalfntMid">Prepack</td>
                <td width="8%" class="border-bottom normalfntMid">Bulk</td>
            </tr>
            
        </table>
    
    </td>
  </tr>
</table>