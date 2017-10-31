<?php

 $backwardseperator	= "../../../../";
	include "../../../../Connector.php";
	include "../../../../eshipLoginDB.php";
	//include $backwardseperator."authentication.inc";
	//include $backwardseperator."HeaderConnector.php";
	//include $backwardseperator."permissionProvider.php";
	include("printer.php");
	$xmlObj = simplexml_load_file('../../../../company.xml');
	$eshipDB = new eshipLoginDB();	
	
	$dateFrom   = $_GET["dateFrom"];
	$dateTo	    = $_GET["dateTo"];
	$company 	= $_GET["company"];
	$vatRate	= $_GET["vatRate"];
	$CurrencyRate	= $_GET["CurrencyRate"];
	$chkDate	= $_GET["chkDate"];
	$decimalPlace = 2;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link href="../../../../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../../../js/jquery-1.4.2.min.js"></script>
<body class="trclass"> 

<?php
$sql = "select GFD.intStyleId,GFD.dblInvoiceId
from firstsale_shippingdata GFD
inner join eshipping.shipmentplheader ESPH on ESPH.intStyleId=GFD.intStyleId
inner join eshipping.commercial_invoice_detail ECID on ESPH.strPLNo=ECID.strPLno
inner join eshipping.commercial_invoice_header ECIH on ECID.strInvoiceNo=ECIH.strInvoiceNo
and GFD.strComInvNo = ECIH.strInvoiceNo
where GFD.intTaxInvoiceConfirmBy is not null ";

if($company!="")
	$sql.="and ECIH.strCompanyID='$company' ";

if($chkDate!="")
{
	if($dateFrom!="")
	$sql.="and date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d')>='$dateFrom' ";
	
	if($dateTo!="")
	$sql.="and date_format(DATE_SUB(ECIH.dtmSailingDate,INTERVAL 3 DAY),'%Y-%m-%d')<='$dateTo' ";
}
$sql.="order by GFD.dblInvoiceId ";
$result = $db->RunQuery($sql);
while($row=mysql_fetch_array($result))
{
	$styleID = $row["intStyleId"];
	$invoiceId = $row["dblInvoiceId"];
	$style   = getStyleName($styleID);
?>
<table width="100%" border="0" height="750" cellspacing="0" cellpadding="0" class="trclass">
	<tr valign="top">
    	<td><?php include "taxInvoiceRpt.php"; ?></td> 
    </tr>
</table>
<?php
}


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
function getStyleName($styleID)
{
	global $db;
	$sql = "select strStyle from orders where intStyleId='$styleID'";
	$result = $db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	
	return $row["strStyle"];
}

?>


</body>
</html>

