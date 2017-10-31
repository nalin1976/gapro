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
$bisRegNo=$xmldoc->companySettings->bisreg;
$invoiceNo=$_GET['InvoiceNo'];
//$invoiceNo='1297/OTL/11/10';
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



</style>
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="985" border="0" cellspacing="0" cellpadding="1" class="normalfnt_size10">
  <tr>
    <td colspan="4" class="cusdec-normalfnt2bldBLACK" style="text-align:center">COMMERCIAL INVOICE</td>
  </tr>
  <tr>
    <td width="49%" class="border-top-left-fntsize10">&nbsp;<strong>1 Shipper/Beneficiary :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BUSINESS REG# : <?php echo $bisRegNo; ?></strong></td>
    <td colspan="2" class="border-top-left-fntsize10">&nbsp;<strong>8 No. & Date of invoice</strong> </td>
    <td width="31%" class="border-top-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="" style="text-align:center">&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" class="border-left-fntsize10">&nbsp;<?php echo $Company;?></td>
    <td class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strInvoiceNo'];?></td>
    <td class="" style="text-align:center">&nbsp;OF</td>
    <td class="border-right-fntsize10">&nbsp;<?php echo $dateInvoice ;?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $Address;?></td>
    <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
    <td class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $City;?></td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;<strong>9 No. & Date of L/C</strong></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;DC NO : <?php echo $dataholder['LCNO']; ?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;DATE&nbsp;&nbsp;&nbsp;: <?php echo $dataholder['dtmLCDate']; ?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-top-left-fntsize10">&nbsp;<strong>2 Applicant's Name and Address :</strong></td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;<strong>2 L/C Opening Bank</strong></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td height="21" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerAName'];?></td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['banklcname'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress1'];?></td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $dataholder['buyerAddress2'];?></td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;<strong>10 Bank Information</strong></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $dataholder['BuyerCountry'];?></td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankname'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankaddress1'];?></td>
  </tr>
  <tr>
    <td class="border-top-left-fntsize10">&nbsp;<strong>4 Take Charge/Receipt/Disp From</strong></td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankaddress2'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankcountery'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strPortOfLoading'].", SRI LANKA";?></td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;<?php echo $dataholder['bankref'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-top-left-fntsize10">&nbsp;<strong>5 Final Dest/Delivery/Trnsp to</strong></td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $dataholder['city'];?></td>
    <td colspan="3" class="border-Left-Top-right-fntsize10">&nbsp;<strong>11 Remarks</strong></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;TTL CTNS:</td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php  echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?></td>
  </tr>
  <tr>
    <td class="border-top-left-fntsize10">&nbsp;<strong>6 Carrier</strong></td>
    <td width="18%" class="border-left-fntsize10">&nbsp;TTL GRS WT : </td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php echo number_format($dataholder['gross'],2);?>KGS</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;<?php echo $dataholder['strCarrier']." ".$dataholder['strVoyegeNo'];?></td>
    <td class="border-left-fntsize10">&nbsp;TTL NET WT : </td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php echo number_format($dataholder['net'],2);?>KGS</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;BL No : </td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php echo $com_inv_dataholder['strBL'];?></td>
  </tr>
  <tr>
    <td class="border-top-left-fntsize10">&nbsp;<strong>7 Sailing on or about</strong></td>
    <td class="border-left-fntsize10">&nbsp;CONT. NO :</td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php echo $com_inv_dataholder['strContainer'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10"><strong> &nbsp; </strong></td>
    <td class="border-left-fntsize10">&nbsp;SEAL# :</td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php echo $com_inv_dataholder['strSealNo'];?></td>
  </tr>
  <tr>
    <td height="16" class="border-left-fntsize10">&nbsp;<?php echo $dataholder['dtmSailingDate'];?></td>
    <td class="border-left-fntsize10">&nbsp;FREIGHT TERMS :</td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php echo ($com_inv_dataholder['strFreightPC']!="" ? "FREIGHT ".$com_inv_dataholder['strFreightPC']:"");?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="border-left-fntsize10">&nbsp;EXPORTER'S REFERENCE</td>
    <td colspan="2" class="border-right-fntsize10">&nbsp;<?php echo $dataholder['strPreInvoiceNo'];?></td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td class="border-top-left-fntsize10">&nbsp;<strong>INFORMATION OF ORIGIN:</strong></td>
    <td colspan="2" class="border-top-right-fntsize10">&nbsp;THE GOODS ARE OF SRI LANKA ORIGIN</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10" style="text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td class="border-left-fntsize10">&nbsp;</td>
    <td colspan="3" class="border-left-right-fntsize10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="border-All-fntsize10"><table width="100%" height="267" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="17%" class="">&nbsp;<strong>12 Marks and Nos.of Pkgs</strong></td>
        <td colspan="4" class="border-left-fntsize10" style="text-align:center">&nbsp;<strong>13 Description of Goods</strong></td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:center">&nbsp;<strong>14 Q'TY/Unit</strong></td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:center">&nbsp;<strong>15 Unit-Price</strong></td>
        <td width="5%" class="border-left-fntsize10">&nbsp;<strong>15 Amount</strong></td>
      </tr>
      <tr>
        <td class="">&nbsp;</td>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td width="7%" class="border-left-fntsize10" style="text-align:center">DZS</td>
        <td width="11%" class="border-left-fntsize10" style="text-align:center">PCS</td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:center">&nbsp;Price</td>
        <td class="border-left-fntsize10" style="text-align:center" nowrap="nowrap">&nbsp;<?php echo $dataholder['strIncoterms'];?> - <?php echo $dataholder['strCurrency'];?></td>
      </tr>
      <tr>
        <td valign="top" rowspan="39" class="border-top-fntsize10"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="normalfnt" style="font-size:95%">
            <tr>
              <td width="50%"><?php  echo $mainmark1;?></td>
              </tr>
            <tr>
              <td><?php  echo $mainmark2;?></td>
              </tr>
            <tr>
              <td><?php  echo $mainmark3;?></td>
              </tr>
            <tr>
              <td><?php  echo $mainmark4;?></td>
              </tr>
            <tr>
              <td><?php  echo $mainmark5;?></td>
              </tr>
            <tr>
              <td><?php  echo $mainmark6;?></td>
              </tr>
            <tr>
              <td><?php  echo $mainmark7;?></td>
              </tr>
            <tr>
              <td><?php  echo $sidemark1;?></td>
              </tr>
            <tr>
              <td><?php  echo $sidemark2;?></td>
              </tr>
            <tr>
              <td><?php  echo $sidemark3;?></td>
              </tr>
            <tr>
              <td><?php  echo $sidemark4;?></td>
              </tr>
            <tr>
              <td><?php  echo $sidemark5;?></td>
              </tr>
            <tr>
              <td><?php  echo $sidemark6;?></td>
              </tr>
            <tr>
              <td><?php  echo $sidemark7;?></td>
              </tr>
                </table></td>
				
				
	 
				
				
        <td colspan="4" class="border-top-left-fntsize10">&nbsp;</td>
        <td class="border-top-left-fntsize10">&nbsp;</td>
        <td class="border-top-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-top-left-fntsize10">&nbsp;</td>
        <td class="border-top-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
	  
        <td colspan="4" class="border-left-fntsize10">&nbsp;<?php  echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?> CTNS-<?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity');?> PCS-<?php echo round((($r_summary->summary_sum($invoiceNo,'intNoOfCTns'))/12),2);?> DZS OF</td>
		
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
	 
	  <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;<?php  echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
	 
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;CAT NO: <strong><?php echo $com_inv_dataholder['strCat'];?></strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;<?php echo ($dataholder['strProInvoiceNo']==""?"":"( AS PER BEN'S PRO.INV NO. ".$dataholder['strProInvoiceNo']." )");?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td width="8%" class="border-left-fntsize10" style="text-align:center;font-size:9px" valign="top"><B>ORDER NO</B></td>
        <td width="10%" style="text-align:center;font-size:9px"><B> STYLE NAME</B></td>
        <td width="25%" style="text-align:center;font-size:9px" valign="top" ><B>ITEM</B></td>
        <td width="9%" style="text-align:center;font-size:9px" valign="top"><B>COLOUR</B></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
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
					commercial_invoice_detail.strSD,
					shipmentplheader.strWashCode,
					shipmentplheader.strColor
					from
					commercial_invoice_detail
					left join shipmentplheader on shipmentplheader.strPLNo=commercial_invoice_detail.strPLno					
					where 
					strInvoiceNo='$invoiceNo'";
	 
	  $result_detail=$db->RunQuery($str_desc);
	  $bool_rec_fst=1;
	  while(($row_desc=mysql_fetch_array($result_detail))||($count<20))
	  {
	 	    $tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
			$totqty+=$row_desc["dblQuantity"];
			$totctns+=$row_desc["intNoOfCTns"];
			$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
			$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
			$hts_code=$row_desc["strHSCode"];
			$count++;
	  ?>
      <tr>
        <td class="border-left-fntsize10"  style="text-align:center"><?php echo $row_desc["strBuyerPONo"]; ?></td>
        <td  style="text-align:center"><?php echo $row_desc["strStyleID"]; ?></td>
        <td style="text-align:center"><?php echo $row_desc["strDescOfGoods"];?></td>
        <td style="text-align:center"><?php echo $row_desc["strColor"];?></td>
        <td class="border-left-fntsize10" style="text-align:right"><?php echo( (round(($row_desc["dblQuantity"]/12),2))==0?"":(round(($row_desc["dblQuantity"]/12),2)) )?></td>
        <td class="border-left-fntsize10" style="text-align:right"><?php echo $row_desc["dblQuantity"]; ?></td>
        <td colspan="2" style="text-align:right" class="border-left-fntsize10"><?php echo ($amt_dtl==0?"":number_format($price_dtl,2)) ; ?></td>
        <td class="border-left-fntsize10" style="text-align:right"><?php echo($amt_dtl==0?"":number_format($amt_dtl,2))?></td>
      </tr>
		<?php
		}
		?>
       
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" rowspan="2" class="border-left-fntsize10">&nbsp;FIBER CONTENT : <?php  echo $r_summary->summary_string($invoiceNo,'strFabric');?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;<strong>GRAND TOTAL</strong></td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10" style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"><?php echo number_format($tot,2);?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
	  
	   <?php
	  if($tot_ch==0)
	  {
	  ?>
	  
	  <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
	  <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp; </td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:right">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
	  <?php
	  }
	  else
	  { 
	  ?>
	  
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td colspan="4" class="border-left-fntsize10" style="text-align:center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;C &amp; F BREAK DOWN</strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;COST </td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:right"><?php echo number_format($tot-($tot_ch*$totqty),2);?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
	  
	   <?php
	  }
	  ?>
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10" nowrap="nowrap">&nbsp;<?php echo ($freight_ch!=0?"FREIGHT ":"")?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:right"><?php echo ($freight_ch!=0?number_format($freight_ch*$totqty,2):"")?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;<?php echo ($insurance_ch!=0?"INSURANCE ":"")?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:right"><?php echo ($insurance_ch!=0?number_format($insurance_ch*$totqty,2):"")?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;<?php echo ($dest_ch!=0?"DESTINATION CHARGES ":"")?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10" style="text-align:right"><?php echo ($dest_ch!=0?number_format($dest_ch*$totqty,2):"")?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
         <td colspan="2" class="border-left-fntsize10" <?php if($tot_ch!=0){?>style="border-bottom-style:double;border-bottom-width:3PX;border-top-style:solid;border-top-width:1PX;text-align:right"<?php }?>><strong><?php echo ($tot_ch!=0?number_format($tot,2):"");?></strong></td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" rowspan="2" class="border-left-fntsize10">&nbsp;GRAND TOTAL (US$): <?php 
		include "../../../../Reports/numbertotext.php";
		$mat_array=explode(".",number_format($tot,2));
		echo convert_number($tot);
		echo $mat_array[1]!="00"?" AND CENTS ".convert_number($mat_array[1])." ONLY.":" ONLY.";
		?></td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
        <td colspan="2" class="border-left-fntsize10">&nbsp;</td>
        <td class="border-left-fntsize10">&nbsp;</td>
      </tr>
    </table>    </td>
  </tr>
  <tr>
    <td colspan="4" height="80" class="border-Left-bottom-right-fntsize10"><table width="100%" height="81" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="69%">&nbsp;</td>
        <td width="31%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="25">&nbsp;<strong>ORIT TRADING LANKA (PVT) LTD</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="20">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;<strong>Commercial Manager</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
