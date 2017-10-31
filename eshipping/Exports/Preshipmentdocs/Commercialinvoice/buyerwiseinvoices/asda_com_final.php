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
commercial_invoice_detail.strColor,
commercial_invoice_header.strInvoiceNo,
commercial_invoice_header.strPayTerm,
commercial_invoice_header.strIncoterms,
commercial_invoice_header.strTransportMode,
commercial_invoice_header.strPortOfLoading,
commercial_invoice_header.strCurrency,
date(dtmInvoiceDate) AS dtmInvoiceDate,
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
commercialinvformat.strSMLine7
FROM
commercial_invoice_header
LEFT JOIN commercial_invoice_detail ON commercial_invoice_detail.strInvoiceNo = commercial_invoice_header.strInvoiceNo
LEFT JOIN buyers ON buyers.strBuyerID = commercial_invoice_header.strNotifyID1
LEFT JOIN customers ON customers.strCustomerID = commercial_invoice_header.strCompanyID
LEFT JOIN commercialinvformat ON commercialinvformat.intCommercialInvId = commercial_invoice_header.strComInvFormat
WHERE commercial_invoice_header.strInvoiceNo='$invoiceNo'
GROUP BY commercial_invoice_header.strInvoiceNo";
	
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
<title>|ASDA|Commercial Invoice</title>
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
        <td width="60%" style="text-align:center"><?PHP echo 'COMMERCIAL INVOICE NO : ';?></td>
        <td width="20%"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td >
    
    <table width="99%" border="0" cellspacing="0" cellpadding="3" class="normalfnt"> 
    <tr>
      <td width="27%" >&nbsp;</td>
      <td width="19%" >&nbsp;</td>
      <td width="14%"   align="center">&nbsp;</td>
      <td width="16%"   align="center">&nbsp;</td>
      <td width="24%"   align="center">&nbsp;</td>
    </tr>
      <tr>
        <td class="border-bottom-fntsize12">SHIPPER</td>
        <td >&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td ><span >HELA CLOTHING PVT(LTD) </span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>INVOICE NO</td>
        <td ><?php echo $detail_data_set['strInvoiceNo'];?></td>
      </tr>
      <tr>
        <td ><span >309/11, NEGOMBO ROAD</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>INV DATE</td>
        <td ><?php echo $detail_data_set['dtmInvoiceDate'];?></td>
      </tr>
      <tr>
        <td ><span >WELISARA</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>SC NO</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td ><span>SRI LANKA</span></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>PO NO</td>
        <td ><?php echo $detail_data_set['strBuyerPONo'];?></td>
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
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>SALES ORDER NO</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="border-bottom-fntsize12">Consignee</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>STY NO</td>
        <?php  
	
		
		
		?>
        <td ><?php echo $detail_data_set['strStyleID'];?></td>
      </tr>
      <tr>
        <td ><?php echo $detail_data_set['buyerName'];?></td>
        <td align="right">&nbsp;</td>
        <td >&nbsp;</td>
        <td>PAYMENT TERMS</td>
        <td ><?php echo $detail_data_set['strPayTerm'];?></td>
      </tr>
      <tr>
        <td ><?php echo $detail_data_set['buyerAddress1'];?></td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>COLOUR</td>
        <td ><?php echo $detail_data_set['strColor'];?></td>
      </tr>
      <tr>
        <td ><?php echo $detail_data_set['buyerAddres2'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>SIZE</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td ><?php echo $detail_data_set['buyerAddress3'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td ><?php echo $detail_data_set['buyerCountry'];?>.</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-bottom-fntsize12">Shipping Marks</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >LC NO</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >TERMS OF PAYMENT</td>
        <td><?php echo $detail_data_set['strPayTerm'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >TERMS OF DELIVERY</td>
        <td><?php echo $detail_data_set['strIncoterms'];?> SRI LANKA</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >CAT NO</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >MODE OF SHIPMENT</td>
        <td ><?php echo $detail_data_set['strTransportMode'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" >SHIPMENT FROM  <?php echo $detail_data_set['strPortOfLoading'] ;?> SRI LANKA  TO 
		<?php echo $detail_data_set['buyerCountry'];?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td >COUNTRY OF ORIGIN</td>
        <td >SRI LANKA</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td >CURRENCY</td>
        <td ><?php echo $detail_data_set['strCurrency']?></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td >VESSEL NAME AND DATE</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" ><strong>As the manufacturer of these products I/We hereby declare that all products covered by this document, except where otherwise clearly indicated, are of (sri lanka) origin. I/We hereby certify that the information on this invoice is true and correct and that the contents of this shipment are as stated above.</strong></td>
        </tr>
      <tr>
        </tr>
      <tr>
        <td colspan="5" >&nbsp;</td>
        </tr>
      <tr>
        <td ><strong>TOTAL CARTONS</strong></td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td ><strong>VCP</strong></td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td ><strong>PKS QTY</strong></td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
      
        <td >&nbsp;
        </td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      
    </table>
    <table width="99%" border="0" cellspacing="0" cellpadding="3" class="normalfnt"> 
    <tr>
      <td class="border-top-left-fntsize12">&nbsp;</td>
      <td class="border-top">&nbsp;</td>
      <td class="border-top">&nbsp;</td>
      <td   align="center" class="border-top">&nbsp;</td>
      <td   align="center" class="border-top">U/Price</td>
      <td   align="center" class="border-top-right-fntsize12">Total</td>
    </tr>
    <tr>
      <td width="19%"  class="border-left" align="center" >PRODUCT NO</td>
      <td width="19%" >TUC CODE</td>
      <td width="23%" >DESCRIPTION</td>
      <td width="12%">QUANTITY</td>
      <td width="11%"   >Per Pce</td>
      <td width="16%"   align="center" class="border-right">FOB</td>
    </tr>
      <tr>
        <td align="center" class="border-bottom-left-fntsize12">IDENT</td>
        <td align="center" class="border-bottom">HTS CODE</td>
        <td align="center" class="border-bottom">HTS DESCRIPTION</td>
        <td  align="center" class="border-bottom">PCS</td>
        <td align="center" class="border-bottom">FOR US$</td>
        <td align="center" class="border-bottom-right-fntsize12">US$</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
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
        <td height="21" >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-top">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-top">&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="border-bottom-fntsize12">&nbsp;</td>
        <td>&nbsp;</td>
        <?php  
	
		
		
		?>
        <td class="border-bottom-fntsize12">&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td align="right">&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >TOTAL NET WEIGHT</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >TOTAL GROSS WEIGHT</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >TOTAL CBM</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table>
  </table>
</body>
<script type="text/javascript" src="dragable/dragable-content.js"></script>
</html>
