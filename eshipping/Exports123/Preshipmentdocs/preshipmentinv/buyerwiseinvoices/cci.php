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
<title>CCI</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" /><style type="text/css">

.fnt4{
		font-family:Arial;
		font-size:4px;
		text-align:center;
		line-height:6px;
}
.fnt6{
		font-family:Arial;
		font-size:6px;
		text-align:center;
		line-height:8px;
}
.fnt7{
		font-family:Arial;
		font-size:7px;
		text-align:center;
		line-height:9px;
}
.fnt8{
		font-family:Arial;
		font-size:8px;
		text-align:center;
		line-height:10px;
}
.fnt9{
		font-family:Arial;
		font-size:9px;
		text-align:center;
		line-height:11px;
}
.fnt9-leftb{
		font-family:"Times New Roman";
		font-size:11px;
		text-align:left;
		line-height:11px;
		font-weight:bold;
}
.fnt12{
		font-family:Arial;
		font-size:12px;
		text-align:center;
		line-height:14px;
}
.fnt12-bold{
		font-family:Arial;
		font-size:12px;
		text-align:center;
		font-weight:900;
		line-height:14px;
}

.fnt12-bold-head{
		font-family:Arial;
		font-size:13px;
		text-align:center;
		font-weight:900;
		line-height:14px;
}

.fnt14-bold{
		font-family:Arial;
		font-size:16px;
		text-align:center;
		font-weight:700;
		line-height:16px;
}
.fnt16-bold{
		font-family:Arial;
		font-size:18px;
		text-align:center;
		font-weight:700;
		line-height:18px;
}
.fnt30-bold{
		font-family:Arial;
		font-size:34px;
		text-align:center;
		font-weight:700;
}
</style>

</head>

<body class="body_bound">
<table cellspacing="0" cellpadding="0" style="width:900px; line-height:17px;">
 
  <tr>
    <td width="1"></td>
    <td colspan="15" class="border-Left-Top-right-fntsize10 fnt16-bold">CANADA CUSTOMS INVOICE</td>
    
  </tr>
  <tr>
    <td></td>
    <td colspan="15" class="border-Left-bottom-right-fntsize10 fnt12-bold">FACTURE DES DOUANES    CANADIENNES</td>
   
  </tr>
  <tr>
    <td></td>
    <td width="21" class="border-left-fntsize10 fnt9-leftb">1.</td>
    <td colspan="3" class=" fnt9-leftb"><strong>Vendor  ( Name &amp; Address )</strong></td>
    <td width="31">&nbsp;</td>
    <td width="66">&nbsp;</td>
    <td width="68">&nbsp;</td>
    <td width="98">&nbsp;</td>
    <td width="28" class="border-left-fntsize10 fnt9-leftb">2.</td>
    <td colspan="6" class="border-right-fntsize10 fnt9-leftb"><strong>Date of Direct Shipment    to Canada</strong></td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td width="51"></td>
    <td colspan="4">ORIT TRADING    LANKA(PVT)LTD</td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="5" rowspan="2" valign="top"><?php echo $dateInvoice ;?></td>
    <td width="20" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="5">07-02 EAST TOWER,ECHELON    SQUARE,</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="5">WORLD TRADE    CENTRE,COLOMBO 01.</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10 fnt9-leftb">3.</td>
    <td colspan="6" class="border-right-fntsize10 fnt9-leftb">Other    Reference  ( include Purchaser's Order    No. )</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td width="100">SRI LANKA</td>
    <td width="144"></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="5" rowspan="2" valign="top" class="normalfnt"><strong>
      <?php  echo $r_summary->summary_string($invoiceNo,'strBuyerPONo');?>
    </strong></td>
    <td rowspan="2" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">4.</td>
    <td colspan="7" class="border-top normalfnt_size10 fnt9-leftb" ><strong>Consignee  ( Name &amp; Address )</strong></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">5.</td>
    <td colspan="6" class="border-top-right-fntsize10 fnt9-leftb" nowrap="nowrap">Purchaser's    Name &amp; Address  ( if other than    Consignee )</td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="8" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="5">LEVI STRAUSS &amp; CO    (CANADA ) INC</td>
    <td rowspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="5">LEVI STRAUSS AND    CO.(CANADA) INC.,</td>
    <td>&nbsp;</td>
    <td colspan="5">1725 - 16TH AVENUE</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="4">90, CLAIREVILLE DRIVE,    REXDALS,</td>
    <td></td>
    <td>&nbsp;</td>
    <td colspan="5">RICHMOND HILL,    ONTARIO </td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td>ONTARIO,</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td colspan="5">CANADA,L4B 4C6</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2">CANADA M9W 5Y</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">6.</td>
    <td colspan="6" class="border-top-right-fntsize10 fnt9-leftb">Country of Transshipment</td>
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
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
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
    <td class="border-top-left-fntsize10 fnt9-leftb">7.</td>
    <td colspan="2" class="border-top-right-fntsize10 fnt9-leftb" nowrap="nowrap">Country    of Origin of goods</td>
    <td colspan="4" class="border-top-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="border-right-fntsize10">SRI LANKA</td>
    <td colspan="4" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">8.</td>
    <td colspan="7" class="border-top normalfnt_size10 fnt9-leftb" >Transportation : Give    Mode and Place or Direct shipment to Canada</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">9.</td>
    <td colspan="6" class="border-top-right-fntsize10 fnt9-leftb">Conditions of Sales and    Terms of Payment</td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="6" class="border-right-fntsize10 fnt9-leftb">(I.e.Sale, Consignment Shipment, leased goods, etc.)</td>
  </tr>
  <tr>
    <td></td>
    <td>FROM </td>
    <td>:</td>
    <td colspan="5"><?php echo $dataholder['strPortOfLoading']." SRI LANKA";?></td>
    <td colspan="7" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>TO      </td>
    <td>:</td>
    <td colspan="4"><?php echo $dataholder['city'];?></td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="5" style="text-align:center"><?php echo "FOB";?></td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>BY     </td>
    <td>:</td>
    <td colspan="4"><?php echo strtoupper($dataholder['strTransportMode'])." FREIGHT.";?></td>
    <td>&nbsp;</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">10.</td>
    <td colspan="6" class="border-top-right-fntsize10 fnt9-leftb" style="font-size:10px">Currency of Settlement</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="4" class="border-right-fntsize10">U    . S . DOLLARS</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">11.</td>
    <td colspan="2" class="border-top normalfnt_size10 fnt9-leftb" height="25">No  of     pkgs.</td>
    <td colspan="5" class="border-top normalfnt_size10 fnt9-leftb" nowrap="nowrap">12. Specification of Commodities (Kind of Packages, Msrks &amp; Numbers.</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">13.</td>
    <td colspan="2" class="border-top normalfnt_size10 fnt9-leftb">Quantity (State Unit)</td>
    <td colspan="4"  class="border-top-right-fntsize10 fnt9-leftb" style="text-align:center">Selling Price</td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="6"  class="border-top-left-fntsize10">&nbsp;</td>
    <td colspan="7" class="border-top normalfnt_size10" style="font-size:10px">&nbsp;</td>
    <td colspan="2" rowspan="3" class="border-top-left-fntsize10">&nbsp;</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">14.</td>
    <td nowrap="nowrap" class="border-top-fntsize10 fnt9-leftb" style="font-size:10px">Unit Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">15.</td>
    <td colspan="2" nowrap="nowrap" class="border-top-right-fntsize10 fnt9-leftb" style="font-size:10px">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td style="text-align:center"><?php echo $dataholder['noofctns'];?></td>
    <td></td>
    <td colspan="5"><strong>
      <?php  echo $r_summary->summary_string($invoiceNo,'strSpecDesc');?>
    </strong></td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="fnt12-bold-head" style="text-align:left">US $</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="fnt12-bold-head">US $</td>
    <td rowspan="5" class="border-right-fntsize10">&nbsp;</td>
    <td width="1"></td>
  </tr>
  <tr>
    <td></td>
    <td>CTNS</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td colspan="2" class="border-left-fntsize10 fnt12-bold-head" ><u>Per Pce</u></td>
    <td rowspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td class="fnt12-bold-head">FOB</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2">FIBER CONTENT  :</td>
    <td colspan="4"><strong>
      <?php  echo $r_summary->summary_string($invoiceNo,'strFabric');?>
    </strong></td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td>CONTRACT# </td>
    <td colspan="2">PRODUCT CODE</td>
    <td></td>
    <td colspan="2">QUANTITY    (PCS)</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
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
					strISDno
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'
					order by strBuyerPONo
					";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		$count_rw=1;
		while($row_desc=mysql_fetch_array($result_desc)){
		$count_rw++;
		$tot+=$row_desc["dblAmount"]+0;
		$totqty+=$row_desc["dblQuantity"];
		$totctns+=$row_desc["intNoOfCTns"];
		$price_dtl=$row_desc["dblUnitPrice"]+0;
		$amt_dtl=$row_desc["dblAmount"]+0;
	  ?>
  <tr>
    <td></td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td><?php echo $row_desc["strBuyerPONo"];?></td>
    <td colspan="2"><?php echo $row_desc["strStyleID"];?></td>
    <td></td>
    <td align="right"><?php echo $row_desc["dblQuantity"];?></td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td style="text-align:right"><?php echo number_format($price_dtl,2);?></td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td style="text-align:right"><?php  echo number_format($amt_dtl,2);?> </td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <?php }?>
  <tr>
    <td></td>
    <td rowspan="9" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td rowspan="9" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="9" class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="9" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td colspan="2"></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><?php echo $totqty;?></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><?php echo number_format($tot,2);?></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td >          </td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td>CATEGORY</td>
    <td></td>
    <td><?php echo $com_inv_dataholder['strCat'];?></td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">18.</td>
    <td colspan="6" class="border-top normalfnt_size10 fnt9-leftb" style="font-size:10px" nowrap="nowrap" >If any Field 1 to 17 are    included on an attached commercial invoice check this box</td>
    <td class="border-top-left-fntsize10">&nbsp;</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">16.</td>
    <td colspan="3" class="border-top normalfnt_size10 fnt9-leftb" style="font-size:10px">                      Total  Weight</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">17.</td>
    <td colspan="2" nowrap="nowrap" class="border-top-right-fntsize10 fnt9-leftb" style="font-size:16px">Invoice Total</td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="border-top normalfnt_size10" style="font-size:10px">&nbsp;</td>
    <td rowspan="3" class="border-top-left-fntsize10">&nbsp;</td>
    <td class="fnt9-leftb border-top-right-fntsize10" >Net     ( kgs )</td>
    <td colspan="2" class="fnt9-leftb border-top-right-fntsize10">   Gross     ( kgs )</td>
    <td></td>
    <td>         <?php echo number_format($tot,2);?> </td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="2" class="fnt9-leftb">Commercial Invoice   </td>
    <td colspan="4"><?php echo $invoiceNo;?></td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10"><?php echo $dataholder['net'];?></td>
    <td colspan="2" class="border-right-fntsize10">      <?php echo $dataholder['gross'];?></td>
    <td></td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">_________________________</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">19.</td>
    <td colspan="7"  class="border-top normalfnt_size10 fnt9-leftb" style="font-size:10px">Exporter's Name and    Address ( if other than Vendor )</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">20.</td>
    <td colspan="5"  class="border-top normalfnt_size10 fnt9-leftb" style="font-size:10px">Originator ( Name and Address )</td>
    <td class="border-top-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td colspan="6">ORIT TRADING LANKA (PVT)    LTD</td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="5">ORIT APPARELS    LANKA(PVT)LTD</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="6">07-02 EAST TOWER,ECHELON    SQUARE,</td>
    <td colspan="5">NEW TOWN, EMBILIPITIYA</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td colspan="6">WORLD TRADE    CENTRE,COLOMBO 01.</td>
    <td colspan="5">SRI LANKA.</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">21.</td>
    <td colspan="7"  class="border-top  fnt9-leftb" style="font-size:10px">Departmental Ruling ( if    applicable)</td>
    <td colspan="6" class="border-top-left-fntsize10">&nbsp;</td>
    <td rowspan="3" class="border-top-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10 fnt9-leftb">22.</td>
    <td colspan="5" class="fnt9-leftb">If Fields 23 to 25 are    not applicable, check this box</td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-top-left-fntsize10 fnt9-leftb">23.</td>
    <td colspan="3"  class="border-top normalfnt_size10 fnt9-leftb" style="font-size:10px" >If    included in field 17 indicate amount :</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">24.</td>
    <td colspan="3" rowspan="2"  class="border-top normalfnt_size10 fnt9-leftb" style="font-size:10px" >If    NOT included in field 17 indicateamount :</td>
    <td class="border-top-left-fntsize10 fnt9-leftb">25.</td>
    <td colspan="5" class="border-top normalfnt_size10 fnt9-leftb">Check ( if applicable )</td>
    <td rowspan="2" class="border-top-right-fntsize10">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3"></td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-left-fntsize10">(i)</td>
    <td colspan="3" class="fnt9-leftb"><strong>Transpotation    charges, expenses and insurance from</strong></td>
    <td class="border-left-fntsize10">(i)</td>
    <td colspan="3" class="fnt9-leftb">Transpotation    charges, expenses and</td>
    <td class="border-left-fntsize10">(i)</td>
    <td colspan="5" rowspan="2" class="fnt9-leftb">Royalty    payments or subsequent proceeds are paid or payable bythe purchaser.</td>
    <td rowspan="17" class="border-right-fntsize10">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="6" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3"  class="fnt9-leftb">the place of direct shipment to Canada.</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="fnt9-leftb">insurance    to the place of direct</td>
    <td rowspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="fnt9-leftb">shipment    to Canada.</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>$ </td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2">_______________________</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td>$</td>
    <td></td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">(ii)</td>
    <td colspan="5" class="fnt9-leftb">The    purchaser has supplied goods or services for use in the</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td colspan="3">________________________</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td class="border-left-fntsize10">(ii)</td>
    <td colspan="3" class="fnt9-leftb">Costs    for contruction, erection and assembly</td>
    <td class="border-left-fntsize10">(ii)</td>
    <td colspan="3" class="fnt9-leftb">Amounts    for commissions other </td>
    <td rowspan="4" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="5" class="fnt9-leftb">production of these    goods.</td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="fnt9-leftb">after imporation in to    canada.</td>
    <td rowspan="5" class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="fnt9-leftb">than buying    commissions</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td>$</td>
    <td></td>
    <td>&nbsp;</td>
    <td>$</td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2">_______________________</td>
    <td></td>
    <td colspan="3">________________________</td>
    <td>&nbsp;</td>
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
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td class="border-left-fntsize10">(iii)</td>
    <td colspan="2" class="fnt9-leftb">Expot Packing</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">(iii)</td>
    <td colspan="2" class="fnt9-leftb">Expot Packing</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td>$</td>
    <td></td>
    <td>&nbsp;</td>
    <td rowspan="3" class="border-left-fntsize10">&nbsp;</td>
    <td>$</td>
    <td></td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td colspan="2">_______________________</td>
    <td></td>
    <td colspan="3">_______________________</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td></td>
    <td colspan="15" class="border-top normalfnt_size10 fnt9-leftb" style="font-size:10px">&nbsp;</td>
  </tr>
</table>
</body>
</html>