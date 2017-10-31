<?php 
session_start();
include "../../../../Connector.php";
$invoiceNo=$_GET['InvoiceNo'];	

$str_summary	="select
sum(dblNetMass) as dblNetMass,
sum(dblGrossMass) as dblGrossMass,
date_format(dtmManufactDate,'%b-%d-%Y')as  dtmManufactDate,
strISDno,
strCat,
strDescOfGoods,
strStyleID,
strCompanyID,
strName,
strAddress1,
strAddress2,
strRefNo
from 
commercial_invoice_detail
left join finalinvoice on finalinvoice.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
left join commercial_invoice_header on commercial_invoice_header.strInvoiceNo=commercial_invoice_detail.strInvoiceNo
left join customers on customers.strCustomerID=commercial_invoice_header.strCompanyID
where commercial_invoice_detail.strInvoiceNo='$invoiceNo'";
$result_summary	=$db->RunQuery($str_summary);
$summary_data	=mysql_fetch_array($result_summary);
//$orientation="jsPrintSetup.kLandscapeOrientation";
$orientation="jsPrintSetup.kPortraitOrientation";
include("printer.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<title>CAPSIA</title>
</head>

<body class="body_bound">
<table width="850" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="90%"><table cellspacing="0" cellpadding="0" class="normalfnt_size12" width="800" align="center">
      <col width="20" />
      <col width="151" />
      <col width="150" />
      <col width="102" />
      <col width="44" />
      <col width="184" />
      <col width="17" />
      <tr height="31">
        <td colspan="7" height="31" width="668" style="text-align:center;font-size:14px">LS&amp;CO. Certificate of Conformity for    Manufacturer and Importer - Adult Apparel Products</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td width="668">&nbsp;</td>
        <td width="668">&nbsp;</td>
        <td>&nbsp;</td>
        <td width="668">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17" colspan="6">Certificate    Number: SP 09- <?php  $str_product	="select
			strStyleID
			from 
			commercial_invoice_detail
			where strInvoiceNo='$invoiceNo'
			order by strBuyerPONo
			";
			$result_product	=$db->RunQuery($str_product);
			$row=0;
			$boo_first=1;
			while($row_product	=mysql_fetch_array($result_product)){if($boo_first==0) echo", ";echo $row_product['strStyleID'];$boo_first=0;}?><?PHP echo " - ".$summary_data["strRefNo"];?></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17" colspan="7">I    (we)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Orit    Apparels Lanka [Pvt] Ltd</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp; &amp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Levi Strauss &amp; Co&nbsp;</strong> hereby certify that the    product&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <em>(Manufacturer    name)</em></td>
        <td colspan="3"><em>(Importer of Record Name)</em></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="65">
        <td colspan="7" height="65" width="668" style="text-align:justify">contained within this shipment complies (based on a reasonable    and representative testing program) with all applicable rules, bans,    regulations and standards under the United States CPSIA (Consumer Product    Safety Improvement Act of 2008) or any other Act, ban,  regulation enforced by the U.S. Consumer Product Safety Commission.</td>
      </tr>
      <tr height="12">
        <td height="12">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="40">
        <td colspan="6" height="40" width="668" style="text-align:justify">The following rules, bans, standards, and regulations apply for    this product (check all that apply - supplied by lab from the <br/>Test Request Form (TRF) and test results):</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="18">
        <td height="18">&nbsp;</td>
        <td colspan="2" rowspan="2" class="border-top-left-fntsize12" style="text-align:center"><strong>Rule/Ban/Standard/Regulation<br/>
          (Check which applies)</strong></td>
        <td rowspan="2" width="668" style="text-align:center" class="border-top-left-fntsize12"><strong>Regulation Citation</strong></td>
        <td colspan="2" rowspan="2" style="text-align:center" class="border-Left-Top-right-fntsize12"><strong>Test Method / LS&amp;CO. Limit</strong></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="18">
        <td height="18">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
        <td colspan="2" align="left" valign="middle" style="padding:5px;"  class="border-top-bottom-left-fntsize12"><img src="levis_newyork.gif" alt="s" />&nbsp;&nbsp; Flammability of General Wearing      Apparel</td>
        <td width="668"  class="border-top-bottom-left-fntsize12">16 CFR 1610</td>
        <td colspan="2" class="border-All-fntsize12">16 CFR 1610</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="36">
        <td colspan="7" height="36" width="668" style="text-align:justify">X Fabric weights all greater than 2.6 ounces    per square yard.&nbsp; No testing required    provided that flammability guarantees are on file.</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="14">&nbsp;</td>
        <td height="14"><u><strong>Product Information:</strong></u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr> <?php $str_product	="select
			strStyleID,strWashCode as strPLno
			from 
			commercial_invoice_detail
			left join shipmentplheader on shipmentplheader.strPLNo=commercial_invoice_detail.strPLno
			where commercial_invoice_detail.strInvoiceNo='$invoiceNo' order by commercial_invoice_detail.strBuyerPONo";
			$result_product	=$db->RunQuery($str_product);
			$row=0;
			$boo_first=1;
			while($row_product	=mysql_fetch_array($result_product)){?>
      <tr height="17">
        <td height="17" colspan="2"><?php if($boo_first==1)echo "Product    Code (9-digit):";?></td>
        <td><?php echo $row_product['strStyleID'];?></td>
        <td><?php if($boo_first==1)echo "FFC (5 digit)";?> </td>
        <td><?php echo $row_product['strPLno'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr><?php $row++;$boo_first=0;}?>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="23">
        <td height="23" colspan="6"><u><strong>Manufacturer    Information:&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Importer of Record Information:</strong></u></td>
        <td>&nbsp;</td>
      </tr>
      <tr height="16">
        <td colspan="3" rowspan="3" class="border-top-left-fntsize12">Date    of Manufacture:<br />
          Finals    offered&nbsp;<?PHP 
		  $manudate_array=explode('-',$summary_data["dtmManufactDate"]);
		  $manudate=$manudate_array[0]." ".$manudate_array[1].", ".$manudate_array[2];		  
		  echo " ".$manudate;?>
          &nbsp;</td>
        <td colspan="3" rowspan="3" class="border-Left-Top-right-fntsize12">&nbsp;</td>
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td colspan="3" rowspan="3" valign="top" class="border-top-left-fntsize12">Manufacturer    Name:<br/>
          Orit    Apparels Lanka [Pvt] Ltd. &ndash; Code # <?php echo $summary_data["strRefNo"];?></td>
        <td width="668" colspan="3" rowspan="3" valign="top" class="border-Left-Top-right-fntsize12">Importer    of Record Name:<br/>
          Levi Strauss &amp; Co.    &ndash;&nbsp;</td>
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td colspan="3" rowspan="3" valign="top" class="border-top-left-fntsize12">Manufacturer    Address (place of manufacture):<br/><?php echo $summary_data["strAddress1"]."<br/>".$summary_data["strAddress2"];?></td>
        <td colspan="3" rowspan="3" class="border-Left-Top-right-fntsize12" valign="top">Importer    of Record Address:<br />
          1155 Battery Street<br/>San    Francisco, CA, 94111 U.S.A.</td>
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="14">&nbsp;</td>
      </tr>
      <tr height="16">
        <td colspan="3" rowspan="3"  valign="top" class="border-top-left-fntsize12">Manufacturer    Phone Number&nbsp; (including country code):<br />
          +9411    2346370 / +9436 4279700</td>
        <td width="668" colspan="3" rowspan="3" valign="top" class="border-Left-Top-right-fntsize12">Importer of Record Phone Number
          (including    country code):<br />
          (1) 415-501-6000</td>
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td colspan="3" rowspan="3" valign="top" class="border-top-bottom-left-fntsize12">Manufacturer    contact (please print):<br />
          Mr.Moditha    Silva / Chandana Fernando</td>
        <td width="668" colspan="3" rowspan="3" valign="top" class="border-All-fntsize12">Importer    of Record contact (please print):<br/>LS    &amp; Co- Country Manager - H S Vishwanath</td>
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="16">
        <td height="16">&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="668">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="19">
        <td height="19" colspan="3"><u><strong>Individual    Responsible for Recordkeeping:</strong></u></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="20">
        <td colspan="3" rowspan="2" valign="top" class="border-top-left-fntsize12">Name:<br/>
          Marina    Wright</td>
        <td colspan="3" rowspan="2" valign="top" class="border-Left-Top-right-fntsize12">Phone:<br />
          (1) 415-501-6366</td>
        <td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
        <td colspan="3" rowspan="2" valign="top" class="border-top-left-fntsize12">Company    Name:<br />Levi    Strauss &amp; Co.</td>
        <td colspan="3" rowspan="2" valign="top" class="border-Left-Top-right-fntsize12">Fax:<br />(1) 415-501-7691</td>
        <td height="20">&nbsp;</td>
      </tr>
      <tr height="20">
        <td height="20">&nbsp;</td>
      </tr>
      <tr height="21">
        <td colspan="3" rowspan="2" class="border-top-bottom-left-fntsize12">Email    Address:<br />
          <a href="mailto:Mwright2@levi.com">Mwright2@levi.com</a></td>
        <td colspan="3" rowspan="2" class="border-All-fntsize12">&nbsp;</td>
        <td height="21">&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="14">
        <td height="14">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17" colspan="3"><strong>&nbsp;File Saved as SP. 09: 00559-2765 - 37747</strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr height="17">
        <td height="17">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
