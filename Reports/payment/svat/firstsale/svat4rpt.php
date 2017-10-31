<?php 
session_start();
include "../../../../Connector.php"; 
$companyId  = $_SESSION["FactoryID"];
$userId		= $_SESSION["UserID"];

$dateFrom     = $_GET["dateFrom"];
$dateTo	      = $_GET["dateTo"];
$company 	  = $_GET["company"];
$vatRate	  = $_GET["vatRate"];
$chkDate	  = $_GET["chkDate"];
$CurrencyRate = $_GET["CurrencyRate"];
$decimalPlace = 2;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment | SVAT4</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #666666}
-->
</style>
</head>

<body>
<table width="900" border="1" cellspacing="0" cellpadding="10" align="center" bgcolor="#000000">
  <tr class="bcgcolor-tblrowWhite">
    <td>
    <table width="850" border="0" align="center" class="">
  <tr>
    <td><table width="100%" border="0" cellspacing="4" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="17%" height="25" class="head_text" style="text-align:left">&nbsp;Reference No:</td>
    <td width="20%" class="bcgl1txt1" style="text-align:left">&nbsp;</td>
    <td width="38%" class="head_text" style="text-align:left">&nbsp;</td>
    <td width="25%" colspan="4" class="head_text" style="text-align:center">FORM : SVAT 04</td>
  </tr>
  <tr>
    <td class="head_text" style="text-align:left">&nbsp;</td>
    <td class="normalfnt_size12" style="text-align:left">(Office Use Only)</td>
    <td class="head_text" style="text-align:left">&nbsp;</td>
    <td colspan="4" class="head_text" style="text-align:center">&nbsp;</td>
  </tr>
  <tr>
    <td class="head_text" style="text-align:left">&nbsp;</td>
    <td class="normalfnt_size12" style="text-align:left">&nbsp;</td>
    <td class="head_text" style="text-align:left">&nbsp;</td>
    <td colspan="4" class="head_text" style="text-align:center">&nbsp;</td>
  </tr>
    </table>
</td>
  </tr>
  <tr>
    <td colspan="7"><table width="100%" border="0" class="head2BLCK">
      <tr>
        <td class="head2">Goods / Services Declaration under SVATS</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="5" cellpadding="2">
      <tr>
        <td>&nbsp;</td>
        <td class="normalfnt_size12">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
        <td class="normalfnt_size12">&nbsp;</td>
      </tr>
      <tr>
        <td width="17%">&nbsp;</td>
        <td width="32%" class="normalfnt_size12">&nbsp;<b>FROM</b></td>
        <td colspan="2">&nbsp;</td>
        <td width="30%" class="normalfnt_size12">&nbsp;<b>To</b></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;1. Period</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $dateFrom; ?></td>
        <td colspan="2">&nbsp;</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $dateTo; ?></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;2. Supplier</td>
        <td>&nbsp;</td>
        <td colspan="2" class="normalfnt_size12">&nbsp;3. Purchaser</td>
        <td>&nbsp;</td>
      </tr>
      <?php
	  $sqlS = "select C.strName,C.strAddress1,C.strAddress2,C.strCountry,C.strEMail,C.strTQBNo,C.strVatAcNo
				from firstsale_shippingdata GFD
				inner join eshipping.shipmentplheader ESPH on ESPH.intStyleId=GFD.intStyleId
				inner join eshipping.commercial_invoice_detail ECID on ESPH.strPLNo=ECID.strPLno
				inner join eshipping.commercial_invoice_header ECIH on ECID.strInvoiceNo=ECIH.strInvoiceNo
				inner join eshipping.customers C on C.strCustomerID=ECIH.strCompanyID
				and GFD.strComInvNo = ECIH.strInvoiceNo
				where GFD.intTaxInvoiceConfirmBy is not null and ECIH.strCompanyID='$company' ";
	  $resultS = $db->RunQuery($sqlS);
	  while($rowS=mysql_fetch_array($resultS))
	  {
		  $SupSVATNo  = $rowS["strTQBNo"];
		  $SupVATNo   = $rowS["strVatAcNo"];
		  $SName 	  = $rowS["strName"];
		  $SAddress1  = $rowS["strAddress1"];
		  $SAddress2  = $rowS["strAddress2"];
		  $Scountry   = $rowS["strCountry"];
		  $SEMail 	  = $rowS["strEMail"];
	  }
	  	
		$xmlObj = simplexml_load_file('../../../../company.xml');
		$SName = $xmlObj->NameT->CompanyNameT;
		$SAddress1= $xmlObj->AddressT->AddressLine1T;
		$SAddress2= $xmlObj->AddressT->AddressLine2T;
		$Scountry= $xmlObj->AddressT->CountryT;
		$SEMail= $xmlObj->AddressT->EmailT;
		$SupVATNo = $xmlObj->AddressT->VatRegNoT;
		$SupSVATNo = $xmlObj->AddressT->TQBRegNoT; 
		
		$xmlObj = simplexml_load_file('../../../../company.xml');
		$PName = $xmlObj->Name->CompanyName;
		$PAddress1= $xmlObj->Address->AddressLine1;
		$PAddress2= $xmlObj->Address->AddressLine2;
		$Pcountry= $xmlObj->Address->Country;
		$PEMail= $xmlObj->Address->Email;
		$PurVATNo = $xmlObj->Address->VatRegNo;
		$PurSVATNo = $xmlObj->Address->TQBRegNo; 
	  
	  ?>
      <tr>
        <td class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SVAT No.</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $SupSVATNo;?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SVAT No.</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $PurSVATNo;?></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAT No.</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $SupVATNo;?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VAT No.</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $PurVATNo;?></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name.</td>
        <td rowspan="2" class="bcgl1txt_fntsize12"><?php echo $SName; ?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name.</td>
        <td rowspan="2" class="bcgl1txt_fntsize12"><?php echo $PName;?></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address.</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $SAddress1;?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Address.</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $PAddress1;?></td><label></label>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $SAddress2;?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $PAddress2;?></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $Scountry;?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $Pcountry;?></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email Address</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $SEMail;?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email Address.</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $PEMail;?></td>
      </tr>
      <?php
		$i = 0;
		$sqlInv = "select GFD.strInvoiceNo,GFD.strComInvNo,(select (round(sum(fsd.dblValue),2)* ECID.dblQuantity)as cmpwprice from firstsalecostworksheetdetail fsd where fsd.intStyleId = GFD.intStyleId and fsd.strType=4) as invAmount,
date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d') AS invoiceDate
from firstsale_shippingdata GFD
inner join eshipping.shipmentplheader ESPH on ESPH.intStyleId=GFD.intStyleId
inner join eshipping.commercial_invoice_detail ECID on ESPH.strPLNo=ECID.strPLno
inner join eshipping.commercial_invoice_header ECIH on ECID.strInvoiceNo=ECIH.strInvoiceNo
and GFD.strComInvNo = ECIH.strInvoiceNo
where GFD.intTaxInvoiceConfirmBy is not null ";
			
	if($company!="")
	$sqlInv.="and ECIH.strCompanyID='$company' ";

	if($chkDate!=false)
	{
		if($dateFrom!="")
		$sqlInv.="and date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d')>='$dateFrom' ";
		
		if($dateTo!="")
		$sqlInv.="and date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d')<='$dateTo' ";
	}
	$sqlInv.="order by GFD.dblInvoiceId ";
	$resultInv=$db->RunQuery($sqlInv);	
	while($rowInv=mysql_fetch_array($resultInv))
	{
		$susVatAmount = ((($rowInv["invAmount"] * $vatRate)/100) * $CurrencyRate);
		$invoiceAmnt = ($rowInv["invAmount"] * $CurrencyRate);
		$totInvAmount += $invoiceAmnt;
		$totVatAmount += $susVatAmount;
		$i++;
	}
	?>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt_size12">&nbsp;4. Total Value of invoices issued under SVATS ( FORM SVAT 05 ).</td>
        <td width="7%" class="normalfnt_size12" style="">&nbsp;=SLRS</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo number_format($totInvAmount,$decimalPlace); ?></td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt_size12">&nbsp;5. Total Value of SVAT Debit Notes issued under SVAT ( FORM SVAT 05 ( a ) ).</td>
        <td class="normalfnt_size12">&nbsp;=SLRS</td>
        <td class="bcgl1txt_fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt_size12">&nbsp;6. Total Value of SVAT Credit Notes issued under SVAT ( FORM SVAT 05 ( b ) ).</td>
        <td class="normalfnt_size12">&nbsp;=SLRS</td>
        <td class="bcgl1txt_fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt_size12">&nbsp;7. Adjusted Value of Supplies made under SVAT ( 4 + 5 - 6 )</td>
        <td class="normalfnt_size12">&nbsp;=SLRS</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo number_format($totInvAmount,$decimalPlace); ?></td>
      </tr>
      <tr>
        <td colspan="3" class="normalfnt_size12">&nbsp;8. Suspended VAT for the above Period</td>
        <td class="normalfnt_size12">&nbsp;=SLRS</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo number_format($totVatAmount,$decimalPlace); ?></td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
        <td colspan="2" class="normalfnt_size12">&nbsp;</td>
        <td class="">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt_size12">&nbsp;9. No. of Invoices :</td>
        <td class="bcgl1txt_fntsize12">&nbsp;<?php echo $i; ?></td>
        <td colspan="2" class="normalfnt_size12">&nbsp;10 No.of pages of SVAT 5:</td>
        <td class="bcgl1txt_fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="normalfnt_size12">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" class="normalfnt_size12"><table width="100%" border="0" cellspacing="4" cellpadding="0">
          <tr>
            <td width="50%" class="normalfnt_size12"><b>11. Declaration of the Supplier</b></td>
            <td width="50%"><b>12. Declaration of the Purchaser</b></td>
          </tr>
          <tr>
            <td class="bcgl1txt1" style="text-align:left"><table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td style="text-align:left"><span class="normalfnt">I / We hereby declare that the above goods/services were sold
by me /us only for the purpose of export and / or to be usedin
a specified project and /or to be used during the project
implimentation period of a project approved under section
22(7) of the VAT Act and / or for indirect export.</span></td>
  </tr>
  <br />
  <br />
  <br />
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
  <td class="normalfnt" style="text-align:left">Further , in the event of any failure to comply with the guideline
issued by the Commissioner General , I /We am / are aware
that I /We , am/are lable to VAT.</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">Signature of the Supplier & Company Seal</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">Date:&nbsp;<?php echo date("d/m/Y"); ?></td>
  </tr>
            </table>
</td>
            <td class="bcgl1txt1"><table width="100%" border="0" cellspacing="0" cellpadding="4">
  <tr>
    <td style="text-align:left"><span class="normalfnt">I / We hereby declare that the above goods/services were sold
by me /us only for the purpose of export and / or to be usedin
a specified project and /or to be used during the project
implimentation period of a project approved under section
22(7) of the VAT Act and / or for indirect export.</span></td>
  </tr>
  <br />
  <br />
  <br />
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
  <td class="normalfnt" style="text-align:left">Further , in the event of any failure to comply with the guideline
issued by the Commissioner General , I /We am / are aware
that I /We , am/are lable to VAT.</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">Signature of the Supplier & Company Seal</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt">Date:&nbsp;<?php echo date("d/m/Y"); ?></td>
  </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
     
    </table></td>
  </tr>
</table>

  </tr>
</table>
    </td>
  </tr>
</table>

</body>
</html>
<?php
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
