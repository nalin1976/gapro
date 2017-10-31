<?php 
session_start();
include "../../../../Connector.php";
include 'common_report.php';
include 'pl_manipulation.php';
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
$invoiceNo=$_GET['InvoiceNo'];
include("invoice_queries.php");	

$proforma=$_GET['proforma'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>COMMERCIAL INVOICE</title>
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
	line-height:110%
}


</style>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="900" border="0" cellspacing="0" cellpadding="1" class="normalfnt_size10">
  <tr>
    <td colspan="11" class="cusdec-normalfnt2bldBLACK" style="text-align:center"><?php echo ($proforma==""?"COMMERCIAL":$proforma);?> INVOICE</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>SHIPPER/EXPORTER/SELLER :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS REG# PV 64804</strong></td>
    <td colspan="3" class="border-top-left-fntsize10"><B>&nbsp;Invoice No. &amp; Date</B> </td>
    <td colspan="3" class="border-Left-Top-right-fntsize10"><B>&nbsp;Exporter's Ref</B> </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<strong><?php echo $Company;?></strong></td>
    <td colspan="3" class="border-left-fntsize10"><?php echo $dataholder['strInvoiceNo'];?> OF <?php echo $dateInvoice ;?></td>
    <td colspan="3" class="border-left-right-fntsize10"><?php echo $dataholder['strPreInvoiceNo'];?></td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $Address;?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10"><B>Buyer's Order No & Date</B> </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $City;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;Tel # <?php echo $phone;?> Fax # <?php echo $Fax;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td width="11%" class="border-left-fntsize10">&nbsp;Tax ID#</td>
    <td colspan="4" ><?php echo $Com_TinNo;?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10"><strong>&nbsp; NOTIFY</strong></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;chandana@oritsl.com</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>MANUFACTURER / NAME &amp; ADDRESS : </strong></td>
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
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo ($dataholder['Brokerphone']!=""?"Tel : ".$dataholder['Brokerphone']:"");?> <?php echo ($dataholder['BrokerFax']!=""?"Fax : ".$dataholder['BrokerFax']:"");?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<strong>MID NO :<?php echo $dataholder['strMIDCode'];?></strong></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $BrokerContactPerson;?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10"><B>&nbsp;MANUF. LOCATION / CODE #</B> <?php echo $dataholder['locationcode'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $BrokerRemarks;?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>CONSIGNEE/ IMPORTER : </strong></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;<strong><?php  echo ($dataholder['dtoName']!=""?($SoldTitle==""?"SOLD TO:":$SoldTitle):"");?>
    </strong></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerAName'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['dtoName'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress1'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['dtoAddress1'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress2'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['dtoAddress2'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerCountry'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['dtoCountry'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo ($dataholder['buyerphone']!=""?"Tel : ".$dataholder['buyerphone']:"");?> <?php echo ($dataholder['BuyerFax']!=""?"Fax : ".$dataholder['BuyerFax']:"");?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo ($dataholder['dtophone']!=""?"Tel : ".$dataholder['dtophone']:"");?> <?php echo ($dataholder['dtoFax']!=""?"Fax : ".$dataholder['dtoFax']:"");?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $BuyerRemarks;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dtoremarks;?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Country of origin of Goods</td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;Country of Final Destination</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;SRI LANKA</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['countrydest'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-top-left-fntsize10"><B>&nbsp;Pre-Carriage by </B></td>
    <td colspan="3" class="border-top-left-fntsize10"><B>&nbsp;Place of Receipt by Carrier</B> </td>
     <td colspan="6" class="border-Left-Top-right-fntsize10"><B>&nbsp;Terms of Delivery and Payment by</B>&nbsp;&nbsp;<?php echo $dataholder['strPayTerm'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;N.A</td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;N.A</td>
    <td colspan="6" class="border-left-right-fntsize10"><B>&nbsp;Bank Details</B> </td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10"><B>&nbsp;Vessel/Voyage/ETD</B></td>
    <td colspan="3" class="border-top-left-fntsize10"><B>&nbsp;Port of Loading</B></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankname'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo $dataholder['strCarrier']." ".$dataholder['strVoyegeNo']." ".$dataholder['dtmSailingDate'];?></td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankaddress1'];?></td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10"><B>&nbsp;Port of Discharge</B></td>
    <td colspan="3" class="border-top-left-fntsize10"><B>&nbsp;Final Destination</B></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankaddress2'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['port'];?></td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['city'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankref'];?></td>
  </tr>
  
  <tr>
    <td colspan="11" class="border-Left-Top-right-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
          <td width="6%">&nbsp;</td>
          <td width="4%">&nbsp;</td>
          <td width="9%">&nbsp;</td>
          <td width="13%" >&nbsp;</td>
          <td width="2%" >&nbsp;</td>
          <td width="0%" >&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Quantity</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Rate</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Amount</span></div></td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="invoicefntbold">DESCRIPTION OF GOODS : </span></td>
        <td colspan="3"><strong><?php  echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?></strong></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10"style="text-align:center">PIECES</td>
        <td class="border-left-fntsize10" style="text-align:center"><?php echo $dataholder['strIncoterms'];?> UNIT</td>
        <td class="border-left-fntsize10" style="text-align:center"> <?php echo $dataholder['strCurrency']." ". $dataholder['strIncoterms'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="invoicefntbold">GENDER : </span></td>
        <td colspan="3"><strong><?php echo $com_inv_dataholder['strGender'];?></strong></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10" style="text-align:center">COST <?php echo $dataholder['strCurrency'];?></td>
        <td class="border-left-fntsize10" style="text-align:center;font-size:7px"><?php echo ($dataholder['strIncoterms']=="FOB"?$dataholder['strPortOfLoading'].", SRI LANKA":$dataholder['city']);?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="invoicefntbold">FIBER CONTENT : </span></td>
        <td colspan="3"><strong><?php  echo $r_summary->summary_string($invoiceNo,'strFabric');?></strong></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="invoicefntbold">GARMENT TYPE : </span></td>
        <td colspan="3"><strong><?php echo $com_inv_dataholder['strGarmentType'];?></strong></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="invoicefntbold">CONSTN TYPE : </span></td>
        <td colspan="3"><strong><?php  echo  $r_summary->summary_string_concat($invoiceNo,'strFabric','strConstType','strFabric') ;?></strong></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="invoicefntbold">BTM / TOPS : </span></td>
        <td colspan="3"><strong><?php echo $com_inv_dataholder['strBTM'];?></strong></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"><span class="invoicefntbold">QUOTA CAT : </span></td>
        <td colspan="3"><strong><?php echo $com_inv_dataholder['strCat'];?></strong></td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">BRAND</td>
        <td colspan="5">:<?php echo $com_inv_dataholder['strBrand'];?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">QUALITY STD </td>
        <td colspan="5">:<?php echo ($com_inv_dataholder['strQuality']==1?"1st Quality":($com_inv_dataholder['strQuality']==2?"2nd Quality":"3rd Quality"));?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">PACKG STD</td>
        <td colspan="5">:<?php echo $com_inv_dataholder['strPackStd'];?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      
      <tr>
        <td colspan="3" no>SAP PO NUMBER</td>
        <td colspan="5">:<?php  echo $r_summary->summary_string($invoiceNo,'strBuyerPONo');?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
		 <tr>
        <td height="18">&nbsp;</td>
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
					commercial_invoice_detail.strDescOfGoods,
					commercial_invoice_detail.strBuyerPONo,
					commercial_invoice_detail.strStyleID,
					commercial_invoice_detail.dblQuantity,
					commercial_invoice_detail.dblUnitPrice,
					commercial_invoice_detail.dblAmount,
					commercial_invoice_detail.intNoOfCTns,
					commercial_invoice_detail.strISDno,
					commercial_invoice_detail.strHSCode,
					shipmentplheader.strWashCode
					from
					commercial_invoice_detail
					left join shipmentplheader on shipmentplheader.strPLNo=commercial_invoice_detail.strPLno					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
					
		
	  ?>
     
      <tr>
        <td style="text-align:center;"><span style="text-align:center;">&nbsp;<strong><u>ISD #</u></strong></span></td>
        <td colspan="3" style="text-align:center;">&nbsp;<strong><u>ITEM</u></strong></td>
        <td colspan="2" style="text-align:center">&nbsp;<strong><u>PO NUMBER</u></strong></td>
          <td style="text-align:center">&nbsp;<strong><u>PRODUCT CODE/STYLE NO</u></strong></td>
          <td style="text-align:center">&nbsp;<strong><u>CTNS</u></strong></td>
		  <td class="border-left-fntsize10" style="text-align:center">&nbsp;<strong><u>QTY PCS</u></strong></td>
		  <td class="border-left-fntsize10" style="text-align:right">&nbsp;</td>
          <td class="border-left-fntsize10" style="text-align:right">&nbsp;</td>
		  <?php
			$result_desc=$db->RunQuery($str_desc);
			
			$bool_rec_fst=1;
			while(($row_desc=mysql_fetch_array($result_desc))||$count<15){
			
			$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
			$totqty+=$row_desc["dblQuantity"];
			$totctns+=$row_desc["intNoOfCTns"];
			$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
			$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
			$hts_code=$row_desc["strHSCode"];
			$count++;
					  
		  ?>
        </tr>
      <tr>
        <td style="text-align:center;"><?php echo $row_desc["strISDno"];?></td>
        <td colspan="3" align="center"><span style="text-align:center;"><?php echo $row_desc["strDescOfGoods"];?></span></td>
        <td colspan="2" style="text-align:center;" ><?php echo $row_desc["strBuyerPONo"];?></td>
          <td style="text-align:center;"><?php echo $row_desc["strStyleID"];?></td>
          <td  style="text-align:center;">&nbsp;<?php echo $row_desc["intNoOfCTns"];?></td>
          <td class="border-left-fntsize10" style="text-align:right;"><?php echo $row_desc["dblQuantity"];?></td>
          <td class="border-left-fntsize10"style="text-align:right;"><span class="normalfnt"><?php echo ($row_desc["dblQuantity"]!=""?number_format($price_dtl,2):"");?></span></td>
          <td class="border-left-fntsize10" style="text-align:right;"><span class="normalfnt"><?php echo ($row_desc["dblQuantity"]!=""?number_format($amt_dtl,2):"");?></span></td><?php }?>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="2" >&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10" >&nbsp;</td>
        </tr>
      
      
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
       <td style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:center"><strong><?php echo $totctns;?></strong></td>
       <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo $totqty;?></strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
       <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo number_format($tot,2);?></strong></td>
      </tr>
      <tr>
        <td colspan="6">CARTON NOS : <strong><?php echo $totctns;?> CTNS</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6">COUNTERY OF ORIGIN : SRI LANKA</td>
        <td width="21%">&nbsp;</td>
        <td width="12%">&nbsp;</td>
        <td width="11%" class="border-left-fntsize10">&nbsp;</td>
        <td width="11%" class="border-left-fntsize10">&nbsp;</td>
        <td width="11%" class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"  valign="top">Gross Weight</td>
        <td  valign="top">:<?php echo number_format($dataholder['gross'],2);?>KGS</td>
        <td colspan="5" rowspan="4" valign="top" >
        <?php 
		$str_pl="select strPLno,dblQuantity from commercial_invoice_detail where strInvoiceNo='$invoiceNo'";
		$result_pl=$db->RunQuery($str_pl);
		$pl_recs=mysql_num_rows($result_pl);
		while($row_pl=mysql_fetch_array($result_pl))
		{
		$plno=$row_pl['strPLno'];
		?>
		
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="text-align:center;" class="border-Left-Top-right-fntsize9 tbl-h-fnt">&nbsp;</td>
            <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"  style="text-align:center;"><strong><?php echo $row_dyn['strSize'];?></strong></td>
        <?php }?>
            <td style="text-align:center;" class="border-top-right-fntsize9 tbl-h-fnt"><strong>TOTAL</strong></td>
          </tr>
          <tr>
            <td style="text-align:left;" class="border-Left-Top-right-fntsize9 tbl-h-fnt"><strong>QTY (PCS)</strong></td>
            <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"  style="text-align:center;"><strong><?php echo $pl_pcs=size_wise_total($row_dyn['intColumnNo'],$plno);$tot_qty_pcs+=$pl_pcs;?></strong></td>
        <?php }?>
            <td style="text-align:center;" class="border-top-right-fntsize9 tbl-h-fnt"><strong><?php echo $row_pl['dblQuantity'];?></strong></td>
          </tr>
          <tr>
            <td style="text-align:left;" class="border-Left-Top-right-fntsize9 tbl-h-fnt"><strong>G.WT  (KGS)</strong></td>
            <?php 
		  $str_dyn="select strSize,intColumnNo,dblGross,dblNet from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"  style="text-align:center;"><strong><?php  $pl_pcs=round($plcl->cal_size_wise_gross_wt($row_dyn['intColumnNo'],$plno),2);$tot_gross_wt+=$pl_pcs;echo number_format($pl_pcs,2);?></strong></td>
        <?php }?>
            <td style="text-align:center;" class="border-top-right-fntsize9 tbl-h-fnt"><strong><?php echo number_format($dataholder['gross'],2);?></strong></td>
          </tr>
          <tr>
            <td style="text-align:left;" class="border-Left-Top-right-fntsize9 tbl-h-fnt"><strong>N.WT. (KGS)</strong></td>
            <?php 
		  $str_dyn="select strSize,intColumnNo,dblGross,dblNet from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <td  class="border-top-right-fntsize9 tbl-h-fnt" nowrap="nowrap"  style="text-align:center;"><strong><?php  $pl_pcs=round((size_wise_total($row_dyn['intColumnNo'],$plno)*$row_dyn['dblNet']),2);$tot_net_wt+=$pl_pcs; echo number_format($pl_pcs,2);?></strong></td>
        <?php }?>
            <td style="text-align:center;" class="border-top-right-fntsize9 tbl-h-fnt"><strong><?php echo number_format($dataholder['net'],2);?></strong></td>
          </tr>
           <tr>
            <td class="border-top"><input type="text" style="width: 30px; visibility:hidden" class="txtbox" /></td> 
			<?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
            <td class="border-top">
              <input type="text" style="width: 20px; visibility:hidden" class="txtbox" />
            </td><?php }?>
            <td class="border-top"><input type="text" style="width:30px; visibility:hidden" class="txtbox" /></td>
            <?php 
		  $str_dyn="select strSize,intColumnNo from shipmentplsizeindex where strPLNo='$plno' order by intColumnNo";
		$result_dyn=$db->RunQuery($str_dyn);
		  while($row_dyn=mysql_fetch_array($result_dyn)){?>
        <?php }?>
            </tr>
          </table><?php }?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2"  valign="top">Net Weight</td>
        <td  valign="top">:<?php echo number_format($dataholder['net'],2);?>KGS</td>
        <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" valign="top">Net Net Weight</td>
        <td valign="top">:<?php echo number_format($dataholder['netnet'],2);?>KGS</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
           <tr>
        <td colspan="3" class="border-top-fntsize10">&nbsp;TOTAL US DOLLARS (IN WORDS): </td>
        <td colspan="5" rowspan="2" class="border-top-fntsize10" valign="top"><strong> <?php 
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
    <td class="border-left-fntsize10">&nbsp;ISD NUMBER</td>
    <td colspan="3"><strong>
      <?php  echo $r_summary->summary_string($invoiceNo,'strISDno');?>
    </strong></td>
    <td colspan="7" rowspan="7" class="border-right-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size10">
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
    <td class="border-left-fntsize10">&nbsp;PS NO. (#) </td>
    <td colspan="3" ><?php echo $com_inv_dataholder['strPSno'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;CARTON SIZE </td>
    <td colspan="3" ><?php echo $com_inv_dataholder['strCTNSize'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;CARTON TYPE</td>
    <td colspan="3"><strong><?php echo $com_inv_dataholder['strCTNSType'];?></strong></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo ($com_inv_dataholder['strBL']==""?"MAWB #":"");?></td>
    <td colspan="3"><?php echo $com_inv_dataholder['strMAWB'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10" >&nbsp;<?php echo ($com_inv_dataholder['strBL']==""?"HAWB #":"B/L #");?></td>
    <td colspan="3"><?php echo ($com_inv_dataholder['strBL']==""?$com_inv_dataholder['strHAWB']:$com_inv_dataholder['strBL']);?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;TARIFF NUMBER </td>
    <td colspan="3" > <?php echo $r_summary->summary_string($invoiceNo,'strHSCode');?></td>
  </tr>
  <tr>
    <td height="22" colspan="7" class="border-left-fntsize10">&nbsp;<strong><?php echo ($com_inv_dataholder['strSGSIONO']==""?"":"SGS IO#: ".$com_inv_dataholder['strSGSIONO']);?></strong></td>
    <td colspan="4" class="border-Left-Top-right-fntsize10">Company seal  Signature &amp; Date</td>
  </tr>
  
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td width="18%">&nbsp;</td>
    <td width="9%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="9%" class="border-left-fntsize10">&nbsp;</td>
    <td width="7%" >&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="12%" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo ($com_inv_dataholder['strFreightPC']!="" ? "FREIGHT ".$com_inv_dataholder['strFreightPC']:"");?></td>
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
    <td colspan="5" class="border-left-fntsize10">&nbsp;Declaration :</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" class="border-left-right-fntsize10" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;We declare that this invoice shows the actual price of the goods </td>
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
</table>
</body>
</html>
<?php
function size_wise_total($obj,$plno)
{
	global $db;
	$size_tot		=0;
	$str			="select intRowNo,dblPcs from shipmentplsubdetail
						where strPLNo='$plno' and intColumnNo='$obj'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=size_ctn_total($row['intRowNo'],$row['dblPcs'],$plno);
	}
	return $size_tot;
}

function size_ctn_total($row,$pcs,$plno)
{
	global $db;
	$size_tot		=0;
	$str			="select dblNoofCTNS from shipmentpldetail 
						where strPLNo='$plno' and intRowNo='$row'";
	$result			=$db->RunQuery($str);
	while($row=mysql_fetch_array($result))
	{
		$size_tot+=$row['dblNoofCTNS']*$pcs;
	}
	return $size_tot;
} 
?>