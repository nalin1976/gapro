<?php
include "../../../../Connector.php";

$dateFrom      = $_GET["dateFrom"];
$dateTo	       = $_GET["dateTo"];
$company       = $_GET["company"];
$vatRate	   = $_GET["vatRate"];
$currency	   = $_GET["currency"];
$chkDate	   = $_GET["chkDate"];
$decimalPlace  = 2;
$currencyRate = $_GET["CurrencyRate"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment : SVAT 05</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style4 {
	font-size: 14px;
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<table width="800" border="0" align="center">
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" class="head2">&nbsp;</td>
        <td width="25%" height="36" class="head_text" style="text-align:center">FORM : SVAT 05</td>
      </tr>
      <tr>
        <td height="24" colspan="2" class="head2">Goods / Services Declaration - Supplymentary Form</td>
      </tr>

      <tr>
        <td height="13" colspan="2" class="normalfnth2B">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
  <tr>  	
    <td class="normalfntRiteSML"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
	<thead>
      <tr>        
        <td width="6%" height="25" class="normalfntBtab">Serial No</td>
        <td width="29%" class="normalfntBtab">Suspended Tax Invoice No</td>
        <td width="14%" class="normalfntBtab">Date of Supply</td>
        <td width="15%" class="normalfntBtab">Value of Invoices<br />
          (SLRS )</td>
        <td width="20%" class="normalfntBtab">Suspended VAT Amount <br />
          (SLRS )</td>
        <td width="16%" class="normalfntBtab">Credit Voucher<br />
          No.</td>
        </tr>
		</thead>
        <?php
		$i = 1;
		$sql = "select GFD.intStyleId,GFD.strInvoiceNo,GFD.strComInvNo,(select (round(sum(fsd.dblValue),2)* ECID.dblQuantity)as cmpwprice from firstsalecostworksheetdetail fsd where fsd.intStyleId = GFD.intStyleId and fsd.strType=4) as invAmount,
date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d') AS invoiceDate,ECID.dblQuantity
from firstsale_shippingdata GFD
inner join eshipping.shipmentplheader ESPH on ESPH.intStyleId=GFD.intStyleId
inner join eshipping.commercial_invoice_detail ECID on ESPH.strPLNo=ECID.strPLno
inner join eshipping.commercial_invoice_header ECIH on ECID.strInvoiceNo=ECIH.strInvoiceNo
and GFD.strComInvNo = ECIH.strInvoiceNo
where GFD.intTaxInvoiceConfirmBy is not null ";

if($company!="")
	$sql.="and ECIH.strCompanyID='$company' ";

if($chkDate!=false)
{
	if($dateFrom!="")
	$sql.="and date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d')>='$dateFrom' ";
	
	if($dateTo!="")
	$sql.="and date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d')<='$dateTo' ";
}
$sql.="order by GFD.dblInvoiceId ";
	
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		
		$susVatAmount = ((($row["invAmount"] * $vatRate)/100) * $currencyRate);
		$invoiceAmnt = ($row["invAmount"] * $currencyRate);
		$totInvAmount += $invoiceAmnt;
		$totVatAmount += $susVatAmount;
	?>
		<tr>       
        <td class="normalfntMidTAB" height="20"><?php echo $i; ?></td>
        <td class="normalfntTAB">&nbsp;<?php echo $row["strInvoiceNo"]; ?></td>
        <td class="normalfntMidTAB"><?php echo $row["invoiceDate"]; ?>&nbsp;</td>
        <td class="normalfntRiteTAB"><?php echo number_format($invoiceAmnt,$decimalPlace); ?>&nbsp;</td>
        <td class="normalfntRiteTAB"><?php echo number_format($susVatAmount,$decimalPlace) ?>&nbsp;</td>
        <td class="normalfntRiteTAB">&nbsp;</td>
        </tr>
	<?php
	$i++;
	}
	?>
		 <tr>
        <td colspan="3" class="normalfntRiteTAB" style="font-size:12px"><strong> Total :&nbsp;&nbsp;</strong></td>
        <td class="normalfntRiteTAB" ><strong><?php echo number_format($totInvAmount,2) ?></strong>&nbsp;</td>
        <td class="normalfntRiteTAB"><strong><?php echo number_format($totVatAmount,2) ?></strong>&nbsp;</td>
		<td class="normalfntRiteTAB">&nbsp;</td> 
        </tr> 
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td colspan="2" class="normalfnt" style="border-bottom:dotted">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2"  class="normalfnt" style="border-bottom:dotted">&nbsp;</td>
        </tr>
      <tr>
	  <td colspan="2" class="normalfnt_size12">&nbsp;Signature of the Supplier &<br>&nbsp;Company Seal</td>
        <td width="24%">&nbsp;</td>       
        <td colspan="2"  class="normalfnt_size12">Signature of the Purchaser &amp;<br />
          Company Seal</td>
        </tr>
      <tr>
        <td >&nbsp;</td>
        <td class="normalfntMid"></td>
        <td>&nbsp;</td>
        <td class="normalfntMid"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td width="7%" class="normalfnt_size12">&nbsp;Date :</td>
        <td class="normalfnt"><b><?php echo date("d/m/Y") ?></b></td>
        <td>&nbsp;</td>
        <td class="normalfnt_size12">&nbsp;Date :</td>
        <td class="normalfnt"><b><?php echo date("d/m/Y") ?></b></td>
      </tr>
      <tr>
	   <td width="7%" >&nbsp;</td>
        <td width="31%" class="normalfntMid"></td>       
        <td>&nbsp;</td>        
        <td width="7%" class="normalfntMid"></td>
		<td width="30%">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
<?php 
function getBuyerPOName($styleID,$BuyerPOName)
{
	global $db;
	$SQL = " SELECT strBuyerPoName FROM style_buyerponos WHERE intStyleId='$styleID' and strBuyerPONO='$BuyerPOName'";
	$result=$db->RunQuery($SQL);
	$row=mysql_fetch_array($result);
	return $row["strBuyerPoName"];
}
function baseCurrency($currency) 
{
	global $db;
	$rate = 0;
	$sql = "select rate from exchangerate where currencyID='$currency' and intStatus=1";
	$result = $db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
		$rate = $row["rate"];
	}
	return $rate;
}
?>