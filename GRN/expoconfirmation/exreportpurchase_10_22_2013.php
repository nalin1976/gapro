<?php 
session_start();
$backwardseperator 				= "../../";
if(!$authenticationApplied)
include "../../authentication.inc";
include "{$backwardseperator}Connector.php";
$xml 							= simplexml_load_file('{$backwardseperator}config.xml');
$SCRequiredForPODetails 		= $xml->PurchaseOrder->SCRequiredForDetails;
$MatRatioIDRequiredForPoDetails = $xml->PurchaseOrder->MatRatioIDRequiredForDetails;
$DeliveryDateRequiredForDetails = $xml->PurchaseOrder->DeliveryDateRequiredForDetails;
$DisplayRevisionNoOnPOReport 	= $xml->PurchaseOrder->DisplayRevisionNoOnPOReport;
$DisplaySupplierCOdeOnReport 	= $xml->PurchaseOrder->DisplaySupplierCOdeOnReport;
$HighlightAdditionalPurchase 	= $xml->PurchaseOrder->HighlightAdditionalPurchase;
$ShowAccountsManager 			= $xml->PurchaseOrder->ShowAccountsManager;
$HighLightOverCostPO 			= $xml->PurchaseOrder->HighLightOverCostPO;
$ReportISORequired				= $xml->companySettings->ReportISORequired;
$DisplayMotherCompany			= $xml->PurchaseOrder->DisplayMotherCompany;
$InstructionFile				= $xml->PurchaseOrder->InstructionFile;
$poStatus 						= 0;

$intPoNo	= $_GET["serialNo"];
$intYear	= $_GET["serialYear"];

$SQL = "SELECT purchaseorderheader_excess.intPoNo,purchaseorderheader_excess.intYear, purchaseorderheader_excess.intStatus, 
companies.strName,companies.strTQBNO, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, 
companies.strState, companies.strZipCode,companies.strRegNo, companies.strPhone, companies.strEMail, 
companies.strFax, companies.strVatAcNo, companies.strWeb,country.strCountry
FROM companies INNER JOIN purchaseorderheader_excess  ON companies.intCompanyID = purchaseorderheader_excess.intInvCompID
INNER JOIN country ON country.intConID = companies.intCountry
WHERE (((purchaseorderheader_excess.intGrnNo)=$intPoNo)) and (((purchaseorderheader_excess.intGrnYear)=$intYear));";
$result = $db->RunQuery($SQL);
while($row = mysql_fetch_array($result ))
{  
	$comName		= $row["strName"];
	$comAddress1	= $row["strAddress1"];
	$comAddress2	= $row["strAddress2"];
	$comStreet		= $row["strStreet"];
	$comCity		= $row["strCity"];
	$comState		= $row["strState"];
	$comCountry		= $row["strCountry"];
	$comZipCode		= $row["strZipCode"];
	$strPhone		= $row["strPhone"];
	$comEMail		= $row["strEMail"];
	$comFax			= $row["strFax"];
	$comWeb			= $row["strWeb"];
	$TQBNo			= $row["strTQBNO"];
	$companyReg		= $row["strRegNo"];
	$strVatNo 		= $row["strVatAcNo"];
	$poStatus 		= $row["intStatus"];
}

if($DisplayMotherCompany == "true")
{
	$xmlObj		 	= simplexml_load_file('company.xml');
	$comName 		= $xmlObj->Name->CompanyName;
	$comAddress1	= $xmlObj->Address->AddressLine1;
	$comAddress2	= $xmlObj->Address->AddressLine2;
	$comStreet		= $xmlObj->Address->Street;
	$comCity		= $xmlObj->Address->City;
	$comCountry		= $xmlObj->Address->Country;
	$strPhone		= $xmlObj->Address->Telephone;
	$comEMail		= $xmlObj->Address->Email;
	$comFax			= $xmlObj->Address->Fax;
	$comWeb			= $xmlObj->Address->Web;
}

	$strAddress1new 	= trim($comAddress1) == "" ? $comAddress1 : $comAddress1 ;
	$strAddress2new 	= trim($comAddress2) == "" ? $comAddress2 : "," . $comAddress2;
	$strStreetnew 		= trim($comStreet) == "" ? $comStreet : $comStreet ;
	$strCitynew 		= trim($comCity) == "" ? $comCity : ", " . $comCity;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Purchase Order Report</title>
<link href="<?php echo "{$backwardseperator}"?>css/erpstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" >
var xmlHttp;

function createXMLHttpRequest() 
{
	if (window.ActiveXObject) 
	{
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else if (window.XMLHttpRequest) 
	{
		xmlHttp = new XMLHttpRequest();
	}
}

function detectspecialkeys(e)
{
	var evtobj=window.event? event : e
	var charCode = (e.which) ? e.which : e.keyCode;
	
	if (evtobj.ctrlKey && charCode == 101 )
		sendEmail();
}

document.onkeypress=detectspecialkeys
function sendEmail()
{
	var year = <?php echo  $_GET["serialYear"];?>;
	var poNo = <?php echo  $_GET["serialNo"];?>;
	var emailAddress = prompt("Please enter the supplier's email address :");
	if (checkemail(emailAddress))
	{	
		createXMLHttpRequest(emailAddress);
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'poemail.php?pono=' + poNo + '&year=' + year + '&supplier=' + emailAddress, true);
		xmlHttp.send(null);
	}
}

function checkemail(str)
{
var filter= /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i
	if (filter.test(str))
		return true;
	else
		return false;
}

function HandleEmail()
{
	if(xmlHttp.readyState == 4) 
	{
		if(xmlHttp.status == 200) 
		{  
			if(xmlHttp.responseText == "True")
				alert("The Purchase Order has been emailed to the supplier.");
		}
	}
}


</script>
<style type="text/css">
<!--
.style1 {font-size: 10px}
-->
</style>
</head>


<body>
<?php 
if($poStatus == 0)
{
?>
<div style="position:absolute;top:200px;left:300px;">
<img src="../../images/pending.png">
</div>
<?php
} 
else if($poStatus == 10)
{
?>
<div style="position:absolute;top:200px;left:400px;">
<img src="../../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);">
</div>
<?php
}
?>
<table width="800" border="0" align="center" cellpadding="0">
<tr>
<td colspan="4"><table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td class="tophead"><table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td width="20%"><img src="<?php echo "{$backwardseperator}"?>images/logo.jpg" alt="" width="191" height="47" class="normalfnt" /></td>

<td width="1%" class="normalfnt">&nbsp;</td>
<td width="67%" class="tophead"><p class="topheadBLACK"><?php echo $comName; ?></p>
<?php
if($strVatNo != "" || $companyReg != "")
echo ($strVatNo==""?"":"<span class=\"normalfnt\"> VAT NO: $strVatNo") . "   &nbsp;&nbsp; " . ($companyReg==""?"":" ( Company Reg. No : $companyReg )</span></b>");

?>
<p class="normalfnt"><?php echo "$strAddress1new $strAddress2new, <br/>$strStreetnew $strCitynew, $comCountry<br/> <b>Tel: $strPhone".",".$comZipCode." Fax: ".$comFax."<br> E-Mail: ".$comEMail." Web: ".$comWeb;?></p>
<p class="normalfnt"></p>     			</td>
<td width="12%" class="tophead"><div class="head2BLCK"><?php
if($poStatus == 10)
{
if($ReportISORequired == "true")
{
$xmlISO = simplexml_load_file('iso.xml');
echo $xmlISO->ISOCodes->StylePOReport;
}              

?></div><div align="center"><img src="images/btn-email.png" style="visibility:hidden;" alt="Email" width="91" height="24" class="mouseover" onclick="sendEmail();" /></div>
<?php
}
?>                   
</td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr>
<td colspan="4"><p class="head2BLCK">&nbsp;</p>
<p class="head2BLCK">EXCESS PURCHASE ORDER</p>
<p class="head2BLCK">&nbsp;</p>
<table width="100%" border="0" cellpadding="0">
<tr>
<td><span class="head2BLCK"><?php echo "PO NO -  $intYear / $intPoNo";?><span class="normalfnth2Bm">
&nbsp;
<?php
$mes = "";
if($intPrintStatus==0)
{
$mes =  "(ORIGINAL)";
}
else 
{
$mes = "(DUPLICATE)";

}

if ($DisplayRevisionNoOnPOReport == "true")
{
if($revisionNo > 0)
$mes .= " Revision No : " . $revisionNo ;

}

echo $mes;
?>
<?php

$strSupplierID="";
$strTitle="";
$strAddress1="";
$strAddress2="";
$strStreet="";
$strCity="";
$strState="";
$strCountry="";
$strPayMode="";
$strPayTerm="";
$strShipmentMode="";
$strShipmentTerm="";
$strInstructions="";
$dtmDate="";
$intInvCompID=0;
$intDelToCompID=0;
$dtmDeliveryDate="";
$intPrintStatus=0;
$UserID=0;
$CheckedID=-1;
$AuthorisedID=-1;
$currencyTitle = "";
$currencyFraction = "";
$currencyRate = 1;

$PO_Details="SELECT purchaseorderheader_excess.intPONo,purchaseorderheader_excess.intYear,DATE_FORMAT(purchaseorderheader_excess.dtmETD, '%d-%M-%Y')  AS dtmETD,DATE_FORMAT(purchaseorderheader_excess.dtmETA, '%d-%M-%Y')  AS dtmETA ,purchaseorderheader_excess.strPINO, purchaseorderheader_excess.intConfirmedBy, purchaseorderheader_excess.strSupplierID, suppliers.strTitle, suppliers.strAddress1, suppliers.strAddress2, suppliers.strVatRegNo, suppliers.strTQBNo ,suppliers.strStreet, suppliers.strCity,suppliers.strSupplierCode , suppliers.strState, suppliers.strCountry, purchaseorderheader_excess.strPayMode, purchaseorderheader_excess.strPayTerm, purchaseorderheader_excess.strShipmentMode, purchaseorderheader_excess.strShipmentTerm, purchaseorderheader_excess.strInstructions, DATE_FORMAT(purchaseorderheader_excess.dtmDate, '%d-%M-%Y')  AS dtmDate, purchaseorderheader_excess.intInvCompID, purchaseorderheader_excess.intDelToCompID, DATE_FORMAT(purchaseorderheader_excess.dtmDeliveryDate, '%d-%M-%Y')  AS dtmDeliveryDate , purchaseorderheader_excess.intPrintStatus, purchaseorderheader_excess.intUserID, purchaseorderheader_excess.intRevisedBy, purchaseorderheader_excess.intRevisionNo, purchaseorderheader_excess.intCheckedBy,purchaseorderheader_excess.strCurrency, currencytypes.strFractionalUnit,  currencytypes.strTitle as currencyTitle, purchaseorderheader_excess.dblExchangeRate AS currencyRate  
FROM suppliers INNER JOIN purchaseorderheader_excess ON suppliers.strSupplierID = purchaseorderheader_excess.strSupplierID inner join currencytypes on purchaseorderheader_excess.strCurrency = currencytypes.intCurID 
WHERE (((purchaseorderheader_excess.intGrnNo)=".$intPoNo.")) and (((purchaseorderheader_excess.intGrnYear)=".$intYear."));";	
$result_pd = $db->RunQuery($PO_Details);
while($row_pd = mysql_fetch_array($result_pd ))
{
$strSupplierID=$row_pd["strSupplierID"];
$strTitle=$row_pd["strTitle"];
$strAddress1=$row_pd["strAddress1"];
$strAddress2=$row_pd["strAddress2"];
$strStreet=$row_pd["strStreet"];
$strCity=$row_pd["strCity"];
$strState=$row_pd["strState"];
$strCountry=$row_pd["strCountry"];
$strPayMode=$row_pd["strPayMode"];
$strPayTerm=$row_pd["strPayTerm"];
$strShipmentMode=$row_pd["strShipmentMode"];
$strShipmentTerm=$row_pd["strShipmentTerm"];
$strInstructions=$row_pd["strInstructions"];
$newpodate=$row_pd["dtmDate"];
$intInvCompID=$row_pd["intInvCompID"];
$intDelToCompID=$row_pd["intDelToCompID"];
$newdeldate=$row_pd["dtmDeliveryDate"];
$intPrintStatus=$row_pd["intPrintStatus"];
$UserID=$row_pd["intUserID"];
$CheckedID=$row_pd["intCheckedBy"];
$AuthorisedID=$row_pd["intConfirmedBy"];
$Currency=$row_pd["strCurrency"];
$PINO=$row_pd["strPINO"];
$currencyTitle = $row_pd["currencyTitle"];
$revisionNo = $row_pd["intRevisionNo"]; 
$currencyFraction = $row_pd["strFractionalUnit"]; 
$supplierCode = $row_pd["strSupplierCode"];   
$currencyRate = $row_pd["currencyRate"];  
$ETD= $row_pd["dtmETD"];
$ETA= $row_pd["dtmETA"];
$supvat=$row_pd["strVatRegNo"];
$suptqb=$row_pd["strTQBNo"];

if ($CheckedID == "" || $CheckedID == null)
$CheckedID = -1;

if ($AuthorisedID == "" || $AuthorisedID == null)
$AuthorisedID = -1;

$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "," . $strAddress2;
$strStreetnew = trim($strStreet) == "" ? $strStreet : "," . $strStreet ;
$strCitynew = trim($strCity) == "" ? $strCity : "," . $strCity;
$strStatenew = trim($strState) == "" ? $strState : "," . $strState . "," ;
}
?>
</span></span></td>
<td class="normalfnth2Bm"><div align="right"><span class="normalfnBLD1">PO Date : 
<?php  echo $newpodate;?>
</span></div></td>
</tr>
<tr>
<td width="56%">&nbsp;</td>

<td width="44%" class="normalfnth2Bm">&nbsp;</td>
</tr>

<tr>
<td><table width="100%" border="0" cellpadding="0">
<tr>
<td colspan="2"><table width="100%" border="0" cellpadding="0">
<tr>
<td height="19" class="normalfnBLD1">Supplier Code </td>
<td width="65%" class="normalfnt"><span class="normalfnBLD1">:</span> <?php
if ($DisplaySupplierCOdeOnReport == "true")
echo $supplierCode;
else
echo $strSupplierID;

?></td>
</tr>
<tr>
<td height="28" class="normalfnBLD1">Name</td>
<td class="normalfnt"><span class="normalfnBLD1">:</span> <?php echo $strTitle;?></td>
</tr>
<tr>
<td height="23" class="normalfnBLD1">Address</td>
<td class="normalfnt"><span class="normalfnBLD1">:</span> <?php
echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew $strCountry.";              
?></td>
</tr>
</table></td>
</tr>
<tr>
<td width="35%" height="23" class="normalfnBLD1">Pay.Method </td>
<td width="65%" class="normalfnt"><span class="normalfnBLD1">:</span> <?php 
$SQL="select strDescription from popaymentmode where strPayModeId = '".$strPayMode."';";
$mainresult = $db->RunQuery($SQL);
while($row = mysql_fetch_array($mainresult))
{
$Description = $row["strDescription"];
}
echo $Description;?></td>
</tr>
<tr>
<td height="23" class="normalfnBLD1">Pay.Terms</td>
<td class="normalfnt"><span class="normalfnBLD1">:</span> <?php 
$SQL="select strDescription from popaymentterms where strPayTermId = '".$strPayTerm."';";
$mainresult = $db->RunQuery($SQL);
while($row = mysql_fetch_array($mainresult))
{
$Description = $row["strDescription"];
}

echo $Description;?></td>
</tr>
<tr>
<td height="23" class="normalfnBLD1">Ship.Method</td>
<td class="normalfnt"><span class="normalfnBLD1">:</span> <?php 
$SQL="select strDescription from shipmentmode where intShipmentModeId = '".$strShipmentMode."';";
$mainresult = $db->RunQuery($SQL);
while($row = mysql_fetch_array($mainresult))
{
$Description = $row["strDescription"];
}

echo $Description;?></td>
</tr>
<tr>
<td height="23" class="normalfnBLD1">Ship.Terms</td>
<td class="normalfnt"><span class="normalfnBLD1">:</span> <?php 
$SQL="select strShipmentTerm from shipmentterms where strShipmentTermId = '".$strShipmentTerm."';";
$mainresult = $db->RunQuery($SQL);
while($row = mysql_fetch_array($mainresult))
{
$Description = $row["strShipmentTerm"];
}
echo $Description;?></td>
</tr>
<tr>
<td height="23" class="normalfnBLD1">Instruction</td>
<td class="normalfnt"><span class="normalfnBLD1">:</span> <?php echo $strInstructions;?></td>
</tr>
</table></td>
<td valign="top"><table width="100%" border="0" cellpadding="0">
<tr>
<td height="46" colspan="2" valign="top" ><div style="border: 1px solid #999999;">
<table width="419" height="44">
<tr>
<td width="171" valign="top" class="normalfnBLD1">Deliver To : </td>
<td width="338" valign="top"><?php
$DELTO="SELECT companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, country.strCountry, companies.intCompanyID
FROM companies inner join country on  companies.intCountry = country.intConID
WHERE (((companies.intCompanyID)=".$intDelToCompID."));";

$result_del = $db->RunQuery($DELTO);
if($row_del = mysql_fetch_array($result_del ))
{
$strAddress1=$row_del["strAddress1"];
$strAddress2=$row_del["strAddress2"];
$strStreet=$row_del["strStreet"];
$strCity=$row_del["strCity"];
$strState=$row_del["strState"];

$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "," . $strAddress2;
$strStreetnew = trim($strStreet) == "" ? $strStreet : "," . $strStreet ;
$strCitynew = trim($strCity) == "" ? $strCity : "," . $strCity;
$strStatenew = trim($strState) == "" ? $strState : "" . $strState . "" ;

echo " <p class=\"normalfnt\">".$row_del["strName"]."<br>";

echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew" . $row_del["strCountry"].".</p>";


}

?></td>
</tr>
</table>

</div></td>
</tr>
<tr>
<td height="58" colspan="2" valign="top" ><div style="border: 1px solid #999999;">
<table width="416" height="40">
<tr>
<td width="171" valign="top" class="normalfnBLD1">Invoice To : </td>
<td width="338" valign="top"> <?php
$INVTO="SELECT companies.strName, companies.strAddress1, companies.strAddress2, companies.strStreet, companies.strCity, companies.strState, country.strCountry, companies.intCompanyID
FROM companies inner join country on  companies.intCountry = country.intConID
WHERE (((companies.intCompanyID)=".$intInvCompID."));";


$result_inv = $db->RunQuery($INVTO);
if($row_inv = mysql_fetch_array($result_inv ))
{
$strAddress1=$row_inv["strAddress1"];
$strAddress2=$row_inv["strAddress2"];
$strStreet=$row_inv["strStreet"];
$strCity=$row_inv["strCity"];
$strState=$row_inv["strState"];

$strAddress1new = trim($strAddress1) == "" ? $strAddress1 : $strAddress1 ;
$strAddress2new = trim($strAddress2) == "" ? $strAddress2 : "," . $strAddress2;
$strStreetnew = trim($strStreet) == "" ? $strStreet : "," . $strStreet ;
$strCitynew = trim($strCity) == "" ? $strCity : "," . $strCity;
$strStatenew = trim($strState) == "" ? $strState : "," . $strState . "," ;

echo " <p class=\"normalfnt\">".$row_inv["strName"]."<br>";
echo "$strAddress1new $strAddress2new<br> $strStreetnew $strCitynew $strStatenew" .$row_del["strCountry"].".";
echo "</p>";
}


?></td>
</tr>
</table>

</div></td>
</tr>
<tr>
<td width="32%" height="23" class="normalfnth2B">ETA Date </td>
<td width="68%"><span class="normalfnBLD1">: </span>&nbsp;<span class="normalfnt"><?php echo $ETA;?></span></td>
</tr>
<tr>
<td height="23" class="normalfnth2B">ETD Date </td>
<td><span class="normalfnBLD1">: </span>&nbsp;<span class="normalfnt"><?php echo $ETD;?></span></td>
</tr>
</table></td>
</tr>
</table>      </td>
</tr>
<tr>
<td width="272" height="22" class="normalfntTAB"><span>DELIVERY DATE :</span> <span class="normalfnBLD1"><?php echo $newdeldate;?></span></td>
<td width="273" class="normalfntTAB">Vat RegNo:<?php echo $supvat ;?></td>
<td width="227" class="normalfntTAB">PI No :<?php echo $PINO;?> </td>
<td width="329" class="normalfntTAB">TQB No:<?php echo $suptqb;?></td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
<tr>
<td colspan="4"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblMain">
<tr>
<td  bgcolor="#CCCCCC" class="bcgl1txt1B">Buyer PO </td>
<td height="31" colspan="2" bgcolor="#CCCCCC" class="bcgl1txt1B style1">Description</td>
<td bgcolor="#CCCCCC" class="bcgl1txt1B">Order#/ Sty #</td>
<?php 
if ($SCRequiredForPODetails == "true")
{
?>
<td bgcolor="#CCCCCC" class="bcgl1txt1B" width="6%">SC NO</td>
<?php
}
if ($MatRatioIDRequiredForPoDetails == "true")
{
?>
<td bgcolor="#CCCCCC" class="bcgl1txt1B">Item Code</td>
<?php
}
if ($DeliveryDateRequiredForDetails == "true")
{
?>
<td bgcolor="#CCCCCC" class="bcgl1txt1B">Del Date</td>
<?php
}
?>

<td bgcolor="#CCCCCC" class="bcgl1txt1B">SIZE</td>
<td bgcolor="#CCCCCC" class="bcgl1txt1B">COLOR</td>
<td bgcolor="#CCCCCC" class="bcgl1txt1B">UNIT</td>
<td bgcolor="#CCCCCC" class="bcgl1txt1B">Unit Price <br />(<?php echo GetCurrencyName($Currency); ?>) </td>
<td width="8%" bgcolor="#CCCCCC" class="bcgl1txt1B">Ex QTY</td>

</tr>
<?php
$totRATE_USD=0.0;
$totVALUE=0.0;
$totqty=0.0;


/*echo  $SL_PODATA = "SELECT
matitemlist.strItemDescription,
matitemlist.intItemSerial,
purchaseorderdetails_excess.strBuyerPONO,
purchaseorderdetails_excess.dtmItemDeliveryDate,
purchaseorderdetails_excess.strSize,
purchaseorderdetails_excess.dblAdditionalQty,
purchaseorderdetails_excess.intYear,
purchaseorderdetails_excess.strColor,
purchaseorderdetails_excess.strUnit,
purchaseorderdetails_excess.dblUnitPrice,
purchaseorderdetails_excess.dblQty,
purchaseorderdetails_excess.intPoNo,
purchaseorderdetails_excess.strRemarks,
purchaseorderdetails_excess.intPOType,
orders.strOrderNo,
orders.strStyle as strStyleID,
orders.intStyleId,
specification.intSRNO,
materialratio.materialRatioID
FROM
(purchaseorderdetails_excess)
left Join matitemlist ON matitemlist.intItemSerial = purchaseorderdetails_excess.intMatDetailID
left Join orders ON purchaseorderdetails_excess.intStyleId = orders.intStyleId
left join specification on purchaseorderdetails_excess.intStyleId = specification.intStyleId
left join materialratio on purchaseorderdetails_excess.intStyleId = materialratio.intStyleId and purchaseorderdetails_excess.intMatDetailID = materialratio.strMatDetailID and purchaseorderdetails_excess.strColor = materialratio.strColor and purchaseorderdetails_excess.strSize = materialratio.strSize aND purchaseorderdetails_excess.strBuyerPONO = materialratio.strBuyerPONO
WHERE (((purchaseorderdetails_excess.intGrnNo)='$intPoNo')) and (((purchaseorderdetails_excess.intGrnYear)='$intYear'))";
*/

$SL_PODATA = "SELECT DISTINCT
matitemlist.strItemDescription,
matitemlist.intItemSerial,
purchaseorderdetails_excess.strBuyerPONO,
purchaseorderdetails_excess.dtmItemDeliveryDate,
purchaseorderdetails_excess.strSize,
purchaseorderdetails_excess.dblAdditionalQty,
purchaseorderdetails_excess.intYear,
purchaseorderdetails_excess.strColor,
purchaseorderdetails_excess.strUnit,
purchaseorderdetails_excess.dblUnitPrice,
purchaseorderdetails_excess.dblQty,
purchaseorderdetails_excess.intPoNo,
purchaseorderdetails_excess.strRemarks,
purchaseorderdetails_excess.intPOType,
orders.strOrderNo,
orders.strStyle AS strStyleID,
orders.intStyleId,
specification.intSRNO,
materialratio.materialRatioID,
purchaseorderdetails.dblQty AS `pending_Qty`,
grndetails.dblQty AS `received_Qty`
FROM
(purchaseorderdetails_excess)
LEFT JOIN matitemlist ON matitemlist.intItemSerial = purchaseorderdetails_excess.intMatDetailID
LEFT JOIN orders ON purchaseorderdetails_excess.intStyleId = orders.intStyleId
LEFT JOIN specification ON purchaseorderdetails_excess.intStyleId = specification.intStyleId
LEFT JOIN materialratio ON purchaseorderdetails_excess.intStyleId = materialratio.intStyleId AND purchaseorderdetails_excess.intMatDetailID = materialratio.strMatDetailID AND purchaseorderdetails_excess.strColor = materialratio.strColor AND purchaseorderdetails_excess.strSize = materialratio.strSize AND purchaseorderdetails_excess.strBuyerPONO = materialratio.strBuyerPONO
INNER JOIN grnheader ON grnheader.intGrnNo = purchaseorderdetails_excess.intGrnNo
INNER JOIN grndetails ON grndetails.intGrnNo = grnheader.intGrnNo AND grndetails.intGRNYear = grnheader.intGRNYear AND grndetails.intGrnNo = purchaseorderdetails_excess.intGrnNo AND grndetails.intGRNYear = purchaseorderdetails_excess.intGrnYear AND grndetails.intStyleId = purchaseorderdetails_excess.intStyleId AND grndetails.strBuyerPONO = purchaseorderdetails_excess.strBuyerPONO AND grndetails.intMatDetailID = purchaseorderdetails_excess.intMatDetailID AND grndetails.strColor = purchaseorderdetails_excess.strColor AND grndetails.strSize = purchaseorderdetails_excess.strSize
INNER JOIN purchaseorderdetails ON purchaseorderdetails_excess.intPoNo = purchaseorderdetails.intPoNo AND purchaseorderdetails_excess.intYear = purchaseorderdetails.intYear AND purchaseorderdetails_excess.intStyleId = purchaseorderdetails.intStyleId AND purchaseorderdetails_excess.intMatDetailID = purchaseorderdetails.intMatDetailID AND purchaseorderdetails_excess.strColor = purchaseorderdetails.strColor AND purchaseorderdetails_excess.strSize = purchaseorderdetails.strSize AND purchaseorderdetails_excess.strBuyerPONO = purchaseorderdetails.strBuyerPONO
WHERE (((purchaseorderdetails_excess.intGrnNo)='$intPoNo')) 
and (((purchaseorderdetails_excess.intGrnYear)='$intYear'))";


$result_podata = $db->RunQuery($SL_PODATA);

			
			
while($row_podata = mysql_fetch_array($result_podata ))
{

	
	$newItemDeliveryDate=substr($row_podata["dtmItemDeliveryDate"],-19,10);
	$totRATE_USD+=$row_podata["dblUnitPrice"];
	$totVALUE+=$row_podata["dblUnitPrice"]*($row_podata["dblQty"] + $row_podata["dblAdditionalQty"]);
	$totqty+=($excessQty + $row_podata["dblAdditionalQty"]);
	$excessQty = $row_podata["received_Qty"] - (($row_podata["pending_Qty"] * 0.05) + $row_podata["pending_Qty"]);

	
	
		if($row_podata["intPOType"]==1)
			$strDescription = $row_podata["strItemDescription"] . " - " . $row_podata["strRemarks"] . "<font class=\"error1\"> -Freight </font>";
		else
			$strDescription = $row_podata["strItemDescription"] . " - " . $row_podata["strRemarks"];

		$styID = $row_podata["strStyleID"];
		$matCode = $row_podata["intItemSerial"];
		$costingPrice = $row_podata["dblUnitPrice"];
		$sqlPricediff = "SELECT dblUnitPrice FROM specificationdetails WHERE strStyleID = '$styID' AND strMatDetailID = '$matCode' ";

		$resultcost = $db->RunQuery($sqlPricediff);
		while($rowcost = mysql_fetch_array($resultcost))
		{
			$costingPrice = $rowcost["dblUnitPrice"];
			break;
		}
		$purchasedPrice = round($row_podata["dblUnitPrice"],4) / $currencyRate;
	
?>
<tr <?php if ($poStatus == 1 && $costingPrice < $purchasedPrice && $HighLightOverCostPO == "true") {?> bgcolor="#FF6633" <?php } ?>>
<td class="normalfntTAB9"><?php if($excessQty>0)echo $row_podata["strBuyerPONO"]; ?></td>

<!--	   <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr>-->
<td colspan="2" class="normalfntTAB9" id="<?php echo $matCode;?>"><?php if($excessQty>0)echo $strDescription  ;  ?></td>
<td class="normalfntTAB9" id="<?php echo $row_podata["intStyleId"];?>"><?php if($excessQty>0) echo $row_podata["strOrderNo"]."/".$row_podata["strStyleID"]; ?><table width="100%" border="0" cellpadding="0"><tr>
<td width="45%"></td><td width="6%"></td>
<td width="49%"></td></tr></table></td>
<?php 
if ($SCRequiredForPODetails == "true")
{
?>
<td class="normalfntMidTAB9"><?php echo $row_podata["intSRNO"]; ?></td>
<?php
}
if ($MatRatioIDRequiredForPoDetails == "true")
{
?>
<td class="normalfntMidTAB9"><?php echo $row_podata["materialRatioID"]; ?></td>
<?php
}
if ($DeliveryDateRequiredForDetails == "true")
{
?>
<td class="normalfntMidTAB9"><?php echo $newItemDeliveryDate; ?></td>
<?php
}
?>

<td class="normalfntMidTAB9"><?php if($excessQty>0)echo $row_podata["strSize"]; ?></td>
<td class="normalfntMidTAB9"><?php if($excessQty>0)echo $row_podata["strColor"]; ?></td>
<td class="normalfntMidTAB9"><?php if($excessQty>0) echo $row_podata["strUnit"]; ?></td>
<td class="normalfntMidTAB9"><div align="right"><?php
//if ($poStatus == 1 && $costingPrice < $purchasedPrice && $HighLightOverCostPO == "true")
//{
//echo "[" . number_format($costingPrice,4) . "] ";
//}			
//echo number_format($row_podata["dblUnitPrice"],4); 

if($excessQty>0)
 echo number_format(0,4);	
?></div></td>
<td class="normalfntMidTAB9">
	<div align="right">
		<?php  //echo round($row_podata["dblQty"] + $row_podata["dblAdditionalQty"]); 
		
			if($excessQty>0)
				echo round($excessQty);
			
		?>
    </div>
<?php
if($poStatus == 1 && $HighlightAdditionalPurchase == "true" && $row_podata["dblAdditionalQty"] > 0 )
{
echo "<br><div align=\"right\" class=\"error1\">(" . round($row_podata["dblQty"]) . "+" . round($row_podata["dblAdditionalQty"]). ")</div>";

}			
?>			
</td>

</tr>
<?php
}
?>
<tr>
<td height="25">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</table></td>
</tr>
<tr>
<td colspan="4" bgcolor="#CCCCCC"><table width="100%" border="0" cellpadding="0">
<tr>
<td width="86%" class="bigfntnm1mid">Total</td>
<td width="7%" class="bigfntnm1mid"><?php //echo number_format(round($totVALUE,2),2); 
							echo number_format(round(0,2),2);?></td>
<td width="7%" class="bigfntnm1rite"><?php echo round($totqty);?></td>
</tr>
</table></td>
</tr>
<tr>
<td height="25" colspan="4" class="normalfnth2B"><?php
//$num=100005;
$totVarValue=convert_number(round($totVALUE,2));
function convert_number($number) 
{ 
if (($number < 0) || ($number > 999999999)) 
{ 
return "$number"; 
} 

$Gn = floor($number / 1000000);  /* Millions (giga) */ 
$number -= $Gn * 1000000; 
$kn = floor($number / 1000);     /* Thousands (kilo) */ 
$number -= $kn * 1000; 
$Hn = floor($number / 100);      /* Hundreds (hecto) */ 
$number -= $Hn * 100; 
$Dn = floor($number / 10);       /* Tens (deca) */ 
$n = $number % 10;               /* Ones */ 
//	    $Dn = floor($number / 10);       /* -10 (deci) */ 
//   $n = $number % 100;               /* .0 */ 
//	    $Dn = floor($number / 10);       /* -100 (centi) */ 
//   $n = $number % 1000;               /* .00 */ 

$res = ""; 

if ($Gn) 
{ 
$res .= convert_number($Gn) . " Million"; 
} 

if ($kn) 
{ 
$res .= (empty($res) ? "" : " ") . 
convert_number($kn) . " Thousand"; 
} 

if ($Hn) 
{ 
$res .= (empty($res) ? "" : " ") . 
convert_number($Hn) . " Hundred"; 
} 

$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
"Nineteen"); 
$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
"Seventy", "Eighty", "Ninety"); 

if ($Dn || $n) 
{ 
if (!empty($res)) 
{ 
$res .= " and "; 
} 

if ($Dn < 2) 
{ 
$res .= $ones[$Dn * 10 + $n]; 
} 
else 
{ 
$res .= $tens[$Dn]; 

if ($n) 
{ 
$res .= "-" . $ones[$n]; 
} 
} 
} 

if (empty($res)) 
{ 
$res = "zero"; 
} 

return $res; 


} 

//$convrt=substr(round($totVALUE,2),-2);
$convrt = explode(".",round($totVALUE,2));

$cents =  $convrt[1];
if ($cents < 10)
$cents = $convrt[1] . "0";

$centsvalue=centsname($cents);
function centsname($number)
{		
$Dn = floor($number / 10);       /* -10 (deci) */ 
$n = $number % 10;               /* .0 */ 

$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
"Nineteen"); 
$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
"Seventy", "Eighty", "Ninety"); 

if ($Dn || $n) 
{ 
if (!empty($res)) 
{ 
$res .= " and "; 
} 

if ($Dn < 2) 
{ 
$res .= $ones[$Dn * 10 + $n]; 
} 
else 
{ 
$res .= $tens[$Dn]; 

if ($n) 
{ 
$res .= "-" . $ones[$n]; 
} 
} 
} 

if (empty($res)) 
{ 
$res = "zero"; 
} 

return $res; 

}


echo $totVarValue." $currencyTitle and ".$centsvalue ." $currencyFraction only.";
?></span></td>
</tr>  
<tr>
<td colspan="4">&nbsp;</td>
</tr>

<tr>
<td colspan="4">
<?php include "$InstructionFile"; ?>
</td>
</tr>
<tr>
<td colspan="4"><table width="100%" border="0" align="center" cellpadding="0">
<tr>
<td width="14%" class="normalfnt2bldBLACKmid">PREPARED BY</td>
<td >&nbsp;</td>
<td width="21%" class="normalfnt2bldBLACKmid">CHECKED BY</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td >&nbsp;</td>
<td >&nbsp;</td>
</tr>
<tr>
<td width="14%" class="normalfntTAB2">
<?php 

$SQL_User="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$UserID."));
";
$result_User = $db->RunQuery($SQL_User);
if($row_user = mysql_fetch_array($result_User))
{
echo $row_user["Name"];
}

?>        </td>
<td width="11%">&nbsp;</td>
<td width="21%" class="normalfntTAB2">
<?php 
$SQL_Checked="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$CheckedID."));
";
$result_Checked = $db->RunQuery($SQL_Checked);
if($row_check = mysql_fetch_array($result_Checked))
{
echo $row_check["Name"];
}
?>       </td>
<td width="9%">&nbsp;</td>
<td width="19%" class="normalfntTAB2"><?php 
$SQL_Autho="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$AuthorisedID."));
";

$result_Autho = $db->RunQuery($SQL_Autho);
$AuthorizedName = "";
if($row_Autho = mysql_fetch_array($result_Autho))
{
$AuthorizedName =  $row_Autho["Name"];
}

if ($ShowAccountsManager != "true")
echo $AuthorizedName;
?></td>
<td width="9%"></td>
<td width="17%" class="normalfntTAB2"><?php
if ($ShowAccountsManager == "true" && $poStatus=="10")
echo $AuthorizedName;
?></td>
</tr>
<tr>
<td width="14%" class="normalfnt2bldBLACKmid"><span class="normalfnth2Bm">Merchandiser</span></td>
<td class="normalfnth2Bm">&nbsp;</td>
<td width="21%" class="normalfnth2Bm">Merchandising Manager</td>
<td class="normalfnth2Bm">&nbsp;</td>
<td class="normalfnth2Bm">
Authorized By </td>
<td class="normalfnt2bldBLACKmid">&nbsp;</td>
<td class="normalfnth2Bm">Account Manager </td>
</tr>
<tr>
<td class="normalfnt2bldBLACKmid">&nbsp;</td>
<td class="normalfnth2Bm">&nbsp;</td>
<td class="normalfnt2bldBLACKmid">&nbsp;</td>
<td class="normalfnth2Bm">&nbsp;</td>
<td class="normalfnth2Bm">&nbsp;</td>
<td class="normalfnt2bldBLACKmid"><div align="center"></div></td>
<td class="normalfnt2bldBLACKmid">&nbsp;</td>
</tr>
</table></td>
</tr>
<tr>
<td colspan="4">&nbsp;</td>
</tr>
</table>
<?php
function GetCurrencyName($currencyId)
{
global $db;
	$sql="select strCurrency from currencytypes  where intCurID='$currencyId'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strCurrency"];
}
if ($intPrintStatus == 0 && $poStatus == 10)
{
$sql = "update purchaseorderheader_excess set intPrintStatus = 1 where intPONo = '$intPoNo' and intYear = '$intYear';";
$db->ExecuteQuery($sql);
}

?>
</body>
</html>
