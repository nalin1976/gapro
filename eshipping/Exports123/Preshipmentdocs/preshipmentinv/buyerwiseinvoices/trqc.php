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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TRQC</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">

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
		font-size:11px;
		line-height:11px;
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
		font-weight:700;
		line-height:20px;
}
.fnt16-bold{
		font-family:Arial;
		font-size:18px;
		text-align:center;
		font-weight:700;
		line-height:20px;
}
.fnt30-bold{
		font-family:Arial;
		font-size:34px;
		text-align:center;
		font-weight:700;
}

</style>
<?PHP //$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="800" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:24px" height="56" bgcolor="#CCCCCC">ORIT TRADING LANKA (PVT) LTD</td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:12px" height="29" bgcolor="#999999">07-02, East Tower, World Trade Centre, Echelon Square, Colombo 01, Sri Lanka. Tel: 0094-111-2346370    Fax:0094-111-2346376</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" style="text-align:right"><span class="fnt14-bold">TQB/IND-3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="4%">&nbsp;</td>
    <td width="92%" class="border-All-fntsize12"><table width="100%" border="0" cellspacing="0" cellpadding="1" class="normalfnt">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" class="fnt16-bold" style="text-align:center"><u>Request for</u></td>
      </tr>
      <tr>
        <td colspan="7" class="fnt16-bold" style="text-align:center"><u>TARIFF RATE QUOTA CERTIFICATE (TRQC)</u></td>
      </tr>
      <tr>
        <td colspan="7" class="fnt16-bold" style="text-align:center"><u>Under ISLFTA for 
        <?php echo ($com_inv_dataholder['strBrand']=="RED - LOOP"?"03":"05"); ?>
        
         Million Scheme</u></td>
      </tr>
      <tr>
        <td height="35" colspan="7" style="text-align:center">&nbsp;</td>
        </tr>
      <tr>
        <td height="24">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="fnt14-bold">TQB No</td>
        <td >&nbsp;</td>
        <td colspan="2" class="border-All-fntsize12 fnt14-bold">MEX / 00140</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" class="fnt14-bold">Date of Allocation Letter</td>
        <td colspan="2" class="border-All-fntsize12 fnt14-bold">TQB/IND/QU/2010-138</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="fnt14-bold">DETAILS OF EXPORTS OF GARMENTS</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-Left-Top-right-fntsize12 fnt9">1. Name &amp; Address of Sri Lankan Exporter of Garments</td>
        <td colspan="2" class="border-top-right-fntsize12 fnt9"> 2. Name &amp; Address of Indian Importer of Garments</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12"><strong><?php echo $Company;?></strong></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['BuyerAName'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12"><?php echo $Address;?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['buyerAddress1'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12"><?php echo $City;?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['buyerAddress2'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12"><?php echo ($dataholder['buyerphone']!=""?"Tel : ".$dataholder['buyerphone']:"");?> <?php echo ($dataholder['notify2Fax']!=""?"Fax : ".$dataholder['notify2Fax']:"");?></td>
        <td colspan="2" class="border-right-fntsize12"><?php echo $dataholder['BuyerCountry'];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12"><?php echo ($dataholder['buyerphone']!=""?"Tel : ".$dataholder['buyerphone']:"");?> <?php echo ($dataholder['BuyerFax']!=""?"Fax : ".$dataholder['BuyerFax']:"");?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12 fnt9">3. Category No.</td>
        <td class="border-top-right-fntsize12 fnt9"> 4. Quota Year</td>
        <td colspan="2" class="border-top-right-fntsize12 fnt9"> 5. Quantity in pieces</td>
        <td class="border-top-right-fntsize12 fnt9"> 6. FOB Value (with Currency Code)</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12"><?php echo $com_inv_dataholder['strCat'];?></td>
        <td class="border-right-fntsize12"><?php echo date("y") ;?></td>
        <td colspan="2" class="border-right-fntsize12"><strong><?php echo $r_summary->summary_sum($invoiceNo,'dblQuantity')." ".$r_summary->summary_string($invoiceNo,'strUnitID');?> ONLY</strong></td>
        <td class="border-right-fntsize12"><strong><?php echo "USD ".$r_summary->summary_sum($invoiceNo,'dblAmount');?></strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-Left-Top-right-fntsize12 fnt9">7. Description of Goods</td>
        <td class="border-top-right-fntsize12 fnt9"> 8. Marks &amp; Nos. of </td>
        <td colspan="2" class="border-top-right-fntsize12 fnt9"> 9. Mode of Transport</td>
        <td class="border-top-right-fntsize12 fnt9">10. Remarks if any</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12 fnt9"><?php  echo $r_summary->summary_string($invoiceNo,'strDescOfGoods');?></td>
        <td class="border-right-fntsize12 fnt9"> Shipping Packages</td>
        <td colspan="2" class="border-right-fntsize12 fnt9"> and Port of Loading</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12"><strong> AS PER INVOICE</strong></td>
        <td colspan="2" class="border-right-fntsize12"><strong><?php echo strtoupper($dataholder['strTransportMode'])." FREIGHT.";?></strong></td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12"><strong><?php echo $r_summary->summary_sum($invoiceNo,'intNoOfCTns');?> CTNS</strong></td>
        <td colspan="2" class="border-right-fntsize12"><strong><?php echo $dataholder['strPortOfLoading']." SRI LANKA";?></strong></td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td colspan="2" class="border-right-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5" class="border-top">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" class="fnt14-bold">Check List</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><dd>1 Copy of the Quota Allocation Letter</td>
        <td >&nbsp;</td>
        <td class="border-All-fntsize12">X</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><dd>2 Copy of the Quota Allocation Letter</td>
        <td >&nbsp;</td>
        <td class="border-left-right-fntsize12">X</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2"><dd>3 Copy of the Quota Allocation Letter</td>
        <td >&nbsp;</td>
        <td class="border-All-fntsize12">X</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5" class="fnt14-bold">Signature &amp; Stamp of the designated authority of the Exporter</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Date</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="5" class="border-top">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="5%">&nbsp;</td>
        <td width="19%">&nbsp;</td>
        <td width="19%">&nbsp;</td>
        <td width="10%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="27%">&nbsp;</td>
        <td width="5%">&nbsp;</td>
      </tr>
    </table></td>
    <td width="4%">&nbsp;</td>
  </tr>
</table>
</body>
</html>