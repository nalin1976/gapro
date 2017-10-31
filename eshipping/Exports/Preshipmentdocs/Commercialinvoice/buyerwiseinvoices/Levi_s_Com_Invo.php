<?php 
session_start();
$invoiceNo=$_GET["InvoiceNo"];
//$itemno=$_GET["itemno"];
include "../../../../Connector.php";
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
//$invoiceNo='10250/OTL/09/10';
//$invoiceNo='194/OTL/NY/02/11';
$limitNo=$_GET['limitNo'];
$limitNo =($limitNo==""?0:$limitNo);
//include("invoice_queries.php");	
$refNo = $_GET['refNo'];



$str_header="SELECT
commercial_invoice_detail.strBuyerPONo,
commercial_invoice_detail.strDescOfGoods,
commercial_invoice_detail.strStyleID,
commercial_invoice_detail.strISDno, 
commercial_invoice_detail.strColor,
commercial_invoice_header.strInvoiceNo,
commercial_invoice_header.strPayTerm,
commercial_invoice_header.strIncoterms,
commercial_invoice_header.strCarrier,
commercial_invoice_header.strTransportMode,
commercial_invoice_header.strPortOfLoading,
commercial_invoice_header.strCurrency,
commercial_invoice_header.strNotifyID1,
date(dtmInvoiceDate) AS dtmInvoiceDate,
invoicedetail.strDescOfGoods,
invoicedetail.strFabrication,
buyers.strName AS buyerName,
buyers.strAddress1 AS buyerAddress1,
buyers.strAddress2 AS buyerAddres2,
buyers.strAddress3 AS buyerAddress3,
buyers.strCountry AS buyerCountry,
customers.strName AS manufactureName,
customers.strAddress1 AS manufactureAddress1,
customers.strAddress2 AS manufactureAddress2,
customers.strMLocation,
customers.strCountry AS manufactureCountry,
commercial_invoice_detail.dblQuantity AS strqut,
commercial_invoice_detail.dblAmount AS stramo,
commercial_invoice_detail.dblUnitPrice AS strunit,
SUM(commercial_invoice_detail.dblQuantity) AS dblQuantity,
ROUND(SUM(commercial_invoice_detail.dblAmount),2) AS dblAmount,
SUM(commercial_invoice_detail.intNoOfCTns) AS intNoOfCTns,
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
shipmentforecast_detail.strSC_No
FROM
commercial_invoice_header
LEFT JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
LEFT JOIN invoicedetail ON invoicedetail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
LEFT JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strNotifyID1
LEFT JOIN customers ON customers.strCustomerID = commercial_invoice_header.strCompanyID
LEFT JOIN commercialinvformat ON commercialinvformat.intCommercialInvId = commercial_invoice_header.strComInvFormat
INNER JOIN shipmentforecast_detail ON shipmentforecast_detail.strPoNo = invoicedetail.strBuyerPONo AND 
shipmentforecast_detail.strStyleNo = invoicedetail.strStyleID 
WHERE commercial_invoice_header.strInvoiceNo='$invoiceNo'
GROUP BY commercial_invoice_header.strInvoiceNo

				";
	
	//die($str_detail);
$result_detail=$db->RunQuery($str_header);
$detail_data_set=mysql_fetch_array($result_detail);

$arrInvDate=$detail_data_set['dtmDate'];
$invDate=explode(" ",$arrInvDate);
	//echo $DescOfGoods;
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
<title>| LEVIS | Commercial Invoice</title>
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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

<table width="900" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="normalfnt_size20" style="text-align:center" bgcolor="#CCCCCC" height="40"><?php echo 'HELA CLOTHIING (PVT) LTD.';?></td>
  </tr>
  <tr>
    <td bgcolor="#999999" class="normalfntMid" height="18"><?php echo "No. 306/11,Negombo Road, Welisara" ;?></td>
  </tr>
  <tr>
    <td bgcolor="#999999" class="normalfntMid" height="18"><?php echo "Tel- +94 11 2234000 Fax +94 11 2233678" ;?></td>
  </tr>
  <tr>
    <td class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td class="normalfnt2bldBLACKmid"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%">&nbsp;</td>
        <td width="60%" style="text-align:center; font-size:16px"><u><?PHP echo 'COMMERCIAL INVOICE ';?></u></td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td >
    <table width="100%" border="0" cellspacing="0" cellpadding="3" class="normalfnt">
    <tr>
      <td width="21%" class="border-bottom-fntsize12">&nbsp;</td>
      <td width="23%" class="border-bottom-fntsize12">&nbsp;</td>
      <td colspan="4" class="border-bottom-fntsize12">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" class="border-left-fntsize12"><strong>EXPORTER / SELLER / SHIPPER :</strong></td>
        <td colspan="3" class="border-left">Invoice No.&amp; Date<span style="text-align:center">&nbsp;</span></td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
    <tr>
        <td colspan="2" class="border-left-fntsize12">HELA CLOTHING PVT(LTD) </td>
        <td class="border-bottom-left-fntsize12"><?php echo $detail_data_set['strInvoiceNo'];?> </td>
        <td colspan="2" class="border-bottom-fntsize12"><?php echo 
		$detail_data_set['dtmInvoiceDate']?></td>
        <td class="border-Left-bottom-right-fntsize12">SC NO : <?php echo $detail_data_set['strSC_No'];?></td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">309/11, NEGOMBO ROAD</td>
        <td colspan="4" class="border-left-right-fntsize12">Buyer`s Order No. &amp; Date</td>
        </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">WELISARA</td>
        <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12"><span>SRI LANKA</span></td>
        <td colspan="4" class="border-Left-bottom-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">Tel #+94114791888</td>
        <td colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">Fax # +94114791800</td>
        <td colspan="4" class="border-left-right-fntsize12"><strong>BILL TO :</strong></td>
        </tr>
      
       <tr>
         <td colspan="2" class="border-bottom-left-fntsize12">&nbsp;</td>
         <td colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      
      <tr>
        <td colspan="2" class="border-left-fntsize12"><strong>MANUFACTURER/SEWER NAME &amp; ADDRESS :</strong></td>
        <td colspan="3" class="border-left-fntsize12"><?php echo $detail_data_set['buyerName'];?></td>
        <td width="21%" class="border-right-fntsize12">&nbsp;</td>
      </tr>
       <tr>
        <td class="border-left-fntsize12">HELA CLOTHING PVT(LTD) </td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12"><?php echo $detail_data_set['buyerAddress1'];?></td>
        <td width="21%" class="border-right-fntsize12">&nbsp;</td>
      </tr>
      
       <tr>
         <td class="border-left-fntsize12">309/11, NEGOMBO ROAD</td>
         <td>&nbsp;</td>
         <td colspan="3" class="border-left-fntsize12"><?php echo $detail_data_set['buyerAddres2'];?></td>
         <td class="border-right-fntsize12">&nbsp;</td>
       </tr>
       <tr>
         <td class="border-left-fntsize12">WELISARA</td>
         <td>&nbsp;</td>
         <td colspan="3" class="border-left-fntsize12"><?php echo $detail_data_set['buyerAddress3'];?></td>
         <td class="border-right-fntsize12">&nbsp;</td>
       </tr>
       <tr>
        <td class="border-left-fntsize12">SRI LANKA</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12"><?php echo $detail_data_set['buyerCountry'];?></td>
        <?php $notifyParty1Id = $dataholder['strNotifyID1'];
		 $sql_NotPty=" SELECT buyers.strBuyerID,
						buyers.strBuyerCode,
						buyers.strName,
						buyers.strAddress1,
						buyers.strAddress2,
						buyers.strCountry
						FROM buyers
						WHERE strBuyerID='$notifyParty1Id'";
		
				
	$result=$db->RunQuery($sql_NotPty);
	$notyfy=mysql_fetch_array($result);		 
	?>	
        
        
        <td class="border-right-fntsize12">&nbsp;</td>
        
      </tr>
      <tr>
        <td class="border-left-fntsize12">Tel #+94114791888</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-bottom-left-fntsize12">Fax # +94114791800</td>
        <td colspan="3" class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><strong>CONSIGNEE/ IMPORTER :</strong></td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12"><strong>NOTIFY PARTY/ SHIP TO :</strong></td>
         <?php $notifyParty1Id = $detail_data_set['strNotifyID1'];
		 $sql_NotPty=" SELECT buyers.strBuyerID,
						buyers.strBuyerCode,
						buyers.strName,
						buyers.strAddress1,
						buyers.strAddress2,
						buyers.strCountry
						FROM buyers
						WHERE strBuyerID='$notifyParty1Id'";
		
				
	$result=$db->RunQuery($sql_NotPty);
	$notyfy=mysql_fetch_array($result);		 
	?>	
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12"><?php echo $notyfy['strName'];?></td>
        <td class="border-right-fntsize12">&nbsp;</td>
        <td width="1%">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $detail_data_set['buyerName'];?></td>
        <td>&nbsp;</td>
         <!--<td><strong><?php if($dataholder['soldtoAName']!=""){?>Shipped to<?php }?></strong></td>-->
        <td colspan="3" class="border-left-fntsize12"><?php echo $notyfy['strAddress1'];?></td>
        <td class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $detail_data_set['buyerAddress1'];?></td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12"><?php echo $notyfy['strAddress2'];?></td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $detail_data_set['buyerAddres2'];?></td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12"><?php echo $notyfy['strCountry'];?></td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $detail_data_set['buyerAddress3'];?></td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><?php echo $detail_data_set['buyerCountry'];?></td>
        <td>&nbsp;</td>
        <td colspan="3" class="border-top-left-fntsize12">Country of origin of Goods</td>
        <td class="border-Left-Top-right-fntsize12">Country of Final Destination</td>
        </tr>
        
        
         <tr>
           <td colspan="2" class="border-left">&nbsp;</td>
           <td colspan="3" class="border-bottom-left-fntsize12">SRI LANKA</td>
           <td class="border-Left-bottom-right-fntsize12"><?php echo $detail_data_set['buyerCountry'];?></td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td colspan="4" class="border-left-right-fntsize12">Terms of Delivery and Payment by <?php echo $detail_data_set['strPayTerm'];?></td>
        </tr>
      <tr>
        <td height="23" class="border-left-fntsize12">Pre-Carriage by</td>
        <td class="border-left">Place of Receipt by Carrier</td>
        <td colspan="4" class="border-left-right-fntsize12">Bank Details</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      
      <tr>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">Vessel/Flight No.</td>
        <td class="border-left">Port of Loading </td>
        <td colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td colspan="4" class="border-left-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12"><?php echo $detail_data_set['strCarrier'];?></td>
        <td class="border-bottom-left-fntsize12"><?php echo $detail_data_set['strPortOfLoading'];?>,SRI LANKA</td>
        <td colspan="3" class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-right-fntsize10">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left">Port of Discharge</td>
        <td class="border-left">Final Destination</td>
        <td width="22%" class="border-left"><strong>SEASON : </strong></td>
        <td colspan="2" class="border-left">S2- 13 BULK</td>
        <td class="border-right-fntsize12">&nbsp;</td>
        </tr>
      <tr>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-left-fntsize12"><?php echo $detail_data_set['buyerCountry'];?></td>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td width="7%" class="border-bottom-left">&nbsp;</td>
        <td width="5%" class="border-bottom-fntsize12">&nbsp;</td>
        <td class="border-bottom-right-fntsize12">&nbsp;</td>
        </tr>
    </table>
    
    <table width="99%" border="0" cellspacing="0" cellpadding="3" class="normalfnt"> 
    <tr>
      <td class="border-left">&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td colspan="2" >&nbsp;</td>
      <td  width="14%" align="center" class="border-left"><strong>Quantity</strong></td>
      <td    class="border-left" align="center"><strong>Rate</strong></td>
      <td  class="border-left-right-fntsize12" align="center"><strong>Amount</strong></td>
    </tr>
    <tr>
      <td width="14%" class="border-left">&nbsp;</td>
      <td width="10%" >&nbsp;</td>
      <td width="15%" class="border-All">ITEN DESCRIPTION</td>
      <td width="12%" class="border-All">ORDER NUMBER</td>
      <td width="12%" class="border-All">PRODUCT CODE</td>
      <td colspan="2" >&nbsp;</td>
      <td width="14%"   class="border-left" align="center">Pcs</td>
      <td width="7%"    class="border-left" align="center"><?php echo $detail_data_set['strIncoterms'];?></td>
      <td width="12%"  class="border-left-right-fntsize12" align="center"><?php echo $detail_data_set['strIncoterms'];?></td>
    </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="2" >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left"><?php echo $detail_data_set['strPortOfLoading'];?></td>
        <td class="border-left-right-fntsize12"><?php echo $detail_data_set['strPortOfLoading'];?></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">BRAND</td>
        <td ><?php echo $detail_data_set['buyerName'];?></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="2" >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">PER Pce</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">QUALITY STD</td>
        <td >&nbsp;</td>
        <td colspan="3" ><strong><?php echo $detail_data_set['strDescOfGoods'];?> ( <?php echo $detail_data_set['strFabrication']; ?>)</strong></td>
        <td >&nbsp;</td>
        <td width="1%" >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">US $</td>
        <td class="border-left-right-fntsize12">US $</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">FINISH STD</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">PACKG STD</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center"><strong><?php echo $detail_data_set['strqut'];?></strong></td>
        <td  class="border-left"><strong><?php echo $detail_data_set['strunit'];?></strong></td>
        <td class="border-left-right-fntsize12"><strong><?php echo $detail_data_set['stramo'];?></strong></td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">PROD CODE </td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">DESCRIPTION OF GOODS</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
      <?php 
         
              $values = explode(" ", $detail_data_set['strDescOfGoods']);
             
			    $value_string1g =  $values[0] . " ";
               $value_string1 =  $values[1] . " ";
			   $value_string2 =  $values[2] . " ";
			   
             
         
		 ?>
        <td colspan="2" class="border-left-fntsize12"><strong><?php   echo trim($value_string1, " ") ;?>  
		<?php echo  $value_string2;?></strong></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">GENDER</td>
        <td ><?php   echo  $value_string1g;?></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><strong>FIBER CONTENT</strong></td>
        <td colspan="2" ><strong><?php echo $detail_data_set['strFabrication'];?></strong></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">GARMENT TYPE</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">CONSTN TYPE</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">BTM/TOPS</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><strong>H.S.CODE</strong></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12"><strong>ISD NO</strong></td>
        <td ><strong><?php echo $detail_data_set['strISDno'];?></strong></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">CARTON NOS</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">COUNTRY  OF MANUFACTURE</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">Gross Weight</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">Net Weight</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">Net . NET.Wt</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">CBM</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td  class="border-left">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td  class="border-bottom-left-fntsize12" align="center">&nbsp;</td>
        <td class="border-bottom-left-fntsize12">&nbsp;</td>
        <td class="border-left-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td ><strong>Qty In Pcs</strong></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center"><?php echo $detail_data_set['dblQuantity'];?></td>
        <td >Total</td>
        <td class="border-All"><?php echo $detail_data_set['dblAmount']?></td>
      </tr>
      <tr>
        <td colspan="4" class="border-left-fntsize12">TOTAL US DOLLAR</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" class="border-left-fntsize12"><strong><u>MARKS &amp; NUMBERS</u></strong></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">ISD#</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">CARTON NO</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="border-left-fntsize12">MADE IN SRI LANKA</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">PRODUCT CODE</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">G.W.</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">N.W.</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">MEASUREMENT</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td class="border-left-fntsize12">Declaration :</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td colspan="3"  class="border-Left-Top-right-fntsize12" align="center">Company seal Signature &amp; Date</td>
        </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">We declare that this invoice shows the actual price of the goods</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="border-left-fntsize12">described and that all particulars are true and correct.</td>
        <td width="3%" >&nbsp;</td>
        <td >&nbsp;</td>
        <td  class="border-left" align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-right-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" class="border-left-fntsize12">&nbsp;</td>
        <td class="border-left">&nbsp;</td>
        <td class="border-right-fntsize12" colspan="2">AUTHORISED SIGNATORY</td>
        </tr>
      
            <?php 
  		$str_summary="select 
		strUnitID,
		strPriceUnitID,
		dblUnitPrice,
		dblQuantity,
		dblAmount,
		sum(dblAmount) as totamt,
		sum(dblQuantity) as totqty
		from invoicedetail
		where strInvoiceNo ='$invoiceNo'
		group by strInvoiceNo ";
  		$result_summary=$db->RunQuery($str_summary);
		$row_HS_summary=mysql_fetch_array($result_summary)
		
  ?>
      <tr>
        <td colspan="7" class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
        <td class="border-top-fntsize12">&nbsp;</td>
      </tr>
    </table>
  </table>
</body>
<script type="text/javascript" src="dragable/dragable-content.js"></script>
</html>
