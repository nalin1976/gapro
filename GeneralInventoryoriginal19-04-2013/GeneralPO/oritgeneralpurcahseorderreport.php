<?php
session_start();
include "../../Connector.php";
$xml 				= simplexml_load_file('../../config.xml');
$showAuthorizedBy 	= $xml->GeneralInventory->GeneralPO->ShowAuthorizedBy;
$backwardseperator 	= "../../";
$bulkPoNo			= $_GET["bulkPoNo"];
$intYear			= $_GET["intYear"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Genaral Po :: Report</title>
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
			var message = xmlHttp.responseText;
			//alert(message);
			if(message == "True")
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
<?php
$strSQL="SELECT GPOH.intGenPONo, GPOH.intYear, GPOH.dtmDate, GPOH.dtmConfirmedDate, GPOH.intStatus, GPOH.dtmDeliveryDate, GPOH.strCurrency, popaymentmode.strDescription AS strPaymentMode, popaymentterms.strDescription AS strPayTerm, GPOH.strPINO, GPOH.strInstructions, shipmentmode.strDescription,shipmentterms.strShipmentTerm,
DC.strName AS dtostrName, DC.strAddress1 AS dtostrAddress1, DC.strAddress2 AS dtostrAddress2, DC.strStreet AS dtostrStreet, DC.strCity AS dtostrCity, 
(select strCountry from country C where C.intConID=DC.intCountry)as dtostrCountry,
DC.strPhone AS dtostrPhone, DC.strEMail AS dtostrEmail, DC.strFax AS dtostrFax, DC.strWeb AS dtostrWeb, 
IC.strName AS invtostrName, IC.strAddress1 AS invtostrAddress1, IC.strAddress2 AS invtostrAddress2, IC.strStreet AS invtostrStreet, IC.strCity AS invtostrCity, 
(select strCountry from country C where C.intConID=IC.intCountry)as invtostrCountry,
IC.strPhone AS invtostrPhone, IC.strEMail AS invtostrEmail, IC.strFax AS invtostrFax, IC.strWeb AS invtostrWeb, suppliers.strTitle as supstrTitle,
suppliers.strAddress1 as supstrAddress1, suppliers.strAddress2 as supstrAddress2, suppliers.strStreet as supstrStreet, suppliers.strCity as supstrCity, suppliers.strState as supstrState,(select strCountry from country C where C.intConID=suppliers.strCountry) as supstrCountry,
 GPOH.intUserID AS UserID, GPOH.intConfirmedBy AS AuthorizedBy,GPOH.intCompId,
 currencytypes.strFractionalUnit,
 GPOH.intPrintStatus
FROM generalpurchaseorderheader GPOH
left Join popaymentmode ON popaymentmode.strPayModeId = GPOH.intPayMode 
left Join popaymentterms ON popaymentterms.strPayTermId = GPOH.strPayTerm 
left Join shipmentmode ON shipmentmode.intShipmentModeId = GPOH.intShipmentMode
left Join shipmentterms ON shipmentterms.strShipmentTermId = GPOH.intShipmentTerms
Inner Join companies AS DC ON DC.intCompanyID = GPOH.intDeliverTo 
Inner Join companies AS IC ON IC.intCompanyID = GPOH.intInvoiceComp 
Inner Join suppliers ON GPOH.intSupplierID = suppliers.strSupplierID 
Inner Join currencytypes on GPOH.strCurrency = currencytypes.intCurID  
WHERE GPOH.intGenPONo = '$bulkPoNo' 
AND GPOH.intYear = '$intYear'";
$result = $db->RunQuery($strSQL);
//echo $strSQL;
while($row = mysql_fetch_array($result))
{		
	$strBulkPONo		= $row["strBulkPONo"];
	$intYear			= $row["intYear"];						
	$dtmDate			= $row["dtmDate"];
	$dtmDeliveryDate	= $row["dtmDeliveryDate"];
	$strCurrency		= $row["strCurrency"];
	$strPaymentMode		= $row["strPaymentMode"];
	$strInstructions	= $row["strInstructions"];
	$strPayTerm			= $row["strPayTerm"];
	$strPINO			= $row["strPINO"];
	$intStatus			= $row["intStatus"];
	$dtostrName			= $row["dtostrName"];
	$dtostrAddress1		= $row["dtostrAddress1"];
	$dtostrAddress2		= $row["dtostrAddress2"];
	$dtostrStreet		= $row["dtostrStreet"];
	$dtostrCity			= $row["dtostrCity"];
	$dtostrCountry		= $row["dtostrCountry"];
	$dtostrPhone		= $row["dtostrPhone"];
	$dtostrEmail		= $row["dtostrEmail"];
	$dtostrFax			= $row["dtostrFax"];
	$dtostrWeb			= $row["dtostrWeb"];
	$invtostrName		= $row["invtostrName"];
	$invtostrAddress1	= $row["invtostrAddress1"];
	$invtostrAddress2	= $row["invtostrAddress2"];
	$invtostrStreet		= $row["invtostrStreet"];
	$invtostrCity		= $row["invtostrCity"];
	$invtostrCountry	= $row["invtostrCountry"];
	$invtostrPhone		= $row["invtostrPhone"];
	$invtostrEmail		= $row["invtostrEmail"];
	$invtostrFax		= $row["invtostrFax"];
	$invtostrWeb		= $row["invtostrWeb"];
	$strSupplierTitle 	= $row["strTitle"];
	$UserID 			= $row["UserID"];
	$AuthorisedID 		= $row["AuthorizedBy"];
	$report_companyId	= $row["intCompId"];
	$currencyFraction	= $row["strFractionalUnit"];
	$printStatus	    = $row["intPrintStatus"];
	$confirmDate		= $row["dtmConfirmedDate"];
	$intShipmentMode	= $row["strDescription"];
	$intShipmentTerms   = $row["strShipmentTerm"];
	
	$currencyName		= GetCurrencyName($strCurrency);
	
	$SDetails = $row["supstrTitle"]."<br/>"."&nbsp;";
	$SDetails .= ($row["supstrAddress1"]=="" ? "":$row["supstrAddress1"]."<br/>"."&nbsp;");
	$SDetails .= ($row["supstrAddress2"]=="" ? "":$row["supstrAddress2"]."<br/>"."&nbsp;");
	$SDetails .= ($row["supstrStreet"]=="" ? "":$row["supstrStreet"]."<br/>"."&nbsp;");
	$SDetails .= ($row["supstrCity"]=="" ? "":$row["supstrCity"]."<br/>"."&nbsp;");
	$SDetails .= ($row["supstrCountry"]=="" ? "":$row["supstrCountry"]."<br/>"."&nbsp;");
	
	$invDetails  = $row["invtostrName"]."<br/>"."&nbsp;";
	$invDetails .= ($row["invtostrAddress1"]=="" ? "":$row["invtostrAddress1"]."<br/>"."&nbsp;");
	$invDetails .= ($row["invtostrAddress2"]=="" ? "":$row["invtostrAddress2"]."<br/>"."&nbsp;");
	$invDetails .= ($row["invtostrStreet"]=="" ? "":$row["invtostrStreet"]."<br/>"."&nbsp;");
	$invDetails .= ($row["invtostrCountry"]=="" ? "":$row["invtostrCountry"]."<br/>"."&nbsp;");
	
	$dtoDetails  = $row["dtostrName"]."<br/>"."&nbsp;";
	$dtoDetails .= ($row["dtostrAddress1"]=="" ? "":$row["dtostrAddress1"]."<br/>"."&nbsp;");
	$dtoDetails .= ($row["dtostrAddress2"]=="" ? "":$row["dtostrAddress2"]."<br/>"."&nbsp;");
	$dtoDetails .= ($row["dtostrStreet"]=="" ? "":$row["dtostrStreet"]."<br/>"."&nbsp;");
	$dtoDetails .= ($row["invtostrCity"]=="" ? "":$row["invtostrCity"]."<br/>"."&nbsp;");
	$dtoDetails .= ($row["dtostrCountry"]=="" ? "":$row["dtostrCountry"]."<br/>"."&nbsp;");
}
?>
      <tr>
        <td width="100%" height="18"><?php include '../../reportHeader.php'?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="6" class="head2">GENERAL PURCHASE ORDER</td>
      </tr>
      <tr>
        <td colspan="6" class="head1" style="text-align:center" ><?php echo $printStatus!="0"?"(DUPLICATE)":"(ORIGINAL)" ?></td>
      </tr>
      <tr>
        <td height="36" colspan="6" class="head2">PO NO - <?php echo "$intYear/$bulkPoNo "?></td>
      </tr>
      <tr>
        <td align="left" valign="top" class="normalfnth2B">Supplier Name </td>
        <td class="normalfnth2B" valign="top">:</td>
        <td class="normalfnt" valign="top"><?php echo $SDetails; ?></td>
        <td width="10%" class="normalfnth2B" valign="top">Deliver To</td>
        <td width="1%" class="normalfnth2B" align="left" valign="top">:</td>
        <td width="34%" valign="top" class="normalfnt"><?php echo $dtoDetails;?></td>
      </tr>
      
      
      
      
      <tr>
        <td width="14%" class="normalfnth2B">PO Date </td>
        <td width="1%" class="normalfnth2B">:</td>
        <td width="40%" class="normalfnt"><?php echo substr("$dtmDate",0,10) ?></td>
        <td><span class="normalfnth2B">Invoice To</span></td>
        <td class="normalfnth2B" align="left" valign="top">:</td>
        <td width="34%" rowspan="3" valign="top" class="normalfnt"><?php echo $invDetails; ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">Deliver Date</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo substr("$dtmDeliveryDate",0,10) ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">Payment Mode </td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo "$strPaymentMode" ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">Payment Term</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo "$strPayTerm" ?></td>
        <td><span class="normalfnth2B">PR No's</span></td>
        <td class="normalfnth2B">:</td>
        <td width="34%" rowspan="2" valign="top" class="normalfnt"><?php echo GetPRNo($intYear,$bulkPoNo);?></td>
      </tr>
       <tr>
        <td height="13" class="normalfnth2B">Shipment Mode</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo "$intShipmentMode" ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">Shipment Term</td>
        <td class="normalfnth2B">:</td>
        <td class="normalfnt"><?php echo "$intShipmentTerms" ?></td>
      </tr>
      <tr>
        <td height="15" class="normalfnth2B">Instruction</td>
        <td align="left" valign="top" class="normalfnth2B">:</td>
        <td align="left" valign="top" class="normalfnt"><?php echo $strInstructions; ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        </tr>
      

    </table></td>
  </tr>
  
  
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="10%" height="25" rowspan="2" >ITEM CODE </th>
        <th width="30%" rowspan="2" >DESCRIPTION</th>
        <th width="8%" rowspan="2" >UNIT</th>
        <th width="11%" rowspan="2" >RATE<br/>(<?php echo $currencyName;?>)</th>
        <th width="8%" rowspan="2" >QTY</th>
        <th colspan="2" >DISCOUNT</th>
        <th width="15%" rowspan="2" >TOTAL AMOUNT<br/>(<?php echo $currencyName;?>)</th>
        </tr>
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <th width="7%" >%</th>
        <th width="11%" >VALUE</th>
        </tr>
      
	  <?php 
	  	$strSQL = "SELECT
					generalpurchaseorderdetails.strUnit,
					generalpurchaseorderdetails.intMatDetailID,
					generalpurchaseorderdetails.dblDiscountPct,
					generalpurchaseorderdetails.dblUnitPrice,
					sum(generalpurchaseorderdetails.dblQty) as dblQty,
					genmatitemlist.strItemDescription as itemDescription,
					generalpurchaseorderdetails.strRemarks as strRemarks
					FROM
					generalpurchaseorderdetails
					Inner Join genmatitemlist ON genmatitemlist.intItemSerial = generalpurchaseorderdetails.intMatDetailID
					WHERE
					generalpurchaseorderdetails.intGenPONo =  '$bulkPoNo' AND
					generalpurchaseorderdetails.intYear =   '$intYear' 
					group  by genmatitemlist.strItemDescription,generalpurchaseorderdetails.strUnit";
				
	  	$result = $db->RunQuery($strSQL);
		while($row = mysql_fetch_array($result))
		{
				$strDescription		=$row["itemDescription"];
				$strRemarks			=$row["strRemarks"];
				$MatDetailID		=$row["intMatDetailID"];
				$strUnit			=$row["strUnit"];
				$dblUnitPrice		=$row["dblUnitPrice"];
				$dblQty				=$row["dblQty"];
				$totQty			   +=$row["dblQty"];
				$discount			=$row["dblDiscountPct"];
				$value 				=(($dblUnitPrice * $dblQty)/100)*$discount ;
				$totvalue		   +=$value;
				
				
	  
	  ?>
	  <tr class="bcgcolor-tblrowWhite">
        <td height="20" class="normalfntRite"><?php echo $MatDetailID;?>&nbsp;</td>
        <td class="normalfnt">&nbsp;<?php echo $strDescription."-".$strRemarks; ?></td>
        <td class="normalfnt">&nbsp;<?php echo $strUnit  ?></td>
        <td class="normalfntRite"><?php echo number_format($dblUnitPrice,4,".",",");?>&nbsp;</td>
        <td class="normalfntRite"><?php echo $dblQty;?>&nbsp;</td>
        <td class="normalfntRite"><?php echo $discount;?>&nbsp;</td>
        <td class="normalfntRite"><?php echo number_format($value,4,".",",");?>&nbsp;</td>
        <td class="normalfntRite"><?php $dblTotal =  ($dblUnitPrice * $dblQty)-$value ;echo number_format($dblTotal,2,".",",");	$dblGrandTotal +=$dblTotal; ?>&nbsp;</td>
        </tr>
		<?php		
		}		
		?>
      <tr bgcolor="#CCCCCC">
			<td colspan="4" class="normalfntMid"><b>Grand Total</b></td>
			<td class="normalfntRite"><b><?php echo $totQty;?></b>&nbsp;</td>
			<td class="normalfntRite">&nbsp;</td>
			<td class="normalfntRite"><b><?php echo number_format($totvalue,4,".",","); ?></b>&nbsp;</td>
			<td class="normalfntRite" ><b>
			<?php
				if ($strCurrency != "")
				{
					$strCurrency = "(" . $strCurrency  . ")";
				}
					echo number_format($dblGrandTotal,2,".",",");

			?></b>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
      <tr class="bcgcolor-tblrowWhite">
        <td height="20" class="normalfnt">&nbsp;<b>Amount in Words -:<?php
	//$num=100005;
	$totVarValue=convert_number(round($dblGrandTotal,2));
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
$convrt = explode(".",round($dblGrandTotal,2));

$cents =  $convrt[1];
/* BEGIN - when amount is .05 system shows fifty - Comment this 'if' and add blow 'if'
if ($cents < 10)
$cents = $convrt[1] . "0";
END - when amount is .05 system shows fifty */

if(strlen($cents)<=1)
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


echo $totVarValue." $currencyName and ".$centsvalue ." $currencyFraction only.";
?></b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="normalfnth2B">Please supply in accordance with the following instructions.</td>
  </tr>
  <tr>
    <td colspan="2"><p class="normalfnth2B">Please indicate our purchase order number in all invoices, proforma invoices, dispatch notes and all correspondence. Deliver to above mentioned destination and invoice to the said party.</p>
      <p class="normalfnth2B">Payment will be made strictly up to the quantity and the relevant value of the purchase order.</p></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" align="center" cellpadding="0">
      <tr>
        <td width="114" class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td width="200" class="normalfntTAB2">
<?php
	$SQL_User="SELECT UA.Name, UA.intUserID FROM useraccounts UA WHERE UA.intUserID='$UserID';";
	$result_User = $db->RunQuery($SQL_User);
	if($row_user = mysql_fetch_array($result_User))
	{
		echo $row_user["Name"];
	}
?></td>
        <td width="154" class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td width="200" valign="top" class="normalfntTAB2">
<?php          
if($showAuthorizedBy == "true")
{
	$SQL_Autho="SELECT UA.Name, UA.intUserID FROM useraccounts UA WHERE UA.intUserID ='$AuthorisedID'";
	$result_Autho = $db->RunQuery($SQL_Autho);
	if($row_Autho = mysql_fetch_array($result_Autho))
	{
		echo $row_Autho["Name"];
	}	   
}
?>         </td>
        <td width="114" valign="top" >&nbsp;</td>
      </tr>
      <tr>
        <td width="114" class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfntMid">Prepaired By</td>
        <td width="154" class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfntMid">Authorized By</td>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfntMid"><?php echo $dtmDate;?></td>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
        <td class="normalfntMid"><?php echo $confirmDate;?></td>
        <td class="normalfnt2bldBLACKmid">&nbsp;</td>
      </tr>
      
    </table></td>
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

if($intStatus=='0')
{
		echo "<div style=\"position:absolute; top:220px; left:340px; width: 444px;\"><img src=\"../../images/pending.png\" style=\"-moz-opacity:0.20;filter:alpha(opacity=20);\"></div>";
}
else if($intStatus=='10')
{
	echo "<div style=\"position:absolute; top:220px; left:340px; width: 444px;\"><img src=\"../../images/cancelled.png\" style=\"-moz-opacity:0.20;filter:alpha(opacity=20);\"></div>";
}

if($intStatus=='1')
{
	$sql_print="update generalpurchaseorderheader set intPrintStatus='1' where intGenPONo='$bulkPoNo' and intYear='$intYear';";
	$result_print=$db->RunQuery($sql_print);
}

function GetPRNo($intYear,$bulkPoNo)
{
global $db;
	$sql="select concat(intPRYear,'/',intPRNo)as prNo from generalpurchaseorderdetails where intGenPoNo='$bulkPoNo' and intYear='$intYear' and intPRNo!='0'";
	$result=$db->RunQuery($sql);
	while($row=mysql_fetch_array($result))
	{
			$prNo .= $row["prNo"].',';
	}
	return $prNo;
}
?>
</body>
</html>