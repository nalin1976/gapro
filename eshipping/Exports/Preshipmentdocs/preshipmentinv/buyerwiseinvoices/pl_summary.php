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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SUMMARY OF DETAILED PACKING LIST</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<?php 
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");?>
</head>

<body class="body_bound">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:24px" height="35" bgcolor="#CCCCCC" colspan="2">ORIT TRADING LANKA (PVT) LTD</td>
  </tr>
  <tr>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:12px" height="20" bgcolor="#999999" colspan="2">07-02, East Tower, World Trade Centre, Echelon Square, Colombo 01, Sri Lanka. Tel: 0094-111-2346370    Fax:0094-111-2346376</td>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:16px">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="text-align:center;font-family:'Times New Roman';font-weight:bold;font-size:14px">SUMMARY OF DETAILED PACKING LIST ( GROSS &amp; NET WT)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="80%" border="0" cellspacing="0" cellpadding="0" align="center" >
      <tr>
        <td class="border-Left-Top-right-fntsize12" style="text-align:center"><strong>PO #</strong></td>
        <td class="border-top-right-fntsize12"  style="text-align:center"><strong>STYLE #</strong></td>
        <td class="border-top-right-fntsize12"  style="text-align:center"><strong>CTNS</strong></td>
        <td class="border-top-right-fntsize12"  style="text-align:center"><strong>NO OF PCS</strong></td>
        <td class="border-top-right-fntsize12"  style="text-align:center"><strong>TTL GRS WT<br />
          (KGS)</strong></td>
        <td class="border-top-right-fntsize12"  style="text-align:center"><strong>TTL NET WT<br />
          (KGS)</strong></td>
        <td class="border-top-right-fntsize12"  style="text-align:center"><strong>TTL NET NET WT
(KGS)</strong></td>
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
					strISDno,
					dblGrossMass,
					dblNetMass,
					dblNetNet,
					strHSCode
					from
					commercial_invoice_detail					
					where 
					strInvoiceNo='$invoiceNo'";
					//die($str_desc);
		$result_desc=$db->RunQuery($str_desc);
		$bool_rec_fst=1;
		while($row_desc=mysql_fetch_array($result_desc)){
		$tot+=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$totqty+=$row_desc["dblQuantity"];
		$totctns+=$row_desc["intNoOfCTns"];
		$price_dtl=$row_desc["dblUnitPrice"]+$tot_ch;
		$amt_dtl=$row_desc["dblAmount"]+$tot_ch*$row_desc["dblQuantity"];
		$hts_code=$row_desc["strHSCode"];
	  ?>
       
       <tr>
        <td class="border-Left-Top-right-fntsize10" style="text-align:center"><?php echo $row_desc["strBuyerPONo"];?> </td>
        <td class="border-top-right-fntsize10" style="text-align:center"><?php echo $row_desc["strStyleID"];?> </td>
        <td class="border-top-right-fntsize10" style="text-align:center"><?php echo $row_desc["intNoOfCTns"];?> </td>
        <td class="border-top-right-fntsize10" style="text-align:center"><?php echo $row_desc["dblQuantity"];?> </td>
        <td class="border-top-right-fntsize10" style="text-align:center" ><?php echo number_format($row_desc["dblGrossMass"],2);?> </td>
        <td class="border-top-right-fntsize10" style="text-align:center"><?php echo number_format($row_desc["dblNetMass"],2);?></td>
        <td class="border-top-right-fntsize10" style="text-align:center"><?php echo number_format($row_desc["dblNetNet"],2);?></td>
       </tr>
      <?php } ?>
      <tr>
         <td colspan="2" class="border-Left-Top-right-fntsize10" style="text-align:center"><strong>TOTAL</strong></td>
         <td class="border-top-right-fntsize10" style="text-align:center"><strong><?php echo $totctns?></strong></td>
         <td class="border-top-right-fntsize10" style="text-align:center"><strong><?php echo $totqty?></strong></td>
         <td class="border-top-right-fntsize10" style="text-align:center" ><strong><?php echo number_format($dataholder['gross'],2);?></strong></td>
         <td class="border-top-right-fntsize10" style="text-align:center"><strong><?php echo number_format($dataholder['net'],2);?></strong></td>
         <td class="border-top-right-fntsize10" style="text-align:center"><strong><?php echo number_format($dataholder['netnet'],2);?></strong></td>
       </tr>
      <tr>
        <td class="border-top">&nbsp;</td>
        <td class="border-top">&nbsp;</td>
        <td class="border-top">&nbsp;</td>
        <td class="border-top">&nbsp;</td>
        <td class="border-top">&nbsp;</td>
        <td colspan="2" class="border-top">&nbsp;</td>
      </tr>
      <tr>
        <td width="14%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
        <td width="14%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="5%">&nbsp;</td>
    <td width="95%">&nbsp;</td>
  </tr>
</table>
</body>
</html>