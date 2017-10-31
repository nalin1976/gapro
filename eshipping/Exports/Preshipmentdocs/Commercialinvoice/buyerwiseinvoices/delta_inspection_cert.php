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
<title>DELTA BEN DEC</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body class="body_bound">
<table width="850" border="0" cellspacing="0" cellpadding="2" style="font-family:Book Antiqua;font-size:14px;">
  <tr>
    <td colspan="5" style="font-family:Constantia;font-size:48px;"><B><?php echo $dataholder['CustomerName'];?>&nbsp;Inspection Certificate</B></td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:Arial;font-size:26px;" nowrap="nowrap">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" style="font-family:Arial;font-size:26px;" nowrap="nowrap">Documentry credit no: <?php ?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="187">Date: </td>
    <td width="264">&nbsp;<?php echo $dateInvoice;?></td>
    <td colspan="2">I/C No:</td>
    <td width="251"><?php echo $invoiceNo;?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"></td>
  </tr>
  <tr>
    <td>Issuing Party Name :</td>
    <td><?php echo $dataholder['CustomerName'];?></td>
    <td colspan="2">Vendor/Factory:</td>
    <td><?php echo $dataholder['CustomerName'];?></td>
  </tr>
  <tr>
    <td>Address :</td>
    <td><?php echo $dataholder['strAddress1'];?></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $dataholder['strAddress2'];?></td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
		<td ></td>
    <td><?php echo $dataholder['CustomerCountry'];?></td>
    <td colspan="3" style="font-family:Book Antiqua;font-size:16px;">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">This is to certify that invoiced merchandise conforms to the approved production samples and all terms and conditions of the </td>
  </tr>
  <tr>
    <td colspan="5">relative purchase order of <?php echo $dataholder['CustomerName'];?>.  The merchandise shipped meets the quality specification on the order bas</td>
  </tr>
  <tr>
    <td colspan="5"></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"></td>
  </tr>
  <tr>
    <td>Commercial Invoice # :</td>
    <td colspan="4"><?php echo $invoiceNo;?></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
 
 <tr>
    <td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="33%" align="center">Purchase Order #</td>
        <td width="27%" align="center">Material #</td>
        <td width="21%"  align="right">Quantity</td>
        <td width="19%">&nbsp;</td>
      </tr>
      <?php
  	
	$totQuentity=0;
	
  	$sql = "select 	strInvoiceNo, 
			strStyleID, 
			strBuyerPONo, 
			dblQuantity
			from 
			commercial_invoice_detail 
			where strInvoiceNo='$invoiceNo' ;";
			
	$result=$db->RunQuery($sql);
	while(($row=mysql_fetch_array($result))||($count<5))
	{
		$totQuentity+=$row["dblQuantity"];
	?>
      <tr>
        <td align="center"><?php echo $row["strBuyerPONo"]; ?></td>
        <td align="center"><?php echo $row["strStyleID"]; ?></td>
        <td align="right"><?php echo $row["dblQuantity"]; ?></td>
        <td>&nbsp;</td>
      </tr>
      
      <?php
	$count++;		
	}
	?>
	<tr>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="right"><?php echo $totQuentity; ?></td>
        <td>&nbsp;PCS</td>
      </tr>
    </table></td>
  </tr>
			
	
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">This document is issued without prejudice and in no way releases the vendor or manufacturer from their responsibility with regard </td>
  </tr>
  <tr>
    <td colspan="5">to the documentation and this merchandise.</td>
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
    <td colspan="4">&nbsp;</td>
    <td class="border-top-fntsize12">Authorized Signature </td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
</body>
</html>