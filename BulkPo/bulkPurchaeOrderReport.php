<?php
include "../Connector.php";
$backwardseperator = "../";
$report_companyId = $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaPro | Bulk Purchase Order Report</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
</head>

<body>

<table width="800" border="0" align="center">
  <tr>
    <td colspan="3"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3"><?php include $backwardseperator.'reportHeader.php';?></td>
        </tr>
      <tr>
<?php

$bulkPoNo=$_GET["bulkPoNo"];
$intYear=$_GET["intYear"];

//after change company table start 2010-09-03
$strSQL="SELECT
bulkpurchaseorderheader.intBulkPoNo,
bulkpurchaseorderheader.intYear,
DATE_FORMAT(bulkpurchaseorderheader.dtDate,'%d-%M-%Y') as dtDate,
bulkpurchaseorderheader.intStatus,
DATE_FORMAT(bulkpurchaseorderheader.dtDeliveryDate,'%d-%M-%Y') as dtDeliveryDate,
popaymentmode.strDescription AS strPaymentMode,
shipmentterms.strShipmentTerm,
shipmentmode.strDescription AS shipMode,
popaymentterms.strDescription AS strPayTerm,
bulkpurchaseorderheader.strPINO,
bulkpurchaseorderheader.strCurrency,
bulkpurchaseorderheader.intUserID,
bulkpurchaseorderheader.strInstructions,
DATE_FORMAT(bulkpurchaseorderheader.dtmETA,'%d-%M-%Y') as dtmETA,
DATE_FORMAT(bulkpurchaseorderheader.dtmETD,'%d-%M-%Y') as dtmETD,
bulkpurchaseorderheader.strSupplierID,
dtoCompanies.strName AS dtostrName,
dtoCompanies.strAddress1 AS dtostrAddress1,
dtoCompanies.strAddress2 AS dtostrAddress2,
dtoCompanies.strStreet AS dtostrStreet,
dtoCompanies.strCity AS dtostrCity,
bulkpurchaseorderheader.intDeliverTo as DeliverToComID,
dtoCompanies.strPhone AS dtostrPhone,
dtoCompanies.strEMail AS dtostrEmail,
dtoCompanies.strFax AS dtostrFax,
dtoCompanies.strWeb AS dtostrWeb,
invtoCompanies.strName AS invtostrName,
invtoCompanies.strAddress1 AS invtostrAddress1,
invtoCompanies.strAddress2 AS invtostrAddress2,
invtoCompanies.strStreet AS invtostrStreet,
invtoCompanies.strCity AS invtostrCity,
bulkpurchaseorderheader.intInvoiceComp as InvoiceToComID, 
invtoCompanies.strPhone AS invtostrPhone,
invtoCompanies.strEMail AS invtostrEmail,
invtoCompanies.strFax AS invtostrFax,
invtoCompanies.strWeb AS invtostrWeb,
suppliers.strTitle,
suppliers.strAddress1 as supAddr, suppliers.strStreet as supStreet, suppliers.strCity as SupCity,
suppliers.strState as supState, suppliers.strCountry as supCountry,suppliers.strVatRegNo,
suppliers.strTQBNo,
(select UA.Name from useraccounts UA where UA.intUserID=bulkpurchaseorderheader.intConfirmedBy)	as confirmedBy,
date(bulkpurchaseorderheader.dtDate) as createDate,
date(bulkpurchaseorderheader.dtmConfirmedDate) as confirmDate
FROM
bulkpurchaseorderheader
Inner Join popaymentmode ON popaymentmode.strPayModeId = bulkpurchaseorderheader.intPayMode
Inner Join popaymentterms ON popaymentterms.strPayTermId = bulkpurchaseorderheader.strPayTerm
left Join shipmentterms ON shipmentterms.strShipmentTermId = bulkpurchaseorderheader.intShipmentTermID
left Join shipmentmode ON shipmentmode.intShipmentModeId = bulkpurchaseorderheader.intShipmentModeId 
Inner Join companies ON companies.intCompanyID = bulkpurchaseorderheader.intCompId
Inner Join companies AS dtoCompanies ON dtoCompanies.intCompanyID = bulkpurchaseorderheader.intDeliverTo
Inner Join companies AS invtoCompanies ON invtoCompanies.intCompanyID = bulkpurchaseorderheader.intInvoiceComp	
Inner Join suppliers on suppliers.strSupplierID = 	bulkpurchaseorderheader.strSupplierID			
WHERE
bulkpurchaseorderheader.intBulkPoNo =  '$bulkPoNo' AND
bulkpurchaseorderheader.intYear =  '$intYear'";
$result = $db->RunQuery($strSQL);		
while($row = mysql_fetch_array($result))
{		
$strBulkPONo		= $row["strBulkPONo"];
$intYear			= $row["intYear"];
$strName			= $row["strName"];
$dtDate				= $row["dtDate"];
$dtDeliveryDate		= $row["dtDeliveryDate"];	
$strPaymentMode		= $row["strPaymentMode"];
$strShipmentTerm	= $row["strShipmentTerm"];
$strPayTerm			= $row["strPayTerm"];
$strPINO			= $row["strPINO"];
$intStatus			= $row["intStatus"];
$dtostrName			= $row["dtostrName"];
$dtostrAddress1		= $row["dtostrAddress1"];
$dtostrAddress2		= $row["dtostrAddress2"];
$dtostrStreet		= $row["dtostrStreet"];
$dtostrCity			= $row["dtostrCity"];
$DeliverToComID     = $row["DeliverToComID"];
$dtostrPhone		= $row["dtostrPhone"];
$dtostrEmail		= $row["dtostrEmail"];
$dtostrFax			= $row["dtostrFax"];
$dtostrWeb			= $row["dtostrWeb"];
$InvoiceToComID     = $row["InvoiceToComID"];
$invtostrName		= $row["invtostrName"];
$invtostrAddress1	= $row["invtostrAddress1"];
$invtostrAddress2	= $row["invtostrAddress2"];
$invtostrStreet		= $row["invtostrStreet"];
$invtostrCity		= $row["invtostrCity"];
$invtostrPhone		= $row["invtostrPhone"];
$invtostrEmail		= $row["invtostrEmail"];
$invtostrFax		= $row["invtostrFax"];
$invtostrWeb		= $row["invtostrWeb"];
$currency			= $row["strCurrency"];
$userId				= $row["intUserID"];
$shipMode			= $row["shipMode"];
$strInstructions    = $row["strInstructions"];
$dtmETA				= $row["dtmETA"];
$dtmETD				= $row["dtmETD"];
$SupplierName      	= $row["strTitle"];
$supAddr     		= $row["supAddr"];
$supStreet			= $row["supStreet"];
$SupCity     		= $row["SupCity"];
$supState 			= $row["supState"];
$supCountry			= $row["supCountry"];	
$strVatRegNo  		= $row["strVatRegNo"];
$strTQBNo			= $row["strTQBNo"];
$confirmedBy		= $row["confirmedBy"];
$createDate			= $row["createDate"];
$confirmDate		= $row["confirmDate"];
break;
}
?>        
      </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="5" >
        <p class="head2BLCK">&nbsp;</p>
      <p class="head2BLCK"> BULK PURCHASE ORDER</p>
      <p class="head2BLCK">&nbsp;</p>        </td>
      </tr>
      <tr><td colspan="5"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%"><span class="head2BLCK"><?php echo "PO NO -  $intYear / $bulkPoNo";?></span></td>
    <td width="50%"><div align="right"><span class="normalfnBLD1">Bulk PO Date : 
            <?php  echo $dtDate;?>
          </span></div></td>
  </tr>
</table>
</td>
      </tr>
       
      <tr>
        <td  class="normalfnth2B" style="visibility:hidden" height="20">Supplier Code </td>
        <td  class="normalfnt" style="visibility:hidden">vdf</td>
        <td width="5%">&nbsp;</td>
        <td colspan="2" rowspan="3" class="normalfnth2B"><div style="border: 1px solid #999999;"><table width="100%" border="0" cellspacing="0" cellpadding="2" height="44">
          <tr>
            <td width="34%" valign="top" class="normalfnBLD1">Deliver To :</td>
            <td width="66%" valign="top" class="normalfnt"><?php 
		$dtostrCountry = getCountry($DeliverToComID);
		//echo "$dtostrName <br/> $dtostrAddress1 <br/>";
		$dtAdd = "$dtostrName <br/> $dtostrAddress1 <br/>";
		 echo $dtAdd;
		 ?>
         <?php 
		if($dtostrStreet != '')
		{
			echo $dtostrStreet.", </br>"; 
		}
		?>
        <?php
		if($dtostrCity != '')
			echo  $dtostrCity.", </br>";
			
		 // echo $dtostrCountry;
		 
		  ?></br><?php echo $dtostrCountry; ?></td>
          </tr>
        </table></div></td>
        </tr>
      <tr>
        <td width="16%" class="normalfnth2B" height="20">Supplier Name</td>
        <td width="33%" class="normalfnt">: <?php echo $SupplierName; ?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">Address</td>
        <td class="normalfnt">: <?php 
		$strSupAdd = $supAddr."</br>";
		
		if($supStreet != '')
			$strSupAdd .= $supStreet."</br>";
			
		if($SupCity != '')
			$strSupAdd .= $SupCity."</br>";
				
		if($supState != '')	
			$strSupAdd .= $supState."</br>";
			
		if($supCountry != '')	
			$strSupAdd .= $supCountry."</br>";
			
			echo $strSupAdd;	
		?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">Pay Mode</td>
        <td class="normalfnt">: <?php echo "$strPaymentMode" ?></td>
        <td>&nbsp;</td>
        <td colspan="2" rowspan="3" class="normalfnth2B"><div style="border: 1px solid #999999;"><table width="100%" border="0" cellspacing="0" cellpadding="2" height="44">
          <tr>
            <td width="34%" valign="top" class="normalfnBLD1">Invoice To :</td>
            <td width="66%" valign="top" class="normalfnt"><?php 
		$invtostrCountry = getCountry($InvoiceToComID);
		//echo "$invtostrName <br/> $invtostrAddress1 <br/> $invtostrStreet  <br> $invtostrCountry" 
		$invAdd = "$invtostrName <br/> $invtostrAddress1 <br/>";
		//echo $invAdd;
		if($invtostrStreet != '')
			 $invAdd .=  " $invtostrStreet </br>";
			
		if($invtostrCity != '')
			$invAdd .=  "$invtostrCity </br>";
			
			$invAdd .= $invtostrCountry;
			
			echo $invAdd;
		
		?></td>
          </tr>
        </table></div></td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">Pay Terms</td>
        <td class="normalfnt">: <?php echo "$strPayTerm" ?></td>
        <td>&nbsp;</td>
        <td width="0%"  valign="top" class="normalfnt"></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">Ship. Mode</td>
        <td class="normalfnt">: <?php echo $shipMode; ?></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td height="13" class="normalfnth2B">Ship. Term</td>
        <td class="normalfnt">: <?php echo "$strShipmentTerm"; ?></td>
        <td>&nbsp;</td>
        <td width="13%" class="normalfnth2B">ETD Date :</td>
         <td width="33%" class="normalfnth2B"><span class="normalfnt">
           <?php 
		
		echo $dtmETD ?>
         </span></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">Instruction :</td>
        <td class="normalfnt">: <?php echo $strInstructions; ?></td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">ETA Date :</td>
        <td><span class="normalfnt">
          <?php 
		
		
		echo $dtmETA;
		?>
        </span></td>
      </tr>
     
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        </tr>

    </table></td>
  </tr>
  <tr>
    <td height="26" colspan="3" ><table width="100%" border="0" cellspacing="2" cellpadding="0">
      <tr>
        <td width="25%" class="normalfntTAB"><span>DELIVERY DATE :</span> <span class="normalfnBLD1"><?php echo $dtDeliveryDate;?></span></td>
        <td width="25%" class="normalfntTAB">VAT Reg. No.:<?php echo $strVatRegNo; ?></td>
        <td class="normalfntTAB">PI No :<?php echo $strPINO; ?></td>
        <td class="normalfntTAB">TQB No:<?php echo $strTQBNo;?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="173" height="20" class="normalfnth2B">&nbsp;</td>
    <td width="352" class="normalfntMid">
      <?php 
		
		/*if($intStatus==10)
		{
			echo "<span class=\"style3\"><b>CANCELED</b>";
		}
		elseif($intStatus==0)
		{
			echo "<span class=\"head2\">Not Approved";
		}	*/
		?>    </td>
    <td width="261" class="normalfntMid">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="normalfnth2B"><p class="normalfnth2B">PLEASE SUPPLY IN ACCORDANCE WITH THE INSTRUCTIONS HEREIN THE FOLLOWING : </p>
    <p class="normalfntSM">PLEASE INDICATE OUR P.O NO IN ALL YOUR INVOICES, PERFORMA INVOICES AND OTHER RELEVANT DOCUMENTS AND DELIVER TO THE ABOVE MENTIONED DESTINATION AND INVOICE TO THE CORRECT PARTY.</p></td>
  </tr>
  <tr>
    <td colspan="3" class="normalfnth2B">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
      <tr bgcolor="#CCCCCC" class="normalfntMid">
        <td width="35%" height="25" >DESCRIPTION</td>
        <td width="9%" >SIZE</td>
        <td width="11%" >COLOR</td>
        <td width="7%" >UNIT</td>
        <td width="10%" >RATE<br/>(<?php echo GetCurrencyName($currency);?>)</td>
        <td width="8%" >QTY</td>
        <td width="15%" >TOTAL AMOUNT<br/>(<?php echo GetCurrencyName($currency);?>)</td>
        </tr>
      
	  <?php 
	  	$strSQL = "SELECT
					matitemlist.strItemDescription,
					bulkpurchaseorderdetails.strSize,
					bulkpurchaseorderdetails.strColor,
					bulkpurchaseorderdetails.strUnit,
					bulkpurchaseorderdetails.dblUnitPrice,
					bulkpurchaseorderdetails.dblQty
					FROM
					bulkpurchaseorderdetails
					inner join matitemlist on matitemlist.intItemSerial=bulkpurchaseorderdetails.intMatDetailId
					WHERE
					bulkpurchaseorderdetails.intBulkPoNo =  '$bulkPoNo' AND
					bulkpurchaseorderdetails.intYear =   '$intYear'";
	  	$result = $db->RunQuery($strSQL);
		while($row = mysql_fetch_array($result))
		{
				$strDescription		=$row["strItemDescription"];
				$strSize			=$row["strSize"];
				$strColor			=$row["strColor"];
				$strUnit			=$row["strUnit"];
				$dblUnitPrice		=$row["dblUnitPrice"];
				$dblQty				=$row["dblQty"];
	  
	  ?>
	  <tr class="bcgcolor-tblrowWhite"	>
        <td class="normalfnt"><?php echo $strDescription  ?></td>
        <td class="normalfnt"><?php echo $strSize  ?></td>
        <td class="normalfnt"><?php echo $strColor  ?></td>
        <td class="normalfnt"><?php echo $strUnit  ?></td>
        <td class="normalfntRite"><?php echo $dblUnitPrice  ?></td>
        <td class="normalfntRite"><?php echo $dblQty  ?></td>
        <td class="normalfntRite"><?php 		
		$dblTotal =  $dblUnitPrice * $dblQty ;
		echo number_format($dblTotal,4);
		$dblGrandTotal +=round($dblTotal,4);
		  ?></td>
        </tr>
		<?php 
		
		}
		
		?>
      <tr class="bcgcolor-tblrowWhite">
        <td colspan="5" class="normalfntMid">Grand Total</td>
        <td class="normalfntRite">&nbsp;</td>
        <td class="normalfntRite"><?php echo number_format($dblGrandTotal,4) ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><span class="normalfnth2B">
      <?php
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

$currencyTitle = GetCurrencyName($currency);
$currencyFraction = GetCurrencyFraction($currency);
echo $totVarValue." $currencyTitle and ".$centsvalue ." $currencyFraction only.";
?>
    </span></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="normalfnBLD1">PAYMENT WILL BE MADE STRICTLY UP TO THE QUANTITY AND THE RELEVANT VALUE OF THE PURCHASE ORDER.</td>
  </tr>
  <tr>
    <td colspan="3"><table width="100%" border="0">
      <tr>
        <td width="20%" class="normalfnt">&nbsp;</td>
        <td width="20%" class="bcgl1txt1">
		<?php $sql="select Name from useraccounts where intUserID='$userId'";		
		$result = $db->RunQuery($sql);
		$row=mysql_fetch_array($result);
		echo $row["Name"];
		?></td>
        <td width="20%">&nbsp;</td>
        <td width="20%" class="bcgl1txt1"><?php echo $confirmedBy?></td>
        <td width="20%">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfntMid">PREPARED BY</td>
        <td>&nbsp;</td>
        <td class="normalfntMid">CONFIRMED BY</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">&nbsp;</td>
        <td class="normalfntMid"><?php echo $createDate;?></td>
        <td>&nbsp;</td>
        <td class="normalfntMid"><?php echo $confirmDate;?></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 
function getCountry($comID)
{
	$SQL = "SELECT CN.strCountry FROM country CN INNER JOIN companies CM ON
			CN.intConID = CM.intCountry 
			WHERE CM.intCompanyID='$comID'";
			
			 global $db;
			$result = $db->RunQuery($SQL);
			$row = mysql_fetch_array($result);
			$Country = $row["strCountry"];
			
		return $Country;	
}
?>
<?php 
if($intStatus == 0)
{
?>
<div style="position:absolute;top:200px;left:300px;">
<img src="../images/pending.png">
</div>
<?php
} 
else if($intStatus == 10)
{
?>
<div style="position:absolute;top:200px;left:400px;"><img src="../images/cancelled.png" style="-moz-opacity:0.20;opacity:0.20;filter:alpha(opacity=20);" /></div>
<?php
}
?>
</body>
</html>
<?php 
function GetCurrencyName($currencyId)
{
global $db;
	$sql="select strCurrency from currencytypes where intCurID='$currencyId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strCurrency"];
}
function GetCurrencyFraction($currencyId)
{
global $db;
	$sql="select strFractionalUnit from currencytypes where intCurID='$currencyId'";
	$result=$db->RunQuery($sql);
	$row=mysql_fetch_array($result);
	return $row["strFractionalUnit"];
}
?>