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
    <td colspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $City;?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;Tel # <?php echo $phone;?> Fax # <?php echo $Fax;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;LETTER OF CREDIT NO :</td>
  </tr>
  <tr>
    <td colspan="5" class="border-top-left-fntsize10">&nbsp;<strong>MANUFACTURER / SEWER NAME &amp; ADDRESS : </strong></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['LCNO'];?> OF <?php echo $dataholder['dtmLCDate'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['CustomerName'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;(TERMS : FOB-Free On Board Sri Lanka Port : Freight Collect )</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strAddress1'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;THE SHIPPING TERMS : FOB-Free On Board Sri Lanka Port Freight Collect </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strAddress2'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;VESSEL </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['CustomerCountry'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;VESSEL ETD </td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<strong>MID NO :<?php echo $dataholder['strMIDCode'];?></strong></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;CARRIER</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;MANUF. LOCATION / CODE # <?php echo $dataholder['locationcode'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" rowspan="6" class="border-top-left-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;<strong>CONSIGNEE</strong></td>
        <td class="border-left"><strong>APPLICANT</strong></td>
      </tr>
      <tr>
        <td>&nbsp;<?php echo $dataholder['BuyerAName'];?></td>
        <td class="border-left"><?php echo $dataholder['accounteeAName'];?></td>
      </tr>
      <tr>
        <td>&nbsp;<?php echo $dataholder['buyerAddress1'];?></td>
        <td class="border-left"><?php echo $dataholder['accounteeAddress1'];?></td>
      </tr>
      <tr>
        <td>&nbsp;<?php echo $dataholder['buyerAddress2'];?></td>
        <td class="border-left"><?php echo $dataholder['notify2Country'];?> <?php echo $dataholder['accounteeCountry'];?></td>
      </tr>
      <tr>
        <td width="50%" class="border-bottom ">&nbsp;<?php echo $dataholder['BuyerCountry'];?></td>
        <td width="50%" class="border-bottom-left "><?php echo $accounteeremarks;?></td>
      </tr>
    </table></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;<strong>***ALSO NOTIFY</strong></td>
  </tr>
  <tr>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Name'];?></td>
  </tr>
  <tr>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Address1'];?> <?php echo $dataholder['notify2Address2'];?></td>
  </tr>
  <tr>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['notify2Country'];?></td>
  </tr>
  <tr>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $notify2ContactPerson;?></td>
  </tr>
  <tr>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<strong>NOTIFY</strong></td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Country of origin of Goods</td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;Country of Final Destination</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BrokerName'];?></td>
    <td colspan="3" class="border-left-fntsize10" style="text-align:center">SRI LANKA</td>
    <td colspan="3" class="border-left-right-fntsize10" style="text-align:center"><?php echo $dataholder['countrydest'];?></td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BrokerAddress1'];?> <?php echo $dataholder['BrokerAddress2'];?></td>
    <td colspan="6" class="border-Left-Top-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BrokerCountry'];?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $notify2ContactPerson;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="border-left-fntsize10">&nbsp;<?php echo $notify2remarks;?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;PAYMENT BY <?php echo $dataholder['strPayTerm'];?> </td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Vessel/Flight No.</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Port of Loading</td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankname'];?></td>
  </tr>
  <tr>
    <td colspan="2" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strCarrier']." ".$dataholder['strVoyegeNo'];?></td>
    <td colspan="3" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></td>
    <td colspan="6" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankaddress1'];?></td>
  </tr>
   <tr>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;Port of Discharge</td>
    <td colspan="3" class="border-top-left-fntsize10">&nbsp;Final Destination</td>
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
          <td width="10%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="16%">&nbsp;</td>
          <td width="8%" >&nbsp;</td>
          <td width="6%" >&nbsp;</td>
          <td width="8%" >&nbsp;</td>
          <td>&nbsp;</td>
          <td >&nbsp;</td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Quantity</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Rate</span></div></td>
          <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Amount</span></div></td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="5">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10"><div align="center"><span class="invoicefntbold">Pieces</span></div></td>
        <td class="border-left-fntsize10" style="text-align:center"><?php echo $dataholder['strIncoterms'];?> UNIT</td>
        <td class="border-left-fntsize10" style="text-align:center"><?php echo $dataholder['strCurrency']." ". $dataholder['strIncoterms'];?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10" style="text-align:center">COST <?php echo $dataholder['strCurrency'];?></td>
        <td class="border-left-fntsize10" style="text-align:center;font-size:7px"><?php echo ($dataholder['strIncoterms']=="FOB"?$dataholder['strPortOfLoading'].", SRI LANKA":$dataholder['city']);?></td>
      </tr>
      <tr>
        <td colspan="2" valign="bottom"><strong>A COMPLETE </strong><strong>DESCRIPTION OF THE MERCHANDISE<br /><u><strong>WITH GENERIC DESCRIPTION</strong></u></strong></td>
        <td  style="text-align:center" valign="bottom"><strong>HYBRID <br />PROMOTIONS  LLC</strong><br /><u><strong>PO #</strong></u></td>
        <td  style="text-align:center" valign="bottom"><strong>HYBRID PROMOTIONS  LLC</strong><br />
        <u><strong>STYLE NO</strong></u></td>
        <td colspan="3"  style="text-align:center" valign="bottom"><strong>THE PERCENTAGE OF <u>CONTENT/COMPOSITION</u></strong></td>
        <td  style="text-align:center" valign="bottom"><u><strong>NO OF CTNS</strong></u></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
		 <tr>
		   <td colspan="2">&nbsp;</td>
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
					commercial_invoice_detail.strFabric,
					shipmentplheader.strWashCode
					from
					commercial_invoice_detail
					left join shipmentplheader on shipmentplheader.strPLNo=commercial_invoice_detail.strPLno					
					where 
					strInvoiceNo='$invoiceNo'
					order by commercial_invoice_detail.strBuyerPONo
					";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while(($row_desc=mysql_fetch_array($result_desc))||$count<10){
		$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$totqty+=$row_desc["dblQuantity"];
		$totctns+=$row_desc["intNoOfCTns"];
		$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
		$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$hts_code=$row_desc["strHSCode"];
		$count++;
	  ?>
     
      <tr>
        <td colspan="2"><span style="text-align:center"><?php echo $row_desc["strDescOfGoods"];?></span></td>
        <td style="text-align:center;"><span style="text-align:center"><?php echo $row_desc["strBuyerPONo"];$f_isd=$row_desc["strISDno"];?></span></td>
        <td style="text-align:center;"><span style="text-align:center"><?php echo $row_desc["strStyleID"];?></span></td>
        <td colspan="3" style="text-align:center"><?php echo $row_desc["strFabric"];?></td>
        <td style="text-align:center"><span style="text-align:center;"><?php echo $row_desc["intNoOfCTns"];?></span></td>
          <td class="border-left-fntsize10" style="text-align:right"><?php echo $row_desc["dblQuantity"];?></td>
          <td class="border-left-fntsize10" style="text-align:right"><span class="normalfnt"><?php echo ($row_desc["dblQuantity"]!=""?number_format($price_dtl,2):"");?></span></td>
          <td class="border-left-fntsize10" style="text-align:right"><span class="normalfnt"><?php echo ($row_desc["dblQuantity"]!=""?number_format($amt_dtl,2):"");?></span></td>
        </tr>
      <tr>
        <td colspan="3"><span style="text-align:center"><strong><?php echo ($row_desc["strHSCode"]!=""?"HTS NUMBER&nbsp;". $row_desc["strHSCode"]:"");?></strong></span></td>
        <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
        <?php }?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:center"><strong><strong><?php echo $totctns;?></strong></strong></td>
          <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo $totqty;?></strong></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><strong><?php echo number_format($tot,2);?></strong></td>
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
      <tr>
        <td colspan="6">CARTON NOS:<strong><?php echo $totctns;?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="6">COUNTERY OF ORIGIN : SRI LANKA</td>
        <td width="6%">&nbsp;</td>
        <td width="8%">&nbsp;</td>
        <td width="8%" class="border-left-fntsize10">&nbsp;</td>
        <td width="8%" class="border-left-fntsize10">&nbsp;</td>
        <td width="10%" class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" >&nbsp;</td>
          <td>&nbsp;</td>
          <td  style="text-align:right">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Gross Weight</td>
        <td>:<?php echo number_format($dataholder['gross'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td colspan="5" rowspan="4" valign="bottom"><?php if($tot_ch>0){?><table width="100%" border="0" cellpadding="2" cellspacing="0">
          
          <tr>
            <td colspan="3" class="border-top-left-fntsize10"><strong>TOTAL FOB COST</strong></td>
            <td class="border-top-fntsize10"><strong><?php echo $dataholder['strCurrency'];?></strong></td>
            <td class="border-top-fntsize10" style="text-align:right"><strong><?php echo number_format($tot-($tot_ch*$totqty),2);?></strong></td>
          </tr>
          <tr>
            <td colspan="3" class="border-left-fntsize10"><strong><?php echo ($freight_ch!=0?"ADD: SEA FREIGHT ":"")?></strong></td>
            <td><strong><?php echo ($freight_ch!=0?$dataholder['strCurrency']:"")?></strong></td>
            <td style="text-align:right"><strong><?php echo ($freight_ch!=0?number_format($freight_ch*$totqty,2):"")?></strong></td>
          </tr>
          <tr>
            <td colspan="3" class="border-left-fntsize10"><strong><?php echo ($insurance_ch!=0?"ADD: INSURANCE":"")?></strong></td>
            <td><strong><?php echo ($insurance_ch!=0?$dataholder['strCurrency']:"")?></strong></td>
            <td style="text-align:right"><strong><?php echo ($insurance_ch!=0?number_format($insurance_ch*$totqty,2):"")?></strong></td>
          </tr>
          <tr>
            <td colspan="3" class="border-left-fntsize10"><strong><?php echo ($dest_ch!=0?"ADD: DESTINATION CHARGES":"")?></strong></td>
            <td><strong><?php echo ($dest_ch!=0?$dataholder['strCurrency']:"")?></strong></td>
            <td style="text-align:right"><strong><?php echo ($dest_ch!=0?number_format($dest_ch*$totqty,2):"")?></strong></td>
          </tr>
          <tr>
            <td colspan="3" class="border-left-fntsize10"><strong>TOTAL <?php echo $dataholder['strIncoterms'];?> COST</strong></td>
            <td ><strong><?php echo $dataholder['strCurrency'];?></strong></td>
            <td style="text-align:right"><strong><?php echo number_format($tot,2);?></strong></td>
          </tr>
        </table><?php }?></td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Net Weight</td>
        <td>:<?php echo number_format($dataholder['net'],2);?>KGS</td>
        <td>&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
          <td class="border-left-fntsize10">&nbsp;</td>
        </tr>
      <tr>
        <td>Net Net Weight</td>
        <td>:<?php echo number_format($dataholder['netnet'],2);?>KGS</td>
        <td>&nbsp;</td>
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
    <td class="border-left-fntsize10">&nbsp;MAWB #</td>
    <td colspan="2" ><?php echo $com_inv_dataholder['strMAWB'];?></td>
    <td>&nbsp;</td>
    <td colspan="7" rowspan="4" class="border-right-fntsize10" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt_size10">
      <tr>
        <td width="50%"><?php  echo $mainmark1;?></td>
        <td width="50%"><?php  echo $sidemark1;?></td>
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
    <td class="border-left-fntsize10">&nbsp;HAWB #</td>
    <td colspan="3"><?php echo $com_inv_dataholder['strHAWB'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;"SEE ANNEXURE FOR NET NET WEIGHT </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;    PER PRODUCT CODE / PER SIZES"</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="border-left-fntsize10">&nbsp;<?php echo ($com_inv_dataholder['strFreightPC']!="" ? "FREIGHT ".$com_inv_dataholder['strFreightPC']:"");?></td>
    <td colspan="4" class="border-Left-Top-right-fntsize10">Company seal  Signature &amp; Date</td>
  </tr>
  
  <tr>
    <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
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
