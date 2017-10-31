<?php 
session_start();
$invoiceNo=$_GET["InvoiceNo"];
//$itemno=$_GET["itemno"];
include "../../../Connector.php";
$xmldoc=simplexml_load_file('../../../config.xml');
$Company=$xmldoc->companySettings->Declarant;
$Address=$xmldoc->companySettings->Address;
$City=$xmldoc->companySettings->City;
$phone=$xmldoc->companySettings->phone;
$Fax=$xmldoc->companySettings->Fax;
$email=$xmldoc->companySettings->Email;
$Website=$xmldoc->companySettings->Website;
$Country=$xmldoc->companySettings->Country;
$invoiceNo=$_GET['InvoiceNo'];
$gspDate = $_GET['gspDate'];
//$invoiceNo='10250/OTL/09/10';
//$invoiceNo='194/OTL/NY/02/11';
$limitNo=$_GET['limitNo'];
$limitNo =($limitNo==""?0:$limitNo);
//include("invoice_queries.php");	

$refNo=$_GET['refNo'];


			$str_header="SELECT
			commercial_invoice_detail.strBuyerPONo,
			commercial_invoice_detail.strDescOfGoods,
			commercial_invoice_detail.strStyleID,
			commercial_invoice_header.strInvoiceNo,
			buyers.strName AS buyerName,
			buyers.strAddress1 AS buyerAddress1,
			buyers.strAddress2 AS buyerAddress2,
			buyers.strAddress3 AS buyerAddress3,
			buyers.strCountry AS buyerCountry,
			customers.strName AS manufactureName,
			customers.strAddress1 AS manufactureAddress1,
			customers.strAddress2 AS manufactureAddress2,
			customers.strMLocation,
			customers.strCountry AS manufactureCountry,
			Sum(commercial_invoice_detail.dblQuantity) AS dblQuantity,
			ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
			Sum(commercial_invoice_detail.intNoOfCTns) AS intNoOfCTns,
			ROUND(SUM(commercial_invoice_detail.dblGrossMass),2) AS dblGrossMass,
			commercial_invoice_detail.strFabric,
			commercialinvformat.strMMLine1,
			commercialinvformat.strMMLine2,
			commercialinvformat.strMMLine3,
			commercialinvformat.strMMLine4,
			commercialinvformat.strMMLine5,
			commercialinvformat.strMMLine6,
			commercialinvformat.strMMLine7,
			commercialinvformat.strSMLine1,
			commercialinvformat.strSMLine2,
			commercialinvformat.strSMLine3,
			commercialinvformat.strSMLine4,
			commercialinvformat.strSMLine5,
			commercialinvformat.strSMLine6,
			commercialinvformat.strSMLine7,
			commercial_invoice_detail.strHSCode,
			commercial_invoice_header.strFinalDest,
			city.strCountryCode,
			commercial_invoice_header.dtmInvoiceDate,
			country.strCountry,
			commercial_invoice_header.strTransportMode,
			commercial_invoice_detail.strHs_New
			FROM
			commercial_invoice_header
			INNER JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
			INNER JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strBuyerID
			INNER JOIN customers ON customers.strCustomerID = commercial_invoice_header.strCompanyID
			INNER JOIN commercialinvformat ON commercialinvformat.intCommercialInvId = commercial_invoice_header.strComInvFormat
			INNER JOIN city ON city.strCityCode = commercial_invoice_header.strFinalDest
			INNER JOIN country ON country.strCountryCode = city.strCountryCode
			WHERE commercial_invoice_header.strInvoiceNo='$invoiceNo'
			GROUP BY commercial_invoice_header.strInvoiceNo";
			

$result_detail=$db->RunQuery($str_header);
$detail_data_set=mysql_fetch_array($result_detail);

//echo $str_header;

$arrInvDate=$detail_data_set['dtmInvoiceDate'];
$invDate=explode(" ",$arrInvDate);
$ArrayinvYear = 12;	//echo $DescOfGoods;

//echo $detail_data_set['strHs_New'];
//echo $detail_data_set['strHSCode'];
	if( $detail_data_set['strHs_New']!= 0 || '')
		{
				$HsCode=$detail_data_set['strHs_New'];
		}
	else
		{
				$HsCode=$detail_data_set['strHSCode'];	
		}
		
	//echo $HsCode;

	?>
<?php

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
        $res .= convert_number($Gn) . " MILLION"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " THOUSAND"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " HUNDRED"; 
    } 

    $ones = array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", 
        "SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN", 
        "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTTEEN", 
        "NINETEEN"); 
    $tens = array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY", 
        "SEVENTY", "EIGHTY", "NINETY"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
           $res .= " AND "; 
			//$res .= " "; 
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
        $res = "ZERO"; 
    } 

    return $res; 
	
	
} 

//$convrt=substr(round($totVALUE,2),-2);



function centsname($number)
{		
      $Dn = floor($number / 10);       /* -10 (deci) */ 
      $n = $number % 10;               /* .0 */ 
	  
	   $ones = array("", "ONE", "TWO", "THREE", "FOUR", "FIVE", "SIX", 
        "SEVEN", "EIGHT", "NINE", "TEN", "ELEVEN", "TWELVE", "THIRTEEN", 
        "FOURTEEN", "FIFTEEN", "SIXTEEN", "SEVENTEEN", "EIGHTTEEN", 
        "NINETEEN"); 
    $tens = array("", "", "TWENTY", "THIRTY", "FOURTY", "FIFTY", "SIXTY", 
        "SEVENTY", "EIGHTY", "NINETY"); 
        
         if (!empty($number)) 
        { 
            $res .= " AND "; 
        } 

			$chars = preg_split('//', $number, -1, PREG_SPLIT_NO_EMPTY);
			foreach ($chars as $c)
			{
				if($c == "0")
					$res .= " ZERO "; 
				else
					break;
			}
		
 if ($Dn || $n) 
    { 
        

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
        $res = "ZERO"; 
    } 

    return $res; 
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GSP</title>
<link href="../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<link href="dragable/dragable-content.css" rel="stylesheet" type="text/css"/>
<style type="text/css">

.normaltext{
	font-family: Verdana;
	font-size: 12px;
	color: #000000;
	margin: 0px;
	line-height: 10px; 
	font-weight: normal;
	text-align:left;
	
}
.doctext{ 
	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}

.doctext1 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext2 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext11 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext3 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext4 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.adornment11 {border-color:000000; border-style:none; border-bottom-width:0PX; border-left-width:0PX; border-top-width:0PX; border-right-width:0PX; }
.fontColor14 {FONT-SIZE:9PT; ; FONT-FAMILY:Verdana; FONT-WEIGHT:BOLD; }
.doctext5 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext51 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext6 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext61 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext511 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext7 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext611 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext41 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5111 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5112 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext51121 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext511211 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext511212 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext8 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext411 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext412 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5112121 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5112122 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext51111 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext6111 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5112111 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5112112 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5112113 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext51121211 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext61111 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext9 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext51112 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext10 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext12 {	font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext51113 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext511131 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext5111311 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext511111 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext511132 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
.doctext111 {font-family: "Times New Roman", Times, serif;
	font-size:14px;
	color: #000000;
	line-height: 14px; 
	margin: 0px;
	font-weight: normal;
	text-align:left;
	font-weight:500;
}
@media print {
				.hideWhilePrinting { display:none; }
			 }
</style>
<script type="text/javascript">
var rememberPositionedInCookie = true;
var rememberPosition_cookieName = 'certificateOforigin';


</script>
</head>
<?php 
	$strCompany="select 	strCustomerID, 
	intSequenceNo, 
	strName, 
	strAddress1, 
	strAddress2, 
	strCountry, 
	strPhone, 
	strFax, 
	strEMail, 
	strRemarks, 
	strTIN, 
	strCode, 
	strLocation, 
	strTQBNo, 
	strExportRegNo, 
	strRefNo, 
	strCompanyCode, 
	RecordType, 
	strPPCCode, 
	bitLocatedAtAZone, 
	strAuthorizedPerson, 
	strVendorCode, 
	strMIDCode, 
	bitMailClearanceInfo, 
	intDelStatus, 
	strLicenceNo
	 
	from 
	customers 
	where strCustomerID='$exporterid'";
	
	$exresults=$db->RunQuery($strCompany);
	$re=mysql_fetch_array($exresults);
	$exportername=$re['strName'];
	$exAddress1 =$re['strAddress1'];
	$exAddress2 =$re['strAddress2'];
	$Country=$re['strCountry'];
	
	$strbuyer="select 	strBuyerID, 
	strBuyerCode, 
	strName, 
	strAddress1, 
	strAddress2, 
	strCountry, 
	strPhone, 
	strFax, 
	strEMail, 
	strRemarks, 
	strTINNo, 
	intDel
	 
	from 
	buyers 
	where strBuyerID='$buyersid'";
	$resultbuyer=$db->RunQuery($strbuyer);
	$buyer_array=mysql_fetch_array($resultbuyer);
	$buyername=$buyer_array["strName"];
	$buyeraddress1=$buyer_array["strAddress1"];
	$buyeraddress2=$buyer_array["strAddress2"];
	$buyercountry=$buyer_array["strCountry"];
	?>
<body>
<table style="width:800px;"border="0" cellspacing="1" cellpadding="0" >
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  class="dragableElement" style="z-index:25; position:absolute; left:97px; top:137px; width:305px; height:92px;" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table  cellspacing="0">
            <tr>
              <td  style="height:12px; width:305px" class="normalfnt"><span class="normalfnt" style="height:12px"><?php echo $Company;?></span></td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt"><?php echo $Address;?></td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt"><?php echo $City;?></td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt"><span class="doctext7" style="height:12px">&nbsp;</span></td>
            </tr>
            <?php 
	$strBuyer="select 	strBuyerID, 
	strBuyerCode, 
	strName, 
	strAddress1, 
	strAddress2, 
	strCountry, 
	strPhone, 
	strFax, 
	strEMail, 
	strRemarks, 
	strTINNo, 
	intDel
	 
	from 
	eshipping.buyers 
	where strBuyerID='$buyersid'";
	
	$Buyerresults=$db->RunQuery($strBuyer);
	$rb=mysql_fetch_array($Buyerresults);
	$buyername=$rb['strName'];
	$bAddress1 =$rb['strAddress1'];
	$bAddress2 =$rb['strAddress2'];
	$bCountry=$rb['strCountry'];
	
	$strDetail="";
	$resultDetail=$db->RunQuery($strBuyer);
	$rowdetail=mysql_fetch_array($Buyerresults);
	?>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <?php
	$couCode = $detail_data_set['strCountryCode'];
	if($detail_data_set['strCountryCode']=='GB')
		$couCode = 'UK';
	?>
    <td><div  style="z-index:25; position:absolute; left:530px; top:106px; width:305px; height:22px;" class="dragableElement" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table cellspacing="0">
            <tr>
              <td width="340" style="height:12px" class="doctext2"><span class="normalfnt" style="height:12px"><?php echo $refNo;  ?></span></td>
            </tr>
           
            
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:97px; top:222px; width:305px; height:92px;" class="dragableElement" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table cellspacing="0">
            <tr>
              <td width="340" style="height:12px" class="normalfnt"><span class="normalfnt" style="height:12px"><?php echo $detail_data_set['buyerName'];?></span></td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt"><?php echo $detail_data_set['buyerAddress1'];?></td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt"><?php echo $detail_data_set['buyerAddress2'];?></td>
            </tr>
            <tr></tr>
            <tr>
              <td style="height:12px" class="normalfnt"><?php echo $detail_data_set['buyerCountry'];?></td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt"><span class="doctext3" style="height:12px">&nbsp;</span></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td><div  style="z-index:25; position:absolute; left:526px; top:237px; width:305px; height:92px;" class="dragableElement" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table cellspacing="0">
            <tr>
              <td width="340" style="height:12px" class="normalfnt"><span class="normalfnt" style="height:12px">SRI LANKA</span></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:149px; top:547px; width:188px; height:70px;" class="dragableElement" >
      <table width="161" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="161" height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine1'];?></td>
          </tr>
          <tr>
          <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine2'];?></td>
          </tr>
          <tr>
          <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine3'];?></td>
          </tr>
          <tr>
          <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine4'];?></td>
          </tr>
          <tr>
          <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine5'];?></td>
          </tr>
          <tr>
          <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine6'];?></td>
          </tr>
          <tr>
          <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strMMLine7'];?></td>
          </tr>
          <tr>
            <td height="14" nowrap="nowrap" class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine1'];?></td>
          </tr>
           <tr>
            <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine2'];?></td>
          </tr>
           <tr>
            <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine3'];?></td>
          </tr>
           <tr>
            <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine4'];?></td>
          </tr>
           <tr>
            <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine5'];?></td>
          </tr>
           <tr>
            <td height="14" nowrap="nowrap" class="normalfnt"><?php echo $detail_data_set['strSMLine6'];?></td>
          </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:94px; top:364px; width:305px; height:22px;" class="dragableElement" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table cellspacing="0">
            <tr>
              <td width="340" style="height:12px" class="doctext2"><span class="normalfnt" style="height:12px"><?php echo $detail_data_set['strTransportMode']; ?> FREIGHT FROM SRI LANKA TO</span></td>
              </tr>
              <tr>
              <td width="340" style="height:12px" class="doctext2"><span class="normalfnt" style="height:12px"><?php echo $detail_data_set['strCountry']; ?></span></td>
            </tr>
           
            
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:503px; top:434px; width:294px; height:17PX;" class="dragableElement"  >
     <div style="width:300px;">
      <table  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14"  class="normalfnt">(Issued under EC regulation NO: 1602/</td>
        </tr>
        <tr>
        	<td class="normalfnt">2000/SAARC)</td>
        </tr>
      </table></div>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:300px; top:547px; width:233px; height:17PX;" class="dragableElement"  >
      <div style="width:300px;">
        <table  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="14"  class="paragraph"><span class="normalfnt"><?php echo $detail_data_set['dblQuantity']." PCS"; ?> OF <?php echo $detail_data_set['strDescOfGoods'];?></span></td>
          </tr>
          <tr>
            <td height="14"  class="paragraph"><span class="normalfnt">in <?php echo $detail_data_set['strFabric'];?></span></td>
          </tr>
        </table>
      </div>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:86px; top:559px; width:51px; height:22px;" class="dragableElement" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table cellspacing="0">
            <tr>
              <td width="340" style="height:12px" class="doctext2"><span class="normalfnt" style="height:12px">CTNS</span></td>
            </tr>
           <tr>
              <td width="340" style="height:12px; text-align:center" class="doctext2"><span class="normalfnt" style="height:12px; text-align:center"><?php  echo $detail_data_set['intNoOfCTns'];?></span></td>
            </tr>
           
            
          </table></td>
        </tr>
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
     <td><div  style="z-index:25; position:absolute; left:296px; top:599px; width:235px; height:17PX;" class="dragableElement"  >
      <div style="width:300px;">
        <table  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="240" height="14"  class="paragraph"><span class="normalfnt">STYLE NO:<?php echo $detail_data_set['strStyleID'];?></span></td>
          </tr>
          <tr>
            <td height="14"  class="paragraph"><span class="normalfnt">&nbsp;</span></td>
          </tr>
          <tr>
            <td height="14"  class="paragraph"><span class="normalfnt">ORDER NO: <?php echo $detail_data_set['strBuyerPONo'];?></span></td>
          </tr>
          <tr>
            <td height="14"  class="paragraph">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"  class="paragraph"><span class="normalfnt">QTY: <?php echo $detail_data_set['dblQuantity'];?> PCS</span></td>
          </tr>
          <tr>
            <td height="14"  class="paragraph">&nbsp;</td>
          </tr>
          <tr>
            <td height="14"  class="paragraph"><span class="normalfnt">HS Code: <?php echo $HsCode; ?></span></td>
          </tr>
        </table>
      </div>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:526px; top:560px; width:64px; height:44px;" class="dragableElement" >
      <table width="94" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="94" height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">SRI LANKA</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&quot;W&quot;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_data_set['strHSCode'] ?></td>
        </tr>
       
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:608px; top:562px; width:55px; height:44px;" class="dragableElement" >
      <table width="94" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="94" height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_data_set['dblGrossMass']; ?></td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
       
      </table>
    </div></td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:698px; top:549px; width:55px; height:44px;" class="dragableElement" >
      <table width="94" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="94" height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $detail_data_set['strInvoiceNo']; ?></td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center"><?php echo $gspDate;?></td>
        </tr>
        <tr>
          <td height="14" nowrap="nowrap" class="normalfnt" style="text-align:center">&nbsp;</td>
        </tr>
       
      </table>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div  style="z-index:25; position:absolute; left:519px; top:925px; width:250px; height:17PX;" class="dragableElement"  >
      <div style="width:300px;">
        <table  border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="240" height="60"  class="normalfnt">&nbsp;</td>
          </tr>
        <tr>
            <td width="240" height="13"  class="normalfnt">SRI LANKA</td>
          </tr>
          <tr>
            <td width="240" height="14"  class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td width="240" height="40"  class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td width="240" height="23"  class="normalfnt"><?php echo $detail_data_set['strCountry']; ?></td>
          </tr>
          <tr>
            <td width="240" height="14"  class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td width="240" height="14"  class="normalfnt">&nbsp;</td>
          </tr>
          <tr>
            <td width="240" height="14"  class="normalfnt"><?php echo $gspDate; ?></td>
          </tr>
          
        </table>
      </div>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div style="z-index:24; position:absolute; left:504px; top:897px; width:283px; height:180px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="25">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div   style="z-index:24; position:absolute; left:314px; top:506px; width:223px; height:315px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div></td><td><div   style="z-index:24; position:absolute; left:145px; top:506px; width:154px; height:316px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div><div   style="z-index:24; position:absolute; left:544px; top:506px; width:66px; height:223px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:627px; top:506px; width:55px; height:220px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:706px; top:506px; width:65px; height:220px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:493px; top:418px; width:306px; height:36px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:510px; top:94px; width:306px; height:36px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:83px; top:505px; width:55px; height:180px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:91px; top:355px; width:315px; height:42px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:90px; top:98px; width:315px; height:108px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:91px; top:220px; width:315px; height:106px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:513px; top:226px; width:306px; height:36px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:11px; top:16px; width:82px; height:30px;"class="hideWhilePrinting" ><table onclick="removeCookie();" class="mouseover" border="1">
    <tr >
    	<td>Reset</td>
    </tr>
</table>
</div>
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="10%" height="25">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
  <tr bgcolor="#FFFFFF">
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
  </tr>
</table>
<?php 
$str_pages		="select intManifestNo from manifestdetail where intManifestNo='$manifestno'";
$result_pages	=$db->RunQuery($str_pages);
$pages			=mysql_num_rows($result_pages);
for($loop=1;$loop<$pages;$loop++){
?>
<script type="text/javascript">
window.open('do_sub.php?manifestno=<?php echo $manifestno;?>&limitz=<?php echo $loop;?>',<?php echo $loop;?>)

</script>
<?php }?>
</body>
<script type="text/javascript" src="dragable/dragable-content.js"></script>
</html>
