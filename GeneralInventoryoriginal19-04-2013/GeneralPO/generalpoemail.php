<?php
session_start();
ob_start();
include "../../Connector.php";
$xml = simplexml_load_file('../../config.xml');
$showAuthorizedBy = $xml->GeneralInventory->GeneralPO->ShowAuthorizedBy;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Eplan Web - Genaral Po :: Report</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	.style4 {
		font-size: xx-large;
		color: #FF0000;
	}
	.style3 {
		font-size: xx-large;
		color: #FF0000;
	}
</style>
<style type="text/css">
.normalfnt {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.txtbox {
	font-family: Verdana;
	font-size: 11px;
	color: #20407B;
	border: 1px solid #abceea;
	text-align:left;
}
.txtboxgray {
	font-family: Verdana;
	font-size: 11px;
	color: #20407B;
	border: 1px solid #999999;
	text-align:left;
}
.txtboxbackcolor {
	font-family: Verdana;
	font-size: 11px;
	color: #20407B;
	border: 1px solid #999999;
	text-align:left;
	background-color: #CCCCCC;
}
.normalfnth2 {
	font-family: Verdana;
	font-size: 11px;
	color: #1164A8;
	font-weight: bold;
}
.normaltxtmidb2 {
	font-family: Verdana;
	font-size: 11px;
	color: #FFFFFF;
	margin: 0px;
	font-weight: bold;
	text-align: center;
}
.bcgl1 {
	border: 1px solid #C9DFF1;
}

.head1 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #0E4874;
	margin: 0px;
}
.tophead {
	font-family: "Century Gothic";
	font-size: 24px;
	font-weight: normal;
	color: #244893;
	margin: 0px;
}
.normalfntRite {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: right;
}
.normalfntMid {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.bodertopb {
	border-top-width: 1pt;
	border-right-width: 1pt;
	border-bottom-width: 1pt;
	border-left-width: 1pt;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: solid;
	border-left-style: solid;
	border-top-color: #9BBFDD;
	border-right-color: #FFFFFF;
	border-bottom-color: #FFFFFF;
	border-left-color: #FFFFFF;
}
.bcgl1Txt {
	border: 1px solid #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
	color: #FFFFFF;
	text-align: center;
}
.bcgl1Txt2 {
	border: 1px solid #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	font-weight: normal;
	color: #D6E7F5;
	text-align: center;
}
.bcgl1wf {
	border: 1px solid #C9DFF1;
	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
	color: #FFFFFF;
	text-align: center;
}
.normalfnt2 {
	font-family: Arial;
	font-size: 10pt;
	color: #1E5E9D;
	margin: 0px;
}
.normalfnt2bld {
	font-family: Arial;
	font-size: 10pt;
	color: #164574;
	margin: 0px;
	font-weight: bold;
}
.error1 {
	font-family: Verdana;
	font-size: 10px;
	font-weight: bold;
	color: #FF0000;
}

.bcgl1txt1 {
	border: 1px solid #666666;
	font-family: Verdana;
	font-size: 10px;
	font-weight: normal;
	color: #000000;
	text-align: center;
}
.bcgl1txt1B {
	border: 1px solid #666666;
	font-family: Verdana;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
	text-align: center;
}
.bcgl1txt1NB {
	font-family: Verdana;
	font-size: 10px;
	font-weight: bold;
	color: #000000;
	text-align: left;
}
.head2 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16pt;
	font-weight: bold;
	color: #052B45;
	margin: 0px;
	text-align: center;
}
.normalfnt2BI {
	font-family: Tahoma;
	font-size: 10px;
	color: #164574;
	margin: 0px;
	font-weight: bold;
	font-style: normal;
}
.specialFnt1 {
	font-family: Verdana;
	font-size: 10px;
	color: #999999;
	margin: 0px;
	text-align: right;
}
.nfhighlite1 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	border-top-width: 2px;
	border-right-width: 1px;
	border-bottom-width: 2px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: double;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #666666;
	border-bottom-color: #000000;
	border-left-color: #666666;
	text-align: right;
}
.nfhighlite2 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	font-weight: bold;
	border-top-width: 2px;
	border-right-width: 1px;
	border-bottom-width: 2px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: double;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #999999;
	border-bottom-color: #000000;
	border-left-color: #999999;
	text-align: center;
}
.normalfnBLD1 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
}
.tablez {
	border: 1px solid #666666;
}
.normalfntTAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	border: 1px solid #999999;
	vertical-align: top;
}
.normalfntMidTAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: center;
	border: 1px solid #999999;
	vertical-align: top;
}
.normalfntRiteTAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: right;
	border: 1px solid #999999;
	vertical-align: top;
}
.normalfnt2BITAB {
	font-family: Tahoma;
	font-size: 10px;
	color: #000000;
	font-weight: bold;
	font-style: normal;
	border: 1px solid #999999;
	background-color: #BED6E9;
}
.normalfnBLD1TAB {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
	border: 1px solid #999999;
}
.normalfntBtab {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
	background-color: #CCCCCC;
	border: 1px solid #666666;
	text-align: center;
}
.bigfntnm1 {
	font-family: Arial;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
}
.bigfntnm1mid {
	font-family: Arial;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align: center;
}
.bigfntnm1rite {
	font-family: Arial;
	font-size: 14px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align: right;
}
.normalfnt2bldBLACK {
	font-family: Arial;
	font-size: 10pt;
	color: #000000;
	margin: 0px;
	font-weight: bold;
}
.normalfnt2Black {
	font-family: Arial;
	font-size: 10pt;
	color: #000000;
	margin: 0px;
}
.topheadBLACK {
	font-family: "Century Gothic";
	font-size: 24px;
	font-weight: normal;
	color: #000000;
	margin: 0px;
}
.head2BLCK {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16pt;
	font-weight: bold;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.normalfnth2B {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
}
.normalfntTAB2 {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 1px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: dotted;
	border-left-style: none;
	border-bottom-color: #333333;
	text-align: center;
}
.normalfnt2bldBLACKmid {
	font-family: Arial;
	font-size: 10pt;
	color: #000000;
	margin: 0px;
	font-weight: bold;
	text-align: center;
}
.normalfnth2Bm {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	font-weight: bold;
	text-align: center;
}
.tablezRED {
	border: 1px solid #DC8714;
	background-color: #F8DDB6;
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
}
.fntwithWite {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-align:left;
}

.PopoupTitleclass {
	font-family: Arial;
	font-size: 14pt;
	font-weight: normal;
	color: #ffffff;
	margin: 0px;
	text-align: left;
}.TitleN2white {
	font-family: Tahoma;
	font-size: 14px;
	font-weight: bold;
	color: #ffffff;
	margin: 0px;
	text-align:center;
}
.bcgl2Lbl {
	border: 1px solid #3E81B7;
}
.bcgl2Lblclear {
	border: 1px solid #FFFFFF;
}
.normalfntp2 {
	font-family: Verdana;
	font-size: 10px;
	color: #666666;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.headRed {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	font-weight: bold;
	color: #FF0000;
	margin: 0px;
}
.normalfntp2TAB {
	font-family: Verdana;
	font-size: 10px;
	color: #666666;
	margin: 0px;
	font-weight: normal;
	text-align:left;
	border: 1px solid #CCCCCC;
}
.tablezREDMid {
	border: 1px solid #666666;
	background-color: #CCCCCC;
	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	text-align: center;
	font-weight: bold;
}

.backgroundSelecterStyle{
   -moz-opacity: 0.5;
   background-color: #000000;
   color: #0066ff;
   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=5);
   font-family: Verdana;
   font-size: 8pt
}
.noborderforlink {
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
}

.normaltxtmidb2L {
	font-family: Verdana;
	font-size: 11px;
	color: #FFFFFF;
	margin: 0px;
	font-weight: bold;
	text-align: left;
}
.normaltxtmidb2R {
	font-family: Verdana;
	font-size: 11px;
	color: #FFFFFF;
	margin: 0px;
	font-weight: bold;
	text-align: right;
}

.mouseover {
	cursor: pointer;
}

.mousewait{
	cursor:wait;
}
.backgroundcancel{
	background-image:url(../images/cancel.jpg)
}
.backcolorYellow {
    background-color: #FDEAA8;
}

.backcolorGreen {
    background-color: #DDF3DA;
}

.backcolorWhite {
    background-color: #FFFFFF;
}
.normalfntSM {

	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	font-weight: normal;
	text-align:left;
}
.normalfntMidSML {

	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	text-align: center;
}
.normalfntRiteSML {

	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	text-align: right;
}
.normalfntSMB {
	font-family: Verdana;
	font-size: 10px;
	color: #000000;
	margin: 0px;
	font-weight: bold;
	text-align:left;
}
.normalfntRiteTABb-ANS {
	font-family: Verdana;
	font-size: 11px;
	color: #000000;
	margin: 0px;
	text-align: right;
	vertical-align: top;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: solid;
	border-bottom-style: double;
	border-left-style: solid;
	border-top-color: #000000;
	border-right-color: #666666;
	border-bottom-color: #000000;
	border-left-color: #666666;
	font-weight: bold;
}
.color1 {
	background-color: #FFFF00;
	border: 1px solid #333333;
}
.color2 {
	background-color: #999999;
	border: 1px solid #333333;
}
.color3 {
	background-color: #FFCC00;
	border: 1px solid #333333;
}
.color4 {
	background-color: #00CC00;
	border: 1px solid #333333;
}
.color5 {
	background-color: #00CCFF;
	border: 1px solid #333333;
}
.color6 {
	background-color: #FF99FF;
	border: 1px solid #333333;
}
.color7 {
	background-color: #FF0000;
	border: 1px solid #333333;
}
.osc1 {
	background-color: #CCCCCC;
	border: 1px solid #333333;
}
.osc2 {
	background-color: #99FF99;
	border: 1px solid #333333;
}
.osc3 {
	background-color: #FFFF99;
	border: 1px solid #333333;
}
.osc4 {
	background-color: #FF99FF;
	border: 1px solid #333333;
}
.bcgcolor {
	background-color: #D8E4F3;
}
.bcgcolor-row {
	background-color: #265275;
}
.bcgcolor-tblrow {
	background-color: #FFFFCC;
}
.bcgcolor-highlighted {
	background-color: #99CCFF;
}
.cursercross{
cursor:move;
}
.notvalidreport {
	background-image: url(../images/not-valid.png);
}
.normalfntTAB9 {
	font-family: Verdana;
	font-size: 9px;
	color: #000000;
	margin: 0px;
	border: 1px solid #999999;
	vertical-align: top;
}

.normalfntMidTAB9 {
	font-family: Verdana;
	font-size: 9px;
	color: #000000;
	margin: 0px;
	text-align: center;
	border: 1px solid #999999;
	vertical-align: top;
}

</style>
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

function sendEmail()
{
	var year = <?php echo  $_GET["intYear"];?>;
	var poNo = <?php echo  $_GET["bulkPoNo"];?>;
	var emailAddress = prompt("Please enter the supplier's email address :");
	if (checkemail(emailAddress))
	{	
		createXMLHttpRequest(emailAddress);
		xmlHttp.onreadystatechange = HandleEmail;
		xmlHttp.open("GET", 'generalpoemail.php?pono=' + poNo + '&year=' + year + '&supplier=' + emailAddress, true);
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
</head>

<body>
<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="24%"><img src="http://localhost/eplan/images/eplan_logo.png" alt="eplanLogo" width="191" height="47" class="normalfnt" /></td>
        <td width="5%" class="normalfnt">&nbsp;</td>
        <td width="59%" class="tophead"><p class="topheadBLACK"><?php
	
			$bulkPoNo=$_GET["pono"];
			$intYear=$_GET["year"];

		$strSQL="		SELECT
						generalpurchaseorderheader.intGenPONo,
						generalpurchaseorderheader.intYear,
						generalpurchaseorderheader.dtmDate,
						generalpurchaseorderheader.intStatus,
						generalpurchaseorderheader.dtmDeliveryDate,
						generalpurchaseorderheader.strCurrency,
						companies.strName AS strName,
						companies.strAddress1 AS strAddress1,
						companies.strAddress2 AS strAddress2,
						companies.strStreet AS strStreet,
						companies.strCity AS strCity,
						companies.strCountry AS strCountry,
						companies.strPhone AS strPhone,
						companies.strEMail AS strEmail,
						companies.strFax AS strFax,
						companies.strWeb AS strWeb,
						popaymentmode.strDescription AS strPaymentMode,
						popaymentterms.strDescription AS strPayTerm,
						generalpurchaseorderheader.strPINO,
						generalpurchaseorderheader.strInstructions,
						dtoCompanies.strName AS dtostrName,
						dtoCompanies.strAddress1 AS dtostrAddress1,
						dtoCompanies.strAddress2 AS dtostrAddress2,
						dtoCompanies.strStreet AS dtostrStreet,
						dtoCompanies.strCity AS dtostrCity,
						dtoCompanies.strCountry AS dtostrCountry,
						dtoCompanies.strPhone AS dtostrPhone,
						dtoCompanies.strEMail AS dtostrEmail,
						dtoCompanies.strFax AS dtostrFax,
						dtoCompanies.strWeb AS dtostrWeb,
						invtoCompanies.strName AS invtostrName,
						invtoCompanies.strAddress1 AS invtostrAddress1,
						invtoCompanies.strAddress2 AS invtostrAddress2,
						invtoCompanies.strStreet AS invtostrStreet,
						invtoCompanies.strCity AS invtostrCity,
						invtoCompanies.strCountry AS invtostrCountry,
						invtoCompanies.strPhone AS invtostrPhone,
						invtoCompanies.strEMail AS invtostrEmail,
						invtoCompanies.strFax AS invtostrFax,
						invtoCompanies.strWeb AS invtostrWeb,
						suppliers.strTitle,
						generalpurchaseorderheader.intUserID AS UserID,
						generalpurchaseorderheader.intConfirmedBy AS AuthorizedBy
						FROM
						generalpurchaseorderheader
						Inner Join popaymentmode ON popaymentmode.strPayModeId = generalpurchaseorderheader.intPayMode
						Inner Join popaymentterms ON popaymentterms.strPayTermId = generalpurchaseorderheader.strPayTerm
						Inner Join companies ON companies.intCompanyID = generalpurchaseorderheader.intCompId
						Inner Join companies AS dtoCompanies ON dtoCompanies.intCompanyID = generalpurchaseorderheader.intDeliverTo
						Inner Join companies AS invtoCompanies ON invtoCompanies.intCompanyID = generalpurchaseorderheader.intInvoiceComp
						Inner Join suppliers ON generalpurchaseorderheader.intSupplierID = suppliers.strSupplierID
						WHERE
						generalpurchaseorderheader.intGenPONo =  '$bulkPoNo' AND
						generalpurchaseorderheader.intYear =  '$intYear'
						";
				
				
					$result = $db->RunQuery($strSQL);
					
		
		while($row = mysql_fetch_array($result))
		{		
						$strBulkPONo		=$row["strBulkPONo"];
						$intYear			=$row["intYear"];
						$strName			=$row["strName"];
						$strAddress1		=$row["strAddress1"];
						$strAddress2		=$row["strAddress2"];
						$strStreet			=$row["strStreet"];
						$strCity			=$row["strCity"];
						$strCountry			=$row["strCountry"];
						$strPhone			=$row["strPhone"];
						$strEmail			=$row["strEmail"];
						$strFax				=$row["strFax"];
						$strWeb				=$row["strWeb"];
						$dtmDate				=$row["dtmDate"];
						$dtmDeliveryDate		=$row["dtmDeliveryDate"];
						$strCurrency		=$row["strCurrency"];
						$strPaymentMode		=$row["strPaymentMode"];
						$strInstructions = $row["strInstructions"];
						//$strShipmentTerm	=$row["strShipmentTerm"];
						$strPayTerm			=$row["strPayTerm"];
						$strPINO			=$row["strPINO"];
						$intStatus			=$row["intStatus"];
						$dtostrName			=$row["dtostrName"];
						$dtostrAddress1		=$row["dtostrAddress1"];
						$dtostrAddress2		=$row["dtostrAddress2"];
						$dtostrStreet		=$row["dtostrStreet"];
						$dtostrCity			=$row["dtostrCity"];
						$dtostrCountry		=$row["dtostrCountry"];
						$dtostrPhone		=$row["dtostrPhone"];
						$dtostrEmail		=$row["dtostrEmail"];
						$dtostrFax			=$row["dtostrFax"];
						$dtostrWeb			=$row["dtostrWeb"];
						$invtostrName		=$row["invtostrName"];
						$invtostrAddress1	=$row["invtostrAddress1"];
						$invtostrAddress2	=$row["invtostrAddress2"];
						$invtostrStreet		=$row["invtostrStreet"];
						$invtostrCity		=$row["invtostrCity"];
						$invtostrCountry	=$row["invtostrCountry"];
						$invtostrPhone		=$row["invtostrPhone"];
						$invtostrEmail		=$row["invtostrEmail"];
						$invtostrFax		=$row["invtostrFax"];
						$invtostrWeb		=$row["invtostrWeb"];
						$strSupplierTitle 	= $row["strTitle"];
						$UserID 			= $row["UserID"];
						//$CheckedID 			= $row["CheckedID"];
						$AuthorisedID 		= $row["AuthorizedBy"];
						break;
		}
		
			echo $strName ?></p>
          <p class="normalfnt"><?PHP echo "$strAddress1 $strAddress2  $strStreet $strCity $strCountry . Tel: $strPhone  Fax: $strFax" ?> </p>
          <p class="normalfnt"><?php echo "E-Mail: $strEmail Web: $strWeb" ?></p></td>
        <td width="12%" class="tophead">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="5" class="head2"><p>GENERAL PURCHASE ORDER</p>
          <p>PO NO - <?php echo "$intYear/$bulkPoNo "?></p></td>
      </tr>
      <tr>
        <td colspan="2" class="normalfnth2B"> <?php echo $strSupplierTitle ?></td>
        <td width="6%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">DELIVER TO:</td>
        <td width="27%" rowspan="4" valign="top" class="normalfnt"><?php echo "$dtostrName <br/> $dtostrAddress1 <br/> $dtostrAddress2 <br/> $dtostrStreet  <br> $dtostrCountry" ?></td>
      </tr>
      <tr>
        <td width="16%" class="normalfnth2B">P.O DATE</td>
        <td width="32%" class="normalfnt">: <?php echo substr("$dtmDate",0,10) ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">DELIVER DATE</td>
        <td class="normalfnt">: <?php echo substr("$dtmDeliveryDate",0,10) ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">PAYMENT MODE</td>
        <td class="normalfnt">: <?php echo "$strPaymentMode" ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">PAYMENT TERMS</td>
        <td class="normalfnt">: <?php echo "$strPayTerm" ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">INVOICE TO</td>
        <td rowspan="3" valign="top" class="normalfnt"><?php echo "$invtostrName <br/> $invtostrAddress1 <br/> $invtostrAddress2 <br/> $invtostrStreet  <br> $invtostrCountry" ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">INSTRUCTIONS</td>
        <td rowspan="2" align="left" valign="top" class="normalfnt">: <?php echo $strInstructions; ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td height="26" class="normalfnth2B" style="text-align:center"> <?php 
		
		if($intStatus==10)
		{
			//echo "<span class=\"style4\">Cancelled General Po ";
		}
		elseif($intStatus==0)
		{
			echo "<span class=\"head2\">Not Approved";
		}
		?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="35%" height="25" class="normalfntBtab">DESCRIPTION</td>
        <td width="7%" class="normalfntBtab">UNIT</td>
        <td width="10%" class="normalfntBtab">RATE</td>
        <td width="8%" class="normalfntBtab">QTY</td>
        <td width="15%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
      <tr>
	  <?php 
	  	$strSQL = "SELECT
					generalpurchaseorderdetails.strUnit,
					generalpurchaseorderdetails.dblUnitPrice,
					generalpurchaseorderdetails.dblQty,
					genmatitemlist.strItemDescription as itemDescription
					FROM
					generalpurchaseorderdetails
					Inner Join genmatitemlist ON genmatitemlist.intItemSerial = generalpurchaseorderdetails.intMatDetailID
					WHERE
					generalpurchaseorderdetails.intGenPONo =  '$bulkPoNo' AND
					generalpurchaseorderdetails.intYear =   '$intYear'";
				
	  	$result = $db->RunQuery($strSQL);
		while($row = mysql_fetch_array($result))
		{
				$strDescription		=$row["itemDescription"];
				$strUnit			=$row["strUnit"];
				$dblUnitPrice		=$row["dblUnitPrice"];
				$dblQty				=$row["dblQty"];
				$totQty				+=$row["dblQty"];
	  
	  ?>
        <td class="normalfntTAB"><?php echo $strDescription  ?></td>
        <td class="normalfntTAB"><?php echo $strUnit  ?></td>
        <td class="normalfntMidTAB">
		<?php
			echo number_format($dblUnitPrice,4,".",",") ;
			//echo number_format($dblUnitPrice,2,".",",").  "(" . $strCurrency  . ")";
		?></td>
        <td class="normalfntRiteTAB"><?php echo $dblQty  ?></td>
        <td class="normalfntRiteTAB"><?php 
		
		$dblTotal =  $dblUnitPrice * $dblQty ;
		echo number_format($dblTotal,2,".",",");
		//echo number_format($dblTotal,2,".",",").  "(" . $strCurrency  . ")";
		$dblGrandTotal +=$dblTotal;
		  ?></td>
        </tr>
		<?php 
		
		}
		
		?>
      <tr>
			<td colspan="3" class="normalfntBtab">Grand Total</td>
			<td class="bigfntnm1rite" bgcolor="#CCCCCC"><?php echo $totQty  ?></td>
			<td class="bigfntnm1rite" bgcolor="#CCCCCC">
			<?php
				//$dblGrandTotal = number_format($dblGrandTotal,2,".",",");
				//echo $dblGrandTotal .  "(" . $strCurrency  . ")";
				if ($strCurrency != "")
				{
					$strCurrency = "(" . $strCurrency  . ")";
				}
					echo $strCurrency . number_format($dblGrandTotal,2,".",",");

			?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnth2B">Please supply accordance with the instructions herein the following:</td>
  </tr>
  <tr>
    <td colspan="2"><p class="normalfnth2B">Please indicate our PO No in all invoices, performa invoices, dispatch notes and all correspondance and deliver to above mentioned destination and invoice to the correct party.</p>
      <p class="normalfnth2B">Payment will be made in accordance with the stipulated quantities, prices and agreed terms and conditins.</p></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0">
      <tr>
        <td width="13%" rowspan="2" class="normalfnt2bldBLACKmid">PREPARED BY :</td>
        <td width="17%" class="normalfntTAB2">
		<?php 
		
		$SQL_User="SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts
					WHERE (((useraccounts.intUserID)=".$UserID.")); ";
		$result_User = $db->RunQuery($SQL_User);
       if($row_user = mysql_fetch_array($result_User))
	   {
	   		echo $row_user["Name"];
	   }
	
		?>		</td>
        <td width="15%" rowspan="2" class="normalfnt2bldBLACKmid">CHECKED BY:</td>
        <td width="22%" class="normalfntTAB2">
        <?php /*?><?php 
		$SQL_Checked="SELECT useraccounts.Name, useraccounts.intUserID FROM useraccounts 
		WHERE (((useraccounts.intUserID)=".$CheckedID.")); ";
		$result_Checked = $db->RunQuery($SQL_Checked);
       if($row_check = mysql_fetch_array($result_Checked))
	   {
	   		echo $row_check["Name"];
	   }
	?><?php */?>        </td>
        <td width="7%">&nbsp;</td>
        <td width="26%" valign="top" class="normalfntTAB2">
          <?php 
          
          if($showAuthorizedBy == "true")
          {
		$SQL_Autho="SELECT useraccounts.Name, useraccounts.intUserID
FROM useraccounts
WHERE (((useraccounts.intUserID)=".$AuthorisedID."));
";

		
		//echo $AuthorisedID;
		$result_Autho = $db->RunQuery($SQL_Autho);
       if($row_Autho = mysql_fetch_array($result_Autho))
	   {
	   	echo $row_Autho["Name"];
	   }
	   
	   }
	?>         </td>
      </tr>
      <tr>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid">AUTHORISED BY</td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnt2bldBLACKmid"><div align="center"></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><?php 
    
	if($intStatus==0)
	{
		include "../../HeaderConnector.php";
		include "../../permissionProvider.php";
		if($confirmGeneralPO)
			include "genaralpoconfirmation.php";
	}
		
		
		?></td>
  </tr>
</table>
<?php 
if($intStatus==10)
{
?>
<div style="position:absolute; top:200px; left:268px; width: 444px;">
<img src="../../images/cancelled.png" style="-moz-opacity:0.20;filter:alpha(opacity=20);"></div>
<?php
}
?>

</body>
</html>
<?php

	$SQL = "select UserName,Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
	$result = $db->RunQuery($SQL);
	$senderEmail = "";
	$senderName ="";
	while($row = mysql_fetch_array($result))
	{
		$senderEmail = $row["UserName"];
		$senderName = $row["Name"];
	}
	include "EmailSender.php";
	$eml =  new EmailSender();

	$reciever = $_GET["supplier"];
	$subject = "General Purchase Order";
	$body = ob_get_clean();
	$eml->SendMessage($senderEmail,$senderName,$reciever,$subject,$body);
	echo 'true';
?>