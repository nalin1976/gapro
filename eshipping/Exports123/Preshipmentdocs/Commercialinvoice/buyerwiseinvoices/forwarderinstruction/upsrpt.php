<?php 
session_start();
include "../../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../../../config.xml');
include "../common_report.php";
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

$invoiceNo=$_GET['InvoiceNo'];
include "../invoice_queries.php";

$type=($_GET['type']==""? "FOB":$_GET['type']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>COMMERCIAL INVOICE</title>
<link href="../../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="985" border="0" cellspacing="0" cellpadding="1" align="center">
    <tr>
      <td colspan="2" class="normalfnt_size10">&nbsp;</td>
    </tr>
    <tr>
   		<td colspan="2" class="normalfnt_size10"><b>&nbsp;UPS Supply Chain Solutions <sup>SM</sup></b></td>
    </tr>
    <tr>
        <td width="893" class="normalfnt_size10" style="text-align:center"><span style="font-size:16px"><b>Air Freight Shipper's Letter of Instruction</b></span><br />
        <span class="normalfnt-center_size12">All Shippers tendering air freight shipments destined for or transiting the United States<br />
        are strongly recommended to complete this form</span></td>
    	<td width="88" class="normalfnt_size10"><img src="../../../../../images/ups.png" width="70" height="85" /></td>
    </tr>
    <tr>
      <td class="normalfnt_size10" style="text-align:center">&nbsp;</td>
      <td class="normalfnt_size10">&nbsp;</td>
    </tr>
   
    <tr>
    	<td colspan="2" class="normalfnt_size10" style="text-align:center">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" width="16" class="border-top-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="border-top-fntsize10" style="text-align:right">&nbsp;SHIPPER :&nbsp;</td>
    <td colspan="4" class="border-top-fntsize10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $Company; ?>.
                   </td>
    <td width="10" class="border-top-fntsize10">&nbsp;</td>
    <td width="8" class="border-top-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;SHIPPER NO</td>
    </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="normalfnt_size10">&nbsp;</td>
    <td colspan="4" class="normalfnt_size9">(AS TO APPEAR ON THE AWB) Under U.S. CBP advance Manifest Rute, Shipper may not be a freight forwarder or consolidator</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
    </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="normalfnt_size10">&nbsp;</td>
    <td colspan="4" class="normalfnt_size9">&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="normalfnt_size10" style="text-align:right">&nbsp;ADDRESS :&nbsp;</td>
    <td colspan="4" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $Address; ?></td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;SHIPPER REFERENCE</td>
  </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="normalfnt_size10">&nbsp;</td>
    <td colspan="4" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $City; ?>.</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="normalfnt_size10">&nbsp;</td>
    <td colspan="4" class="normalfnt_size9">Under U.S. CBP Advance Manifest Rute, Shipper Address may not be located in the U.S. or be a P.O. Box</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;CUSTOMER REFERENCE</td>
  </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="normalfnt_size10">&nbsp;</td>
    <td colspan="4" class="normalfnt_size9">&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="3" class="border-left-fntsize10" style="text-align:right">&nbsp;TELEPHONE :&nbsp;</td>
    <td width="291" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $phone; ?></td>
    <td width="96" class="normalfnt_size10" style="text-align:right">&nbsp;&nbsp;FAX :</td>
    <td width="255" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted" >&nbsp;<?php echo $Fax; ?></td>
    <td width="82" class="normalfnt_size9">&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" rowspan="10" class="border-Left-Top-right-fntsize10"><table width="100%" border="0" cellspacing="3" cellpadding="0">
      <tr>
        <td>&nbsp;P.O. NUMBER</td>
      </tr>
      <tr>
        <td style="border-bottom:dotted" class="normalfnth2B">&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo'); ?></td>
      </tr>
      <tr>
        <td style="border-bottom:dotted">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-bottom:dotted">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-bottom:dotted">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-bottom:dotted">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-bottom:dotted">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-bottom:dotted">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      </table></td>
  </tr>
  <tr>
    <td height="20" colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" style="text-align:right">&nbsp;</td>
    <td class="normalfnt_size10"  >&nbsp;</td>
    <td class="normalfnt_size9">&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
   <tr>
    <td height="20" class="border-top-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="border-top-fntsize10">&nbsp;CONSIGNEE :&nbsp;</td>
    <td colspan="4" class="border-top-fntsize10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BuyerName; ?>.
       
       </td>
    <td class="border-top-fntsize10">&nbsp;</td>
    <td class="border-top-fntsize10">&nbsp;</td>
    </tr>
   <tr>
     <td class="border-left-fntsize10">&nbsp;</td>
     <td colspan="2" class="normalfnt_size10 normalfnth2B"></td>
     <td colspan="4" class="normalfnt_size9">(AS TO APPEAR ON THE AWB) Name of party to whom cargo will be deliverde. Under U.S. CBP Advance Manifest Rute. Consignee may not be s freight forwarder of customs broker.</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td colspan="2" style="text-align:right" class="normalfnt_size10">&nbsp;ADDRESS :&nbsp;</td>
     <td colspan="4" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BuyerAddress1; ?></td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td colspan="2" class="normalfnt_size10">&nbsp;</td>
     <td colspan="4" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BuyerAddress2; ?>,<?php echo $BuyerCountry; ?>.</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td colspan="2" class="normalfnt_size10">&nbsp;</td>
     <td colspan="6" class="normalfnt_size9">Under U.S. CBP Advance Manifest Rule, Cnee. Address for U.S. HAWB destination cargo must be located in U.S & may not be a P.O.Box</td>
     </tr>
   <tr>
     <td  height="20" class="border-left-fntsize10">&nbsp;</td>
     <td colspan="2" class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     </tr>
   <tr>
     <td height="20" colspan="3" class="border-left-fntsize10" style="text-align:right">&nbsp;TELEPHONE :&nbsp;</td>
     <td class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BuyerPhone;?></td>
     <td class="normalfnt_size10" style="text-align:right">&nbsp;&nbsp;FAX :</td>
     <td class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BuyerFax;?></td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td colspan="2" class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     </tr>
   <tr>
     <td class="border-top-left-fntsize10">&nbsp;</td>
     <td colspan="8" class="border-top-fntsize10">&nbsp;</td>
     <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;</td>
   </tr>
   <tr>
     <td height="20" colspan="9" class="border-top-left-fntsize10">&nbsp;IN THE CASE OF LETTER OF CREDIT SHIPMENTS TC THE U.S. PLEASE CONFIRM THE NOTIFY PARTY FOR CBP AIR AMS COMPLIANCF</td>
     <td colspan="3" class="border-left-right-fntsize10">&nbsp;CARGO READY DATE:</td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td colspan="3" class="border-left-right-fntsize10 normalfnth2B">&nbsp;<?php echo $dateETA; ?></td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td width="16" class="normalfnt_size10">&nbsp;</td>
     <td width="65" class="normalfnt_size10" style="text-align:right">NOTIFY&nbsp;&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10" style="text-align:right">&nbsp;PARTY :&nbsp;</td>
      
     <td colspan="4" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BrokerName; ?></td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td colspan="3" class="border-Left-Top-right-fntsize9" style="font-size:8px">&nbsp;WE THE SHIPPER HAVE</td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td colspan="3" class="border-left-right-fntsize9" style="font-size:8px">&nbsp;FORWARDED TO YOU THE</td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td colspan="2" class="normalfnt_size10" style="text-align:right">&nbsp;ADDRESS :&nbsp;</td>
     <td colspan="4" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BrokerAddress1; ?></td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td colspan="3" class="border-left-right-fntsize9" style="font-size:8px">&nbsp;SHIPMENT DESCRIBED</td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td colspan="4" class="normalfnt_size10 normalfnth2B" style="border-bottom:dotted">&nbsp;<?php echo $BrokerAddress2; ?><?php echo $BrokerCountry; ?></td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td width="52" class="border-left-fntsize10" style="font-size:8px">&nbsp;BY TRUCK</td>
     <td width="23" class=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
       <tr>
         <td width="23"><table width="100%" border="0" cellspacing="1" cellpadding="0">
       <tr>
         <td width="23" class="bcgl1txt1">&nbsp;</td>
       </tr>
     </table></td>
       </tr>
     </table></td>
     <td width="69" class="border-right-fntsize9" style="font-size:8px">&nbsp;REFERENCE NO</td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="border-left-fntsize10" style="font-size:8px">&nbsp;</td>
     <td >&nbsp;</td>
     <td class="border-right-fntsize9" style="font-size:8px">&nbsp;</td>
   </tr>
   <tr>
     <td height="20" class="border-left-fntsize10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td class="normalfnt_size10">&nbsp;</td>
     <td width="52" class="border-left-fntsize10" style="font-size:8px">&nbsp;OTHER</td>
     <td width="23" class=""><table width="100%" border="0" cellspacing="2" cellpadding="0">
       <tr>
         <td class="bcgl1txt1">&nbsp;</td>
       </tr>
     </table></td>
     <td width="69" class="border-right-fntsize9"><table width="100%" border="0" cellspacing="3" cellpadding="0">
       <tr>
         <td style="border-bottom:dotted">&nbsp;</td>
       </tr>
     </table></td>
   </tr>
   <tr height="5">
     <td height="20" colspan="5" class="border-top-left-fntsize10"><table width="100%" border="0" cellspacing="3" cellpadding="0">
       <tr>
         <td width="3%" height="14">&nbsp;</td>
         <td width="4%" class="bcgl1txt1">&nbsp;</td>
         <td width="5%">&nbsp;</td>
         <td width="22%" class="normalfnt_size9">CONSOLIDATE</td>
         <td width="4%" class="bcgl1txt1">&nbsp;</td>
         <td width="3%">&nbsp;</td>
         <td width="16%">DIRECT</td>
         <td width="19%" class="normalfnt_size9">SERVICE LEVEL</td>
         <td width="24%" class="normalfnt_size9" style="border-bottom:dotted">&nbsp;</td>
       </tr>
     </table></td>
     <td colspan="7" class="border-Left-Top-right-fntsize10"><table width="100%" border="0" cellspacing="3" cellpadding="0">
       <tr>
         <td width="28%" class="normalfnt_size9">SHIPPER MUST CHECK:</td>
         <td width="4%" class="bcgl1txt1">&nbsp;</td>
         <td width="12%" class="normalfnt_size9">PREPAID</td>
         <td width="4%" class="bcgl1txt1">&nbsp;</td>
         <td width="12%" class="normalfnt_size9">COLLECT</td>
         <td width="4%" class="bcgl1txt1">&nbsp;</td>
         <td width="22%">&nbsp;C.O.D. AMOUNT</td>
         <td width="14%" style="border-bottom:dotted">&nbsp;</td>
       </tr>
     </table></td>
     </tr>
   <tr>
     <td height="20" class="border-top-left-fntsize10">&nbsp;</td>
     <td height="20" colspan="3" class="border-top-fntsize10">ORIGIN AIRPORT :&nbsp;<b><?php echo $PortOfLoading; ?></b></td>
     <td class="border-top-fntsize10">&nbsp;</td>
     <td height="20" colspan="7" class="border-Left-Top-right-fntsize10"><table width="100%" border="0" cellspacing="3" cellpadding="0">
       <tr>
         <td width="28%" class="normalfnt_size9">PLACE OF RECEIP:</td>
         <td width="4%" class="bcgl1txt1">&nbsp;</td>
         <td width="12%" class="normalfnt_size9">&nbsp;</td>
         <td width="4%">&nbsp;</td>
         <td width="12%" class="normalfnt_size9">&nbsp;</td>
         <td width="4%" >&nbsp;</td>
         <td width="22%">&nbsp;</td>
         <td width="14%" >&nbsp;</td>
       </tr>
     </table></td>
     </tr>
   <tr>
     <td class="border-top-left-fntsize10">&nbsp;</td>
     <td colspan="3" class="border-top-fntsize10">DESTINATION AIRPORT : &nbsp;<b><?php echo $Destinationport; ?></b></td>
     <td class="border-top-fntsize10">&nbsp;</td>
     <td colspan="7" class="border-Left-Top-right-fntsize10"><table width="100%" border="0" cellspacing="3" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</td>
   </tr>
   <tr>
     <td colspan="12" class="border-Left-Top-right-fntsize10"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td height="13" colspan="2" class="normalfnt_size9">&nbsp;TENDERED QUANTITY</td>
         <td colspan="2" class="border-left-fntsize9" style="text-align:center">MANIFEST QUANTITY<BR /><span style="font-size:8px">U.S.CBP Advance Manifest Rufe<br />requlres smallest externam pkg level</span></td>
         <td width="99" class="border-left-fntsize9" style="text-align:center">GROSS WT.<BR />(KG)</td>
         <td width="92" class="border-left-fntsize9" style="text-align:center" >DIMENSIONS<BR />LXWXH&nbsp;&nbsp;(CM)</td>
         <td width="368" class="border-left-fntsize9" style="text-align:center">PRECISE DESCRIPTION OF GOODS<BR /><span style="font-size:8px">Subject U.S CDP Advance Manifest Rufe guidelines</span></td>
         <td width="138" class="border-left-fntsize9" style="text-align:center">HTS NUMBER<BR /><span style="font-size:8px">(optional)</span></td>
       </tr>
       <tr>
         <td width="77" class="border-top-fntsize10">&nbsp;</td>
         <td width="65" class="border-top-left-fntsize9">&nbsp;</td>
         <td width="90" class="border-top-left-fntsize9" style="vertical-align:text-top; text-align:right">&nbsp;<b><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity'); ?></b></td>
         <td width="62" class="border-top-left-fntsize9">&nbsp;</td>
         <td  class="border-top-left-fntsize9" style="text-align:right; vertical-align:text-top"><b><?php  echo $r_summary->summary_sum($invoiceNo,'dblGrossMass');?></b></td>
         <td  class="border-top-left-fntsize9">&nbsp;</td>
         <td  class="border-top-left-fntsize9"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       
              <tr>
                <td>
                <b><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity'); ?>&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strUnitID'); ?>&nbsp;OF&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strDescOfGoods'); ?>&nbsp;IN&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strFabric'); ?>
                <br /><br />
                PO NO :&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strBuyerPONo'); ?><br /><br />
                STYLE :&nbsp;<?php echo $r_summary->summary_string($invoiceNo,'strStyleID'); ?></b>
                </td>
              </tr>
       
  </table>
</td>
         <td class="border-top-left-fntsize9">&nbsp;</td>
       </tr>
     </table></td>
     </tr>
   <tr>
     <td colspan="12" class="border-All-fntsize9"><table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
         <td height="20" width="292" class="normalfnt_size9">&nbsp;INCOTERMS :</td>
         <td width="346" class="border-left-fntsize9" style="text-align:center"><u>SPECIAL INSTRUCTIONS</u></td>
         <td width="340" class="border-left-fntsize9"><table width="100%" border="0" cellspacing="2" cellpadding="0">
           <tr>
             <td width="50%" class="normalfnt_size9">&nbsp;HAZARDOUS MATERIALS:</td>
             <td width="6%" class="bcgl1txt1">&nbsp;</td>
             <td width="16%" class="normalfnt_size9">YES</td>
             <td width="6%" class="bcgl1txt1">&nbsp;</td>
             <td width="22%" class="normalfnt_size9">NO</td>
           </tr>
         </table></td>
       </tr>
       <tr>
         <td height="20" class="border-top-fntsize10">&nbsp;FREIGHT PAYABLE AT:</td>
         <td width="346" rowspan="3" class="border-left-fntsize9"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
             <td style="border-bottom:dotted">&nbsp;</td>
           </tr>
           <tr>
             <td style="border-bottom:dotted" >&nbsp;</td>
           </tr>
           <tr>
             <td style="border-bottom:dotted">&nbsp;</td>
           </tr>
           <tr>
             <td style="border-bottom:dotted">&nbsp;</td>
           </tr>
           <tr>
             <td style="border-bottom:dotted">&nbsp;</td>
           </tr>
           </table></td>
         <td class="border-top-left-fntsize9">&nbsp;<U>DOCUMENTS ATTACHED.</U></td>
       </tr>
       <tr>
         <td height="20" class="border-top-fntsize10">&nbsp;VALUE FOR CARRIAFE:</td>
         <td rowspan="6" class="border-left-fntsize9"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
             <td width="9%">&nbsp;</td>
             <td width="6%" class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;COMMERCIAL INVOICE</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;PACKING LIST</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;HAZADOUS/RESTER. ARTICLE CERTIFICATE</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;CERTIFICATE OF ORIGIN</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;EXPORT LICENSE</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;CONSULAR DOCUMENTATION</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;INSURANCE CERTIFICATE</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td colspan="2">&nbsp;FUMIGATION CERTIFICATE/EXPORTER STMT</td>
             </tr>
           <tr>
             <td>&nbsp;</td>
             <td class="bcgl1txt1">&nbsp;</td>
             <td width="19%">&nbsp;OTHER:</td>
             <td width="66%" style="border-bottom:dotted">&nbsp;</td>
             </tr>
         </table></td>
       </tr>
       <tr>
         <td height="20" class="border-top-fntsize10"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
             <td colspan="2">&nbsp;SHIPPER REQUESTS INSURANCE:</td>
             <td width="7%" class="bcgl1txt1">&nbsp;</td>
             <td width="8%">YES</td>
             <td width="7%" class="bcgl1txt1">&nbsp;</td>
             <td width="10%">NO</td>
             </tr>
           <tr>
             <td width="24%">&nbsp;AMOUNT :</td>
             <td colspan="3" style="border-bottom:dotted">&nbsp;</td>
             <td colspan="2" >&nbsp;</td>
             </tr>
           </table></td>
       </tr>
       <tr>
         <td height="20" colspan="2" class="border-top-fntsize10">&nbsp;IEGALIZATION - DOCUMENTS REQUIRED</td>
       </tr>
       <tr>
         <td height="20" colspan="2" class="normalfnt_size9">&nbsp;</td>
         </tr>
       <tr>
         <td height="20" colspan="2" class="border-top-fntsize10">&nbsp;PLEASE CHECK ONE :</td>
         </tr>
       <tr>
         <td colspan="2" height="20" class="normalfnt_size9"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
             <td >&nbsp;</td>
             <td width="3%" class="bcgl1txt1">&nbsp;</td>
             <td class="normalfnt_size9">&nbsp;CONTAINS NO SOLD WOOD PACKAGING MATERIALS (VENDOR TO SUBMIT EXPORTER STATEMENT)</td>
             </tr>
           <tr>
             <td width="1%">&nbsp;</td>
             <td width="3%" class="bcgl1txt1">&nbsp;</td>
             <td width="96%">&nbsp;CONTAINS SOLD WOOD PACKAGING MATERIALS (VENDOR TO SUBMIT FUMIGATION CERTIFICATE)</td>
             </tr>
           </table></td>
       </tr>
       <tr>
         <td colspan="3" class="border-top-fntsize10" style="font-size:8px">&nbsp;</td>
       </tr>
       <tr>
         <td  height="20" colspan="3" class="normalfnt_size9" style="font-size:8px">&nbsp;The undersigned duty authorized person hereby certifies that the information provided herein is true and correct acknowledges that UPS Supply Chain Solutions, Inc., UPS Air Freight Services, and their specifically authorized agents rely on accuracy of this information in preparing cargo declarations, manifests and reports or declarations to the United State as required by Law.</td>
         </tr>
       <tr>
         <td colspan="3" class="" style="font-size:8px">&nbsp;</td>
       </tr>
       <tr>
         <td colspan="3" class="normalfnt_size9"><table width="100%" border="0" cellspacing="3" cellpadding="0">
           <tr>
             <td height="20" width="6%">&nbsp;NAME :</td>
             <td width="30%" style="border-bottom:dotted">&nbsp;</td>
             <td width="10%">&nbsp;&nbsp;&nbsp;SIGNATURE :</td>
             <td width="30%" style="border-bottom:dotted">&nbsp;</td>
             <td width="6%">&nbsp;&nbsp;&nbsp;DATE :</td>
             <td width="18%" style="border-bottom:dotted">&nbsp;</td>
           </tr>
         </table></td>
         </tr>
     </table></td>
     </tr>
   
   
  
        </table>

        </td>
   	</tr>
</table>
</body>
</html>