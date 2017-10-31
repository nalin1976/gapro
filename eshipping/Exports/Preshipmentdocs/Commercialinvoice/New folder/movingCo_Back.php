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
$exRate = $_GET['exRate'];
$unitPrice = $_GET['unitPrice'];
$netWtCo   = $_GET['netWt'];
//$invoiceNo='10250/OTL/09/10';
//$invoiceNo='194/OTL/NY/02/11';
$limitNo=$_GET['limitNo'];
$limitNo =($limitNo==""?0:$limitNo);
//include("invoice_queries.php");	




$str_header="SELECT
SUM(commercial_invoice_detail.dblNetMass) AS dblNetMass,
SUM(commercial_invoice_detail.dblQuantity) AS dblQuantity,
SUM(commercial_invoice_detail.dblAmount) AS dblAmount
FROM
commercial_invoice_detail
WHERE 
strInvoiceNo='$invoiceNo'
GROUP BY strInvoiceNo";
	
	//die($str_detail);
$result_detail=$db->RunQuery($str_header);
$detail_data_set=mysql_fetch_array($result_detail);

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
<title>GSP_Back</title>
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
    <td><div  class="dragableElement" style="z-index:25; position:absolute; left:91px; top:71px; width:305px; height:92px;" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table  cellspacing="0">
            <tr>
              <td  style="height:12px; width:305px" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt">&nbsp;</td>
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
    <td><div  style="z-index:25; position:absolute; left:91px; top:207px; width:305px; height:92px;" class="dragableElement" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table cellspacing="0">
            <tr>
              <td width="340" style="height:12px" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt">&nbsp;</td>
            </tr>
            <tr> </tr>
            <tr>
              <td style="height:12px" class="normalfnt">&nbsp;</td>
            </tr>
            <tr>
              <td style="height:12px" class="normalfnt"><span class="doctext3" style="height:12px">&nbsp;</span></td>
            </tr>
          </table></td>
        </tr>
      </table>
    </div></td>
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
    <td><div  style="z-index:25; position:absolute; left:92px; top:368px; width:305px; height:22px;" class="dragableElement" >
      <table border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14" nowrap="nowrap" class="paragraph"><table cellspacing="0">
            <tr>
              <td width="340" style="height:12px" class="doctext2">&nbsp;</td>
            </tr>
           
            
          </table></td>
        </tr>
      </table>
    </div></td>
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
    <td><div  style="z-index:25; position:absolute; left:501px; top:411px; width:107px; height:17PX;" class="dragableElement"  >
     <div style="width:300px;">
      <table  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="14"  class="paragraph">&nbsp;</td>
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
     <td><div  style="z-index:25; position:absolute; left:305px; top:750px; width:266px; height:115px;" class="dragableElement"  >
      <div style="width:300px;">
        <table  border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="240" height="28"  class="paragraph"><span class="normalfnt">Net Wt &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $netWtCo;?>&nbsp;Kgs</span></td>
          </tr>
          <tr>
            <td height="24"  class="paragraph"><span class="normalfnt">FOB Value&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: USD <?php echo number_format(($unitPrice*$detail_data_set['dblQuantity']),2); ?></span></td>
          </tr>
          <tr>
            <td height="33"  class="paragraph"><span class="normalfnt">Exchange Rate&nbsp;: <?php echo $exRate; ?></span></td>
          </tr>
          
           <tr>
             <td height="14"  class="paragraph"><span class="normalfnt">FOB in SL Rs&nbsp;&nbsp;&nbsp;&nbsp;: Rs.  <?php echo number_format((($unitPrice*$detail_data_set['dblQuantity'])*$exRate),2); ?></span></td>
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
    <td><div style="z-index:24; position:absolute; left:508px; top:872px; width:283px; height:180px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div></td>
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
    <td><div   style="z-index:24; position:absolute; left:297px; top:627px; width:283px; height:236px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div></td><td><div   style="z-index:24; position:absolute; left:106px; top:515px; width:174px; height:267px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div><div   style="z-index:24; position:absolute; left:638px; top:505px; width:156px; height:60px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:497px; top:397px; width:306px; height:36px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:85px; top:352px; width:315px; height:42px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:87px; top:57px; width:315px; height:108px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
    <div   style="z-index:24; position:absolute; left:87px; top:198px; width:315px; height:106px; border-style:dotted; border:dashed" class="hideWhilePrinting" ></div>
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
