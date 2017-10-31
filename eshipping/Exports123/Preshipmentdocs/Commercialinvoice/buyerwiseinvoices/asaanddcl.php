<?php 
session_start();
$invoiceNo=$_GET['InvoiceNo'];	
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$Com_TinNo=$xmldoc->companySettings->TinNo;
include "../../../../Connector.php";
include "invoice_queries.php";
include "common_report.php";
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>ASA &amp; DCL</title>
</head>

<body class="body_bound">
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="95%"><table cellspacing="0" cellpadding="0" class="normalfnt" width="100%" >
      <tr>
        <td height="49" colspan="10" class="head2">APPENDIX I</td>
      </tr>
      <tr>
        <td height="25" colspan="10" class="normalfnt2bldBLACKmid"><u>ASA &amp; DCL    (AFTER SHIPMENT ADVICE &amp; DOCUMENT CHECK LIST)</u></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td height="25" colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="6">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" colspan="3"><strong>TO</strong></td>
        <td>:</td>
        <td colspan="6"><strong><?php echo $dataholder['BuyerAName'];?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="3"></td>
        <td></td>
        <td colspan="6"><strong><?php echo $dataholder['buyerAddress1'];?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="3"></td>
        <td></td>
        <td colspan="6"><strong><?php echo $dataholder['buyerAddress2'];?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="3"></td>
        <td></td>
        <td colspan="6"><strong><?php echo $dataholder['BuyerCountry'];?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="3"></td>
        <td></td>
        <td colspan="6"><strong><?php echo $billtovatno;?></strong></td>
      </tr>
      <tr>
        <td height="25" colspan="3"><strong>ATTN</strong></td>
        <td>:</td>
        <td colspan="6"><?php echo $dataholder['BuyerContactPerson'];?></td>
      </tr>
      <tr>
        <td height="25" colspan="3"><strong>FROM</strong></td>
        <td>:</td>
        <td colspan="6"><?php echo $dataholder['CustomerName'];?></td>
      </tr>
      <tr>
        <td height="25" colspan="3"><strong>DATE</strong></td>
        <td>:</td>
        <td colspan="6"><?php echo $dateInvoice ;?></td>
      </tr>
      <tr>
        <td colspan="3 "  height="22"><strong>INVOICE    NO   </strong></td>
        <td>:</td>
        <td colspan="6"><?php echo $dataholder['strInvoiceNo'];?>  <strong>ISD/STYLE  NO:
          <?php  echo $r_summary->summary_string($invoiceNo,'strISDno');?>
        
        
          /          
          
          <?php  echo $r_summary->summary_string($invoiceNo,'strStyleID');?>
        </strong></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td height="30" colspan="3"><strong>RE</strong></td>
        <td>:</td>
        <td colspan="6"><strong>SHIPPING DETAILS AND    DOCUMENT CHECK LIST</strong></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" class="border-All">PART A : SHIPMENT DETAILS(TO    BE COMPLETED BY CONTRACTORS)</td>
        <td colspan="4"  class="border-top-bottom-right">FILL    IN THE DETAILS WHERE APPLICABLE</td>
        <td  class="border-top-bottom-right">PART B : DOCUMENT CHECK LIST (TO BE COMPLETED BYCONTRACTORS)</td>
        <td width="206"  class="border-top-bottom-right">FILL IN THE DETAILS AND MARK (X) WHERE APPLICABLE</td>
      </tr>
      <tr>
        <td height="23" colspan="4">CONTRACTOR    NAME:  </td>
        <td colspan="4" class="border-bottom">&nbsp;</td>
        <td>SHIPMENT NO</td>
        <td width="206" class="border-bottom">&nbsp;</td>
      </tr>
      <tr>
        <td height="23" colspan="4">PLANT    NO.</td>
        <td colspan="4" class="border-bottom">&nbsp;</td>
        <td>INVOICE NO.</td>
        <td width="206" class="border-bottom"><?php echo $dataholder['strInvoiceNo'];?></td>
      </tr>
      <tr>
        <td height="23" colspan="4">PO    NO.</td>
        <td colspan="4" class="border-bottom"><?php  echo $r_summary->summary_string($invoiceNo,'strBuyerPONo');?></td>
        <td>INVOICE  VALUE</td>
        <td width="206" class="border-bottom"><?php echo "$".number_format($r_summary->summary_sum($invoiceNo,'dblAmount'),2);?></td>
      </tr>
      <tr>
        <td height="23" colspan="4">CRD    DATE</td>
        <td colspan="4" class="border-bottom">&nbsp;</td>
        <td>INVOICE DATE</td>
        <td width="206" class="border-bottom"><?php echo $dateInvoice ;?></td>
      </tr>
      <tr>
        <td height="23" colspan="4">VESSEL    ON BOARD DATE</td>
        <td colspan="4" class="border-bottom"><?php echo $dataholder['dtmSailingDate'];?></td>
        <td>CARGO RECEIPT NO.</td>
        <td width="206" class="border-bottom"><?php echo $com_inv_dataholder['strFCR'];?></td>
      </tr>
      <tr>
        <td height="25" colspan="4">FLIGHT    DATE / ETA DATE</td>
        <td colspan="4" class="border-bottom"><?php echo $dataholder['dtmETA'];?></td>
        <td>B/L NO.</td>
        <td width="206" class="border-bottom"><?php echo $com_inv_dataholder['strBL'];?></td>
      </tr>
      <tr>
        <td height="23" colspan="4">PAY    MODE (LC/TT/BY CHEQUE)</td>
        <td colspan="4" class="border-bottom"><?php echo $dataholder['strPayTerm'];?></td>
        <td>AWB NO.</td>
        <td width="206" class="border-bottom"><?php echo $com_inv_dataholder['strHAWB'];?></td>
      </tr>
      <tr>
        <td height="23" colspan="4">Payment    Due Date</td>
        <td colspan="4" class="border-bottom"><?php //echo $dataholder['dtmLCDate'];?></td>
        <td></td>
        <td width="206"></td>
      </tr>
      <tr>
        <td height="23" colspan="4">L/C    No.</td>
        <td colspan="4"><?php // echo $dataholder['LCNO'];?></td>
        <td></td>
        <td width="206"></td>
      </tr>
      <tr>
        <td width="121"></td>
        <td width="64"></td>
        <td width="1"></td>
        <td width="8"></td>
        <td width="130"></td>
        <td width="53"></td>
        <td width="30"></td>
        <td width="4"></td>
        <td width="186"></td>
        <td width="206"></td>
      </tr>
      <tr>
        <td colspan="4" class="border-All">PART    C : DISCREPANCIES ( TO BE COMPLETED BY CONTRACTORS)</td>
        <td colspan="4" class="border-top-bottom-right">FILL IN THE DETAILS AND MARK (X) WHERE APPLICABLE</td>
        <td colspan="2" class="border-top-bottom-right">PART D : AIR SEA DIFFERENCE COMPUTATION (WHEN CONTRACTORS IS    RESPONSIBLE FOR PART OR ALL OF SEA/SEA FREIGHT DIFFERENCE)(TO BE COMPLETED BY LOGISTICS)</td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td colspan="4" rowspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="23" colspan="4">EARLY/LATE    SHIPMENT</td>
        <td>TOTAL CBM OF    MERCHANDISE</td>
        <td width="206"  class="border-bottom">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" height="23">OVER-SHIPPED    BY NO. OF PCS</td>
        <td width="130" class="border-bottom">&nbsp;</td>
        <td width="53"  class="border-bottom">(</td>
        <td width="30"  class="border-bottom">%)</td>
        <td width="4">&nbsp;</td>
        <td>A)    OCEAN FREIGHT </td>
        <td width="206" class="border-bottom">US$</td>
      </tr>
      <tr>
        <td colspan="4" height="23">SHORT-SHIPPED    BY NO. OF PCS</td>
        <td width="130"  class="border-bottom">&nbsp;</td>
        <td width="53"  class="border-bottom">(</td>
        <td width="30"  class="border-bottom">%)</td>
        <td width="4">&nbsp;</td>
        <td> (CBM ** x RATE/CBM) </td>
        <td width="206" class="border-bottom">&nbsp;</td>
      </tr>
      <tr>
        <td height="23" colspan="4" nowrap="nowrap">SHIPPED   BY AIR INSTEAD OF SEA</td>
        <td height="23" colspan="3"  class="border-bottom">&nbsp;</td>
        <td height="23" >&nbsp;</td>
        <td>B)    AIR  FREIGHT</td>
        <td width="206" class="border-bottom">US$</td>
      </tr>
      <tr>
        <td colspan="4" height="23">AIR    AT CONTRACTOR’S A/C.</td>
        <td colspan="2"  class="border-bottom">&nbsp;</td>
        <td width="30"  class="border-bottom">%</td>
        <td width="4">&nbsp;</td>
        <td>&nbsp;(CHARGEABLE   WT x RATE)</td>
        <td  class="border-bottom">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" height="23">AIR    AT DIVISION’S A/C.</td>
        <td colspan="2" class="border-bottom">&nbsp;</td>
        <td width="30" class="border-bottom">%</td>
        <td width="4">&nbsp;</td>
        <td>B-A    = SEA &amp; AIR DIFFERENCE</td>
        <td width="206" class="border-bottom">US$</td>
      </tr>
      <tr>
        <td colspan="4" height="23">AIR    AT MILL’S A/C..</td>
        <td colspan="2" class="border-bottom">&nbsp;</td>
        <td width="30" class="border-bottom">%</td>
        <td width="4">&nbsp;</td>
        <td></td>
        <td width="206" class="border-bottom">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" height="23">PARTIAL    SHIPMENT (CONTR #)</td>
        <td colspan="4" class="border-bottom">&nbsp;</td>
        <td>COMMENT BY    MERCHANDISING</td>
        <td width="206"></td>
      </tr>
      <tr>
        <td colspan="4" height="23">OTHERS </td>
        <td colspan="4">&nbsp;</td>
        <td></td>
        <td width="206"></td>
      </tr>
      <tr>
        <td width="121"></td>
        <td width="64"></td>
        <td width="1"></td>
        <td width="8"></td>
        <td colspan="4"></td>
        <td width="186"></td>
        <td width="206"></td>
      </tr>
      <tr>
        <td colspan="7" class="border-top-bottom">&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="2" class="border-top-bottom">** (LxWxH/61,023.378)    x No Of Ctns)</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="8" height="23">&nbsp;</td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="8" height="23" class="border-All"><strong>PART E: TO BE VALIDATED BY LOGISTICS</strong></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td width="121"></td>
        <td width="64"></td>
        <td width="1"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" height="23">&nbsp;</td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" height="23">NAME :</td>
        <td colspan="4">CHANDANA FERNANDO </td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td width="121"></td>
        <td width="64"></td>
        <td width="1"></td>
        <td></td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td width="121"></td>
        <td width="64"></td>
        <td width="1"></td>
        <td></td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td width="121"></td>
        <td width="64"></td>
        <td width="1"></td>
        <td></td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" height="23">&nbsp;</td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" height="23">&nbsp;</td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" height="23">&nbsp;</td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" height="23">DATE :</td>
        <td colspan="4"><?php echo $dateInvoice ;?></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td width="121"></td>
        <td width="64"></td>
        <td width="1"></td>
        <td></td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="4" height="23">REMARKS:</td>
        <td colspan="4"></td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>