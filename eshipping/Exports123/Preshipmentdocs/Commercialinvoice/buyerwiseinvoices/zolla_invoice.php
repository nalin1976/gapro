<?php 
session_start();
include "../../../../Connector.php";
$xmldoc=simplexml_load_file('../../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;

		$BuyerDetails .= ($buyerAddress1=="" ? "":$buyerAddress1."<br/>");
		$BuyerDetails .= ($buyerAddress2=="" ? "":$buyerAddress2."<br/>");
		$BuyerDetails .= ($BuyerCountry=="" ? "":$BuyerCountry."<br/>");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PRE-INVOICE</title>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="7" bgcolor="#CCCCCC" class="normalfnt_size20" style="text-align:center"><?php echo $Company;?></td>
  </tr>
  <tr>
    <td colspan="7" bgcolor="#999999" class="normalfntMid"><?php echo $Address." ".$Country." Tel ".$phone." Fax ".$Fax;?></td>
  </tr>
  <tr>
    <td colspan="7" class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="normalfnt2bldBLACKmid"><strong>INVOICE</strong> </td>
  </tr>
  <tr>
    <td colspan="7" >&nbsp;</td>
  </tr>
  
  <tr>
    <td width="6%" class="normalfnt_size10" ><b>Seller</b></td>
    <td width="2%" class="normalfnt_size10" ><b>:</b></td>
    <td class="normalfnt_size10" ><B><?php echo $Company;?></B></td>
    <td width="21%" class="normalfnt_size10" >&nbsp;</td>
    <td width="12%" class="normalfnt_size10" ><B>Invoice No </B></td>
    <td width="2%" class="normalfnt_size10" ><B>:</B></td>
    <td width="26%" class="normalfnt_size10" >&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" ><b>Address</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td width="31%" class="normalfnt_size10" ><b><?php echo $Address." ".$Country ?> </b></td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" ><b>Date</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td class="normalfnt_size10" >&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" ><b>Consignee</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td class="normalfnt_size10" >&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" ><b>Shipper</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td class="normalfnt_size10" ><b><?php echo $Company;?></b></td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" ><b>Address</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td rowspan="2" class="normalfnt_size10" valign="top" >&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" ><b>Address</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td class="normalfnt_size10" ><b><?php echo $Address." ".$Country ?></b></td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10"><b>Contract No </b></td>
    <td class="normalfnt_size10"><b>:</b></td>
    <td class="normalfnt_size10">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" ><b>Buyer</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td class="normalfnt_size10" ><?php echo $dataholder['BuyerAName']; ?></td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10"><b>Contract date</b> </td>
    <td ><b>:</b></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" ><b>Address</b></td>
    <td class="normalfnt_size10" ><b>:</b></td>
    <td class="normalfnt_size10" ><b><?php echo $BuyerDetails; ?></b></td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10"><b>Delivery terms</b> </td>
    <td class="normalfnt_size10"><b>:</b></td>
    <td class="normalfnt_size10"><?php echo $dataholder['strIncoterms']." ".$dataholder['strPortOfLoading']; ?></td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10"><b>Manufacture</b></td>
    <td  class="normalfnt_size10"><b>:</b></td>
    <td class="normalfnt_size10">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10"><b>Address</b></td>
    <td  class="normalfnt_size10"><b>:</b></td>
    <td rowspan="2" class="normalfnt_size10" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td  class="normalfnt_size10">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10"><b>Country of origin </b></td>
    <td  class="normalfnt_size10"><b>:</b></td>
    <td class="normalfnt_size10">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td  class="normalfnt_size10">&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="normalfnt_size10" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="4%" height="21" class="border-Left-Top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>No.</b></td>
        <td width="9%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Article</b></td>
        <td width="9%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Marking</b></td>
        <td width="14%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Goods Description</b></td>
        <td width="10%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Composition of fabric</b></td>
        <td width="10%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Composition of lining</b></td>
        <td width="7%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Fur</b></td>
        <td width="7%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Padding</b></td>
        <td width="8%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Q-ty,Pcs</b></td>
        <td width="8%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Price FOB,USD</b></td>
        <td width="8%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>Amount FOB,USD</b></td>
        <td width="6%" class="border-top-right-fntsize10" bgcolor="#999999" style="text-align:center"><b>HS Code</b></td>
      </tr>
      <tr>
        <td height="20" class="border-left-fntsize10">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Order no</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Order Date </td>
        <td>:</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td height="20" class="border-left-fntsize10">&nbsp;</td>
        <td>&nbsp;</td>
        <td>Specification No</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Specification Date</td>
        <td>:</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize10">&nbsp;</td>
      </tr>
	  <?php
	  	for($i=1;$i<=25;$i++)
		{
	  ?>
	  
      <tr>
        <td height="20" class="border-Left-Top-right-fntsize10" style="text-align:center"><?php echo $i; ?></td>
        <td class="border-top-right-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#VALUE</td>
        <td class="border-top-right-fntsize10" style="text-align:left">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
        <td class="border-top-right-fntsize10" style="text-align:center">#N/A</td>
      </tr>
	  <?php
	  } 
	  ?>
	   <tr bgcolor="#999999">
        <td height="20" class="border-top-bottom-left-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:left"><b>Total :</b></td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize10" style="text-align:center">&nbsp;</td>
        <td class="border-top-bottom-right-fntsize10" style="text-align:center">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td  class="normalfnt_size10">&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" class="normalfnt_size10"  ><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="14%" height="15"><b>Total net Weight, kg </b> </td>
        <td width="1%"><b>:</b></td>
        <td width="11%">&nbsp;</td>
        <td width="17%">&nbsp;</td>
        <td width="20%">&nbsp;</td>
        <td width="7%"><b>Name  </b></td>
        <td width="1%"><b>:</b></td>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td height="15"><b>Total gross weight, kg</b> </td>
        <td><b>:</b></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><b>Position </b></td>
        <td><b>:</b></td>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td height="15"><b>Total No. of cartons </b></td>
        <td><b>:</b></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td height="15"><b>Total Volume, m3 </b></td>
        <td><b>:</b></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td width="17%">&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-top-fntsize10"><b>(Signature, Stamp)</b></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10" >&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
    <td  class="normalfnt_size10">&nbsp;</td>
    <td class="normalfnt_size10">&nbsp;</td>
  </tr>
 </table>
</body>
</html>
