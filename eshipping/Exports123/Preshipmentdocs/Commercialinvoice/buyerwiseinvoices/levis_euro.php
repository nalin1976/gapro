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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>LEVIS_EURO_INVOICE</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.invoicefnt {
color:#000000;
font-family:Verdana;
font-size:10px;
font-weight:100;
margin:0;
text-align:left;
}
.invoicefntbold {
color:#000000;
font-family:Verdana;
font-size:10px;
font-weight:bold;
margin:0;
text-align:left;
}
td{
	line-height:100%
}
</style>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="920" border="0" cellspacing="0" cellpadding="1" class="normalfnt_size10">
  <tr>
    <td colspan="11" class="cusdec-normalfnt2bldBLACK" style="text-align:center">COMMERCIAL INVOICE</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>SHIPPER/EXPORTER/SELLER :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS REG# PV 64804</strong></td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Invoice No. &amp; Date </td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;Exporter's Ref </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<strong><?php echo $Company;?></strong></td>
    <td colspan="3" class="border-left-fntsize10"><?php echo $dataholder['strInvoiceNo'];?> OF <?php echo $dateInvoice ;?></td>
    <td colspan="3" class="border-left-right-fntsize10"><?php echo $dataholder['strPreInvoiceNo'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $Address;?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;Buyer's Order No &amp; Date </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $City;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;WEB TOOL ID#</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10"> &nbsp;Tel # </td>
    <td colspan="4" ><?php echo $phone;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;Fax # </td>
    <td colspan="4" ><?php echo $Fax;?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;<strong>BILL TO:</strong></td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>MANUFACTURER / SEWER NAME &amp; ADDRESS : </strong></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerName'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['CustomerName'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerAddress1'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strAddress1'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerAddress2'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strAddress2'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['BrokerCountry'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['CustomerCountry'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo ($dataholder['Brokerphone']!=""?"TEL # ".$dataholder['Brokerphone']:"");?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;MID NO : <?php echo $dataholder['strMIDCode'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;MANUF. LOCATION / CODE # <?php echo $dataholder['locationcode'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $billtovatno;?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $BrokerRemarks;?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>CONSIGNEE/ IMPORTER : </strong></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;<strong>NOTIFY PARTY / SHIP TO : </strong></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerAName'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Name'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress1'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Address1'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress2'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Address2'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerCountry'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Country'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo ($dataholder['buyerphone']!=""?"Tel # ".$dataholder['buyerphone']:"")?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo ($dataholder['notify2phone']!=""?"Tel # ".$dataholder['notify2phone']:"");?>&nbsp;<?php echo ($dataholder['notify2Fax']!=""?"Fax # ".$dataholder['notify2Fax']:"");?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo ($dataholder['BuyerFax']!=""?"Fax # ".$dataholder['BuyerFax']:"");?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $notify2ContactPerson;?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerContactPerson'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $notify2remarks;?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Country of origin of Goods</td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;Country of Final Destination</td>
  </tr>
  
  
  <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Pre-Carriage by </td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Place of Receipt by Carrier </td>
    <td colspan="3" class="border-left-fntsize10" style="text-align:center">SRI LANKA</td>
    <td colspan="3" class="border-left-right-fntsize10" style="text-align:center"><?php echo $dataholder['countrydest'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;N.A</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;N.A</td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;Terms of Delivery and Payment </td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Vessel/Flight No.</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Port of Loading</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;PAYMENT BY T.T </td>
  </tr>
   <tr>
     <td colspan="2" class="border-left-fntsize10"><?php echo $dataholder['strCarrier']." ".$dataholder['strVoyegeNo'];?></td>
     <td colspan="3" class="border-left-fntsize10"><?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></td>
     <td colspan="6" class="border-left-right-fntsize10"><strong>&nbsp;<u>OPEN A/C</u></strong></td>
   </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;Bank Details:</td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Port of Discharge</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Final Destination</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankname'];?></td>
  </tr>
   <tr>
     <td colspan="2" class="border-left-fntsize10"><?php echo $dataholder['port'];?></td>
     <td colspan="3" class="border-left-fntsize10"><?php echo $dataholder['city'];?></td>
     <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankaddress1']." ".$dataholder['bankaddress2'];?></td>
   </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankref'];?></td>
  </tr>
  
  <tr>
    <td colspan="11" class="border-Left-Top-right-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
          <td width="10%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="16%">&nbsp;</td>
          <td width="8%" >&nbsp;</td>
          <td width="6%" >&nbsp;</td>
          <td width="8%" >&nbsp;</td>
          <td width="6%">&nbsp;</td>
          <td width="8%" >&nbsp;</td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Quantity</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Rate</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Amount</span></div></td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="6" class="cusdec-normalfnt2bldBLACK" style="text-align:center"><?php echo($com_inv_dataholder['strQuality']==2?"SECOND QUALITY GARMENT":"");?></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10"style="text-align:center">PIECES</td>
        <td class="border-left-fntsize10" style="text-align:center"><?php echo $dataholder['strIncoterms'];?> UNIT</span></td>
        <td class="border-left-fntsize10" style="text-align:center"><?php echo $dataholder['strCurrency']." ". $dataholder['strIncoterms'];?></td>
      </tr>
      <tr>
        <td>BRAND </td>
        <td colspan="2">:<?php echo $com_inv_dataholder['strBrand'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10" style="text-align:center">COST <?php echo $dataholder['strCurrency'];?></td>
        <td class="border-left-fntsize10" style="text-align:center;font-size:9px"><?php echo ($dataholder['strIncoterms']=="FOB"?"Sri Lanka Int'l Air Port":$dataholder['countrydest']);?></td>
      </tr>
      <tr>
        <td>QUALITY STD </td>
        <td colspan="5">:<?php echo ($com_inv_dataholder['strQuality']==1?"1st Quality":($com_inv_dataholder['strQuality']==2?"2nd Quality":"3rd Quality"));?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>FINISH STD</td>
        <td colspan="5">:<?php echo $com_inv_dataholder['strFinishedStd'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      
      <tr>
        <td>PACKG STD</td>
        <td>:<?php echo $com_inv_dataholder['strPackStd'];?></td>
        <td class="border-top-bottom-left-fntsize10" style="text-align:center"><span class="invoicefntbold">ITEM</span></td>
        <td class="border-top-bottom-left-fntsize10" style="text-align:center"><span class="invoicefntbold">CTNS</span></td>
          <td class="border-top-bottom-left-fntsize10" style="text-align:center" nowrap="nowrap"><span class="invoicefntbold">PROD CODE #</span></td>
          <td class="border-top-bottom-left-fntsize10" style="text-align:center" nowrap="nowrap"><span class="invoicefntbold">SAP PO# (OLD PO#)</span></td>
          <td colspan="2" class="border-top-bottom-left-fntsize10" style="text-align:center"><span class="invoicefntbold">ISD # (DO#)</span></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
		 <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <?php 
	  	$str_desc="select
					strDescOfGoods,
					strBuyerPONo,
					strStyleID,
					dblQuantity,
					dblUnitPrice,
					dblAmount,
					intNoOfCTns,
					strDc,
					strISDno
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					order by strBuyerPONo";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while(($row_desc=mysql_fetch_array($result_desc))||$count<20){
		$count++;
		$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$totqty+=$row_desc["dblQuantity"];
		$totctns+=$row_desc["intNoOfCTns"];
		$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
		$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
	  ?>
     
      <tr>
        <td>&nbsp;<?php if ($bool_rec_fst==1) echo "NORMAL P/C#"; $bool_rec_fst=0;?></td>
        <td><span style="text-align:center"><?php echo $row_desc["strStyleID"];?></span></td>
        <td style="text-align:center"><?php echo $row_desc["strDescOfGoods"];?></td>
        <td style="text-align:center"><?php echo $row_desc["intNoOfCTns"];?></td>
          <td style="text-align:center" nowrap="nowrap"><span style="text-align:center"><?php echo $row_desc["strStyleID"];?></span></td>
          <td style="text-align:center"><span style="text-align:center"><?php echo $row_desc["strBuyerPONo"];?></span></td>
          <td colspan="2" style="text-align:center"><span style="text-align:center"><?php echo $row_desc["strISDno"];?></span></td>
          <td class="border-left-fntsize10" style="text-align:right"><?php echo $row_desc["dblQuantity"];?></td>
          <td class="border-left-fntsize10" style="text-align:right"><span class="normalfnt"><?php echo ($row_desc["dblQuantity"]!=""?number_format($price_dtl,2):"");?></span></td>
          <td class="border-left-fntsize10" style="text-align:right"><span class="normalfnt"><?php echo ($row_desc["dblQuantity"]!=""?number_format($amt_dtl,2):"");?></span></td>
        </tr><?php }?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:center"><strong><?php echo $totctns;?></strong></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo $totqty;?></strong></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo number_format($tot,2);?></strong></td>
        </tr>
      
      
      <tr>
        <td><strong>DC #</strong></td>
        <td colspan="2"><strong>
          <?php  echo $r_summary->summary_string($invoiceNo,'strDc');?>
        </strong></td>
        <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3"><span class="invoicefntbold">DESCRIPTION OF GOODS</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td><span class="invoicefntbold">GENDER</span></td>
        <td>&nbsp;</td>
        <td colspan="6"><strong><?php echo $com_inv_dataholder['strGender'];?></strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="invoicefntbold">FIBER CONTENT </span></td>
        <td colspan="6"><strong>
          <?php  echo $r_summary->summary_string($invoiceNo,'strFabric');?>
        </strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="invoicefntbold">GARMENT TYPE</span></td>
        <td colspan="6"><strong><?php echo $com_inv_dataholder['strGarmentType'];?></strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="invoicefntbold">CONSTN TYPE</span></td>
        <td colspan="6"><strong>
          <?php  echo  $r_summary->summary_string_concat($invoiceNo,'strFabric','strConstType','strFabric') ;?>
        </strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="invoicefntbold">BTM / TOPS </span></td>
        <td colspan="6"><strong><?php echo $com_inv_dataholder['strBTM'];?></strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><span class="invoicefntbold">QUOTA CAT</span></td>
        <td colspan="6"><strong><?php echo $com_inv_dataholder['strCat'];?></strong></td>
        <td width="8%" class="border-left-fntsize10">&nbsp;</td>
          <td width="8%" class="border-left-fntsize10">&nbsp;</td>
          <td width="10%" class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3">CARTON NOS:<strong><?php echo $totctns;?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">COUNTERY OF MANUFACTURER: SRI LANKA</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-top-left-fntsize10">TOTAL FOB COST</td>
          <td class="border-top-fntsize10"><?php echo ($insurance_ch!=0?$dataholder['strCurrency']:"")?></td>
          <td class="border-top-fntsize10" style="text-align:right"><?php echo number_format($tot-($tot_ch*$totqty),2);?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Gross Weight</td>
        <td>:<?php echo number_format($dataholder['gross'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10"><?php echo ($freight_ch!=0?"ADD: SEA FREIGHT ":"")?></td>
          <td><?php echo ($freight_ch!=0?$dataholder['strCurrency']:"")?></td>
          <td style="text-align:right"><?php echo ($freight_ch!=0?number_format($freight_ch*$totqty,2):"")?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Net Weight</td>
        <td>:<?php echo number_format($dataholder['net'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10"><?php echo ($insurance_ch!=0?"ADD: INSURANCE":"")?></td>
          <td><?php echo ($insurance_ch!=0?$dataholder['strCurrency']:"")?></td>
          <td style="text-align:right"><?php echo ($insurance_ch!=0?number_format($insurance_ch*$totqty,2):"")?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Net Net Weight</td>
        <td>:<?php echo number_format($dataholder['netnet'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10"><?php echo ($dest_ch!=0?"ADD: DESTINATION CHARGES":"")?></td>
          <td><?php echo ($dest_ch!=0?$dataholder['strCurrency']:"")?></td>
          <td style="text-align:right"><?php echo ($dest_ch!=0?number_format($dest_ch*$totqty,2):"")?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize10" style="border-top-style:dotted;border-top-width:1px;"><strong>TOTAL <?php echo $dataholder['strIncoterms'];?> COST</strong></td>
        <td style="border-top-style:dotted;border-top-width:1px;"><strong><?php echo ($insurance_ch!=0?$dataholder['strCurrency']:"")?></strong></td>
        <td style="text-align:right;border-top-style:dotted;border-top-width:1px;"><strong><?php echo number_format($tot,2);?></strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
           <tr>
        <td colspan="3" class="border-top-fntsize10">&nbsp;TOTAL US DOLLARS (IN WORDS): </td>
        <td colspan="5" rowspan="2" class="border-top-fntsize10" valign="top"><strong><?php 
		include "../../../../Reports/numbertotext.php";
		$mat_array=explode(".",number_format($tot,2));
		echo convert_number($tot);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></strong></td>
        <td class="border-top-fntsize10">&nbsp;</td>
        <td class="border-top-fntsize10">TOTAL</td>
        <td class="border-All-fntsize10" style="text-align:right;font-weight:bold"><?php echo number_format($tot,2);?></td>
      </tr>
       <tr>
        <td colspan="3" >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;GPA NUMBER : </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo "PS NO.(#) :".$com_inv_dataholder['strPSno'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="7" rowspan="7" valign="top" class="border-right-fntsize10"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size10">
      <tr>
        <td width="50%"><strong>
          <?php  echo $mainmark1;?>
        </strong></td>
        <td width="50%"><strong>
          <?php  echo $sidemark1;?>
        </strong></td>
      </tr>
      <tr>
        <td><?php  echo $mainmark2;?></td>
        <td><?php  echo $sidemark2;?></td>
      </tr>
      <tr>
        <td><?php  echo $mainmark3;?></td>
        <td><?php  echo $sidemark3;?></td>
      </tr>
      <tr>
        <td><?php  echo $mainmark4;?></td>
        <td><?php  echo $sidemark4;?></td>
      </tr>
      <tr>
        <td><?php  echo $mainmark5;?></td>
        <td><?php  echo $sidemark5;?></td>
      </tr>
      <tr>
        <td><?php  echo $mainmark6;?></td>
        <td><?php  echo $sidemark6;?></td>
      </tr>
      <tr>
        <td><?php  echo $mainmark7;?></td>
        <td><?php  echo $sidemark7;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;CARTON SIZE </td>
    <td colspan="2" ><?php echo $com_inv_dataholder['strCTNSize'];?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;CARTON TYPE </td>
    <td colspan="2" ><?php echo $com_inv_dataholder['strCTNSType'];?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;B/L # </td>
    <td><?php echo $com_inv_dataholder['strBL'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;CONTAINER #</td>
    <td><?php echo $com_inv_dataholder['strContainer'];?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp; </td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;<?php echo ($com_inv_dataholder['strFreightPC']!="" ? "FREIGHT ".$com_inv_dataholder['strFreightPC']:"");?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize10">Company seal  Signature &amp; Date</td>
    <td class="border-top-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize10">&quot;SEE ANNEXURE FOR NET NET WEIGHT</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="border-left-fntsize10">PER PRODUCT CODE / PER SIZE&quot;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;We declare that invoice shows the actual price of the goods </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-bottom-left-fntsize10">&nbsp;described and that all particulars are true and correct. </td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td class="border-bottom-fntsize10">&nbsp;</td>
    <td colspan="4" class="border-Left-bottom-right-fntsize10" style="text-align:right">Date  <?php echo $dateInvoice ;?></td>
  </tr>
  
  <tr>
    <td width="11%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
  </tr>
</table>
</body>
</html>
