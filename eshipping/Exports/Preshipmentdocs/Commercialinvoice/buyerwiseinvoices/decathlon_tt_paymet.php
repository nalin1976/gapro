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
		$sqlinvoiceheader="SELECT
		commercial_invoice_detail.strInvoiceNo,
		commercial_invoice_detail.strBuyerPONo,
		SUM(commercial_invoice_detail.dblAmount) AS dblAmount,
		DATE(commercial_invoice_header.dtmInvoiceDate) AS dtmInvoiceDate
		FROM
		commercial_invoice_detail
		INNER JOIN commercial_invoice_header ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
		WHERE commercial_invoice_detail.strInvoiceNo ='$invoiceNo'
		
		GROUP BY
		commercial_invoice_detail.strInvoiceNo";
	
	$idresult=$db->RunQuery($sqlinvoiceheader);
	$dataholder=mysql_fetch_array($idresult);
	
	$dateInvoice = $dataholder['dtmInvoiceDate'];
	$InvoiceNo	 = $dataholder['strInvoiceNo'];
	$PoNo		 = $dataholder['strBuyerPONo'];
	$Amount		 = $dataholder['dblAmount'];
	
	//$dateVariable = $dataholder['dtmInvoiceDate'];
	//$dateInvoice = substr($dateVariable, 0, 10); 
	//die ("$dateInvoice"); 
	//$dateLC = $dataholder['LCDate'];
	//$LCDate = substr($dateLC, 0, 10); 
	  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DECATHLON TT PAYMENT REPORT</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
.fontColor12 {FONT-SIZE:7PT; ; FONT-FAMILY:Verdana; }
.adornment10 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.fontColor121 {FONT-SIZE:21PT; ; FONT-FAMILY:Verdana; }
.fontColor10 {FONT-SIZE:9PT; ; FONT-FAMILY:Verdana; }
-->
</style>
</head>

<body>
<table width="794" border="0" align="center">
  <thead>
  <tr>
    <td colspan="3" ><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        
        <td width="66%" ><center><p class="head2BLCK">DECATHLON</p></center></td>
        </tr>
        <tr>
        <td><center>INDECA SPORTING GOODS PRIVATE LTD</center></td>
        </tr>
        <tr>
        <td><center>The Canopy, Block A, IInd Floor,P28,IInd Avenue,Mahindra World City, Natham Sub(PO)</center></td>
        </tr>
        <tr>
        <td><center>Chengalpet Taulk,Kancheepuram (Dt) - 603 002 . INDIA</center></td>
        </tr>
        <tr>
        <td><center>Tel +91.(0)44.4740.8888.</center></td>
        </tr>
        <tr>
        <td><center>Invoice Payment Control</center></td>
        </tr>
        <tr>
        <td><center>(For TT Payments only)</center></td>
        </tr>
        <tr>
        <td><center>To be filled in by the person who receives the invoice</center></td>
        </tr>
     
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" cellspacing="0">
      <tr>
        <td colspan="2" class="border-Left-Top-right-fntsize12">Vendor:</td>
        <td colspan="2" class="border-top-right-fntsize12">Invoice No &amp; Date: <?php echo $InvoiceNo." OF ".$dateInvoice ;?> </td>
        </tr>
      <tr>
        <td height="28" colspan="2" class="border-left-right-fntsize12" valign="bottom">HELA CLOTHING (PVT) LTD,</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12"> NO. 309/11, NEGOMBO ROAD,WELISARA,</td>
        <td colspan="2" class="border-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">SRI LANKA.</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">Date of Receipt of Invoice:</td>
        <td colspan="2" class="border-right-fntsize12">Date of Payment</td>
        </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-right-fntsize12" valign="bottom">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12" valign="bottom">&nbsp;</td>
        </tr>
	  <tr>
	    <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
	    <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
	    </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        </tr>
        
        
        <tr>
        <td colspan="2" class="border-Left-Top-right-fntsize12">Mode of Payment:</td>
        <td colspan="2" class="border-top-right-fntsize12">Amount &amp; Currency:</td>
        </tr>
      <tr>
        <td height="28" colspan="2" class="border-left-right-fntsize12" valign="bottom">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $Amount;?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">Dept #:</td>
        <td colspan="2" class="border-right-fntsize12">Dept. Manager (Name /Sign):</td>
        </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-right-fntsize12" valign="bottom">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12" valign="bottom">&nbsp;</td>
        </tr>
	  <tr>
	    <td colspan="2" class="border-left-right-fntsize12">PL Flow (Name / Sign):</td>
	    <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
	    </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">ARANGALLA/CHARITHA/NILAKSHI</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
 
        <tr>
        <td colspan="2" class="border-left-right-fntsize12">Reason for TT Payment- </td>
        <td colspan="2" class="border-right-fntsize12">Vendor Bank Name, A/c # &amp; SWIFT Code:</td>
        </tr>
      <tr>
        <td height="28" colspan="2" class="border-left-right-fntsize12" valign="bottom">FOB Payment for Order No: <?php echo $PoNo;?></td>
        <td colspan="2" class="border-right-fntsize12">NATIONAL DEVELOPMENT BANK LTD., NO103 A,</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right">DHARMAPALA MAWATHA, COLOMBO 7, SRI LANKA.</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">ACCOUNT NO - 500081002273 SWIFT CODE - NDBSLKLX</td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">Invoice checked &amp; Confirmed by:</td>
        <td colspan="2" class="border-right-fntsize12">Payment processing cell</td>
        </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-right-fntsize12" valign="bottom">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12" valign="bottom">&nbsp;</td>
        </tr>
	  <tr>
	    <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
	    <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
	    </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
        
        
        <tr>
        <td colspan="2" class="border-left-right-fntsize12">Payment approved by:</td>
        <td colspan="2" class="border-right-fntsize12">Jerry NOTOT</td>
        </tr>
      <tr>
        <td height="28" colspan="2" class="border-left-right-fntsize12" valign="bottom">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">Payment signed by</td>
        <td colspan="2" class="border-right-fntsize12">Jerome LE ROY</td>
        </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-right-fntsize12" valign="bottom">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12" valign="bottom">&nbsp;</td>
        </tr>
	  <tr>
	    <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
	    <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
	    </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
         <tr>
        <td colspan="2" class="border-left-right-fntsize12">Comment</td>
        <td colspan="2" class="border-right-fntsize12">Reply</td>
        </tr>
      <tr>
        <td height="29" colspan="2" class="border-left-right-fntsize12" valign="bottom">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12" valign="bottom">&nbsp;</td>
        </tr>
	  <tr>
	    <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
	    <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
	    </tr>
      <tr>
        <td colspan="2" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="2" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
        
        
     
     


    </table></td>
  </tr></thead>
  <tr>
    
  </tr>
</table>
</body>
</html>
