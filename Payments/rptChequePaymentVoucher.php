<?php
	session_start();
	include "../Connector.php";
	$PayVoucherNo=$_GET["PayVoucherNo"];
	$suppCode	= $_GET["suppCode"];
	$strPaymentType=$_GET["strPaymentType"];
	$amt=$_GET["amt"];
	$backwardseperator = "../";
	$report_companyId = $_SESSION["FactoryID"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Voucher - Cheque Payment Voucher</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="paymentVoucher.js" type="text/javascript"></script>
<style type="text/css">
<!--
.style3 {color: #0000FF}
-->
</style>
</head>

<body a="getTotalInWords()">
<?php
$strSQL= "SELECT strName,strAddress1,strAddress2,strCity,strCountry,strPhone,strFax,strEMail,strWeb FROM companies WHERE companies.intCompanyID =" . $_SESSION["FactoryID"] ;
$result=$db->RunQuery($strSQL);
while($row = @mysql_fetch_array($result))
{ 
	$companyName = $row["strName"];
	$address= $row["strAddress1"] + " " +  $row["strAddress2"] + " " +  $row["strCity"] + " " +  $row["strCountry"];
	$phone= $row["strPhone"];
	$fax= $row["strFax"];
	$web= $row["strWeb"];
	$email= $row["strEMail"];
}

$strSQL="SELECT paymentheader.intVoucherNo,paymentheader.strBatch,paymentheader.dtDate,paymentheader.strCheque,paymentheader.strSupCode,suppliers.strTitle,paymentheader.strCurrency FROM paymentheader INNER JOIN suppliers ON (paymentheader.strSupCode=suppliers.strSupplierID) WHERE intVoucherNo= '$PayVoucherNo' and strType='$strPaymentType';";
$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["dtDate"];
	$chequeNo= $row["strCheque"];
	$batchNo=$row["strBatch"];
	$currency=$row['strCurrency'];
}

?>

<table width="800" border="0" align="center"><!--
  <tr>
    <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $companyName; ?></p>
            <p class="normalfnt"><?php echo $address; ?>. Tel: <?php echo $phone; ?> Fax: <?php echo $fax; ?></p>
          <p class="normalfnt">E-Mail: <?php echo $email; ?> Web: <?php echo $web; ?></p></td>
      </tr>
    </table></td>
  </tr>
  	  --><tr>
	    <td colspan="4"><?php include '../reportHeader.php';?></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="6" class="head2">CHEQUE PAYMENT VOUCHER </td>
        <td width="16%" ><DIV id="divPrintStatus">
		<table width="124" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
		  <?php
			  	$strSQL="SELECT intPrintStatus FROM paymentheader WHERE intVoucherNo='$PayVoucherNo'  and strType='$strPaymentType'";
				$result=$db->RunQuery($strSQL);
				
				while($row = mysql_fetch_array($result))
				{ 
					$status= $row["intPrintStatus"];
				}
				
				if($status==0)
				{
					$strSQL="UPDATE paymentheader SET intPrintStatus=1 WHERE intVoucherNo='$PayVoucherNo' and strType='$strPaymentType'";
					$db->RunQuery($strSQL);
					$printType="ORIGINAL";
				}
				else if($status==1)
				{
					$printType="DUPLICATE";
				
				}	  
		  ?>
		  
            <td class="tablezRED style6" style="text-align:center"><?php echo($printType); ?></td>
          </tr>
        </table>
		</DIV>	</td>
      </tr>
      <tr>
        <td width="13%" class="normalfnth2B" height="24px">PAYEE</td>
        <td width="34%" class="normalfnt"><?php echo $payee; ?></td>
        <td width="12%"><span class="normalfnth2B">VOUCHER NO</span></td>
        <td width="15%" class="normalfnth2B"><span class="normalfnt"><?php echo $PayVoucherNo; ?></span></td>
        <td width="10%" class="normalfnth2B">Batch No </td>
        <td colspan="2" class="normalfnt"><?php echo $batchNo; ?></td>
      </tr>
      <tr>
        <td height="25" class="normalfnth2B"  >CHEQUE NO</td>
        <td class="normalfnt"><?php echo $chequeNo; ?></td>
        <td><span class="normalfnth2B">DATE</span></td>
        <td class="normalfnth2B"><span class="normalfnt"><?php echo $date; ?></span></td>
        <td class="normalfnt">&nbsp;</td>
        <td colspan="2" class="normalfnt">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="36%" height="25" class="normalfntBtab">DESCRIPTION</td>
        <td width="14%" class="normalfntBtab">AMOUNT</td>
        <td width="10%" class="normalfntBtab">TAX</td>
        <td width="13%" class="normalfntBtab">Cr/Dr</td>
        <td width="11%" class="normalfntBtab">Cr/Dr Tax</td>
        <td width="16%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
		$strSQLTax="SELECT
distinct (invoicetaxes.dblamount) AS taxAmount 
FROM
paymentheader
Inner Join paymentdetails ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo
Inner Join paymentscheduleheader ON paymentscheduleheader.strScheduelNo = paymentdetails.strSchedulNo
Inner Join paymentscheduledetails ON paymentscheduledetails.strScheduelNo = paymentscheduleheader.strScheduelNo
INNER JOIN invoicetaxes ON paymentscheduledetails.strInvoiceNo=invoicetaxes.strinvoiceno 
AND paymentheader.strSupCode=invoicetaxes.strsupplierid 
WHERE paymentheader.intVoucherNo='$PayVoucherNo' AND paymentheader.strType='$strPaymentType' ";
		$taxresult=$db->RunQuery($strSQLTax);
		
		while($taxrow = mysql_fetch_array($taxresult))
		{ 
			$taxTotal=$taxTotal+$taxrow["taxAmount"];
		}

		
		$strSQL="SELECT * FROM paymentheader WHERE intVoucherNo='$PayVoucherNo'  and strType='$strPaymentType'";
	
		$result=$db->RunQuery($strSQL);
		//echo $strSQL;
		while($row = mysql_fetch_array($result))
		{ 
		$amount= number_format($row["dblAmount"],2);
		//echo $amount;
		//echo "-";
		//if(number_format($taxTotal,2)>0)
		//{
		//	echo $taxTotal;
		
		//	$amount=number_format($amount,2);//- number_format($taxTotal,2);
		//}
		//}
		//else
		//{
		//	$taxTotal=0;
		//}
		//}
		
		$amount=$row["dblAmount"];
		if(number_format($taxTotal,2)>0)
		{
			//$amount=$amount-number_format($taxTotal,2);
		}
		
		?>
			<tr>
			<td class="normalfntTAB"><?php  echo  $row["strDescription"]; ?></td>
			<td class="normalfntRiteTAB"><?php  echo(number_format($amount,4))  ; ?></td>
			<td class="normalfntRiteTAB"><?php  echo(number_format($taxTotal,4));?></td>
			<td class="normalfntRiteTAB"><?php echo(0);?></td>
			<td class="normalfntMidTAB"><?php echo(0); ?></td>
			<td class="normalfntRiteTAB"><?php $total += $amount+$taxTotal; echo(number_format($amount+$taxTotal,2)) ; ?></td>
			</tr>
		
		<?php
		
		}
		?>
		
      <tr>
        <td class="normalfnth2Bm">Grand Total</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="nfhighlite1"><?php echo(number_format($total,2))  ; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td width="171"  class="normalfnth2B">Total Amount in Words : </td>
    <td width="619" class="normalfnt style3" ><?php //echo($total); ?>
	<?php
	//$num=100005;
	$totVarValue=convert_number(round($total,4));
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

//$convrt=substr(round($total,2),-2);
$convrt = explode(".",round($total,2));

$cents =  $convrt[1];
if ($cents < 10)
$cents = $convrt[1] . "0";

$centsvalue=centsname($cents);
function centsname($number)
{		
      $Dn = floor($number / 10);       // -10 (deci) 
      $n = $number % 10;               // .0 
	  
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
$currencyFraction = "";
function GetCurrencyName($currencyId)
{
global $db;
	$sql="select strCurrency,strFractionalUnit from currencytypes  where intCurID='$currencyId'";
	$result=$db->RunQuery($sql);
	$row = mysql_fetch_array($result);
	return $row["strCurrency"]."-".$row["strFractionalUnit"];
}
$currencyDet= GetCurrencyName($currency);
$cT=split('-',$currencyDet);
$currencyTitle =$cT[0] ;
$currencyFraction=$cT[1] ;
echo $totVarValue." $currencyTitle and ".$centsvalue ." $currencyFraction only.";
?>
	
	
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" height="60" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" height="25" class="normalfntBtab">ACCOUNT</td>
        <td width="26%" class="normalfntBtab">A/C CODE</td>
        <td width="13%" class="normalfntBtab">AMOUNT</td>
        <td width="34%" class="normalfntBtab">ADDRESS</td>
        </tr>
		<?php
		//$strSQL="SELECT invoiceglbreakdown.*,glaccounts.strDescription ,invoiceglbreakdown.dblAmount AS dblGLAmount ,companies.strName AS compName FROM paymentdetails INNER JOIN invoiceglbreakdown ON (paymentdetails.strInvoiceNo=invoiceglbreakdown.strInvoiceNo) INNER JOIN glaccounts ON (invoiceglbreakdown.strAccID=glaccounts.strAccID) INNER JOIN companies ON (glaccounts.strFacCode=companies.strComCode)   WHERE paymentdetails.strVoucherNo='$PayVoucherNo'";
		
		//$strSQL="SELECT invoiceglbreakdown.strInvoiceNo, invoiceglbreakdown.strSupplierId, invoiceglbreakdown.dtmDate, invoiceglbreakdown.strAccID,invoiceglbreakdown.dblAmount,invoiceglbreakdown.strType,glaccounts.strDescription ,invoiceglbreakdown.dblAmount AS dblGLAmount ,companies.strName AS compName FROM paymentdetails INNER JOIN invoiceglbreakdown ON (paymentdetails.strInvoiceNo=invoiceglbreakdown.strInvoiceNo) INNER JOIN glaccounts ON (invoiceglbreakdown.strAccID=glaccounts.strAccID)  INNER JOIN companies ON (glaccounts.strFacCode=companies.strComCode)   WHERE paymentdetails.strVoucherNo='$PayVoucherNo'  and paymentdetails.strType='$strPaymentType' GROUP BY invoiceglbreakdown.strInvoiceNo, invoiceglbreakdown.strSupplierId, invoiceglbreakdown.dtmDate,invoiceglbreakdown.strAccID,invoiceglbreakdown.dblAmount, invoiceglbreakdown.strType, glaccounts.strDescription , invoiceglbreakdown.dblAmount,companies.strName";
		
				//$strSQL="SELECT invoiceglbreakdown.strSupplierId, invoiceglbreakdown.strAccID,sum(invoiceglbreakdown.dblAmount) as dblAmount,invoiceglbreakdown.strType,glaccounts.strDescription ,sum(invoiceglbreakdown.dblAmount) AS dblGLAmount ,companies.strName AS compName FROM paymentdetails INNER JOIN invoiceglbreakdown ON (paymentdetails.strInvoiceNo=invoiceglbreakdown.strInvoiceNo) INNER JOIN paymentheader ON(paymentheader.intVoucherNo=paymentdetails.strVoucherNo) INNER JOIN glaccounts ON (invoiceglbreakdown.strAccID=glaccounts.strAccID) INNER JOIN companies  ON (paymentheader.userFactoryCode=companies.intCompanyID) WHERE paymentdetails.strVoucherNo='$PayVoucherNo' AND paymentdetails.strType='$strPaymentType' GROUP BY  invoiceglbreakdown.strSupplierId, invoiceglbreakdown.strAccID,invoiceglbreakdown.strType, glaccounts.strDescription ,companies.strName";
				
				/*
				$strSQL="delete from tempglbreackdown";
				$db->RunQuery($strSQL);
				
				$strSQL="SELECT glaccounts.strDescription,invoiceglbreakdown.strAccID,(invoiceglbreakdown.dblAmount) AS dblAmount,companies.strName FROM invoiceglbreakdown INNER JOIN paymentscheduledetails ON invoiceglbreakdown.strInvoiceNo = paymentscheduledetails.strInvoiceNo INNER JOIN paymentscheduleheader ON paymentscheduledetails.strScheduelNo = paymentscheduleheader.strScheduelNo AND invoiceglbreakdown.strSupplierId = paymentscheduleheader.strSupplierId INNER JOIN paymentheader ON paymentscheduleheader.strScheduelNo = paymentheader.strSchedulNo  AND paymentheader.strType=paymentscheduledetails.strType  INNER JOIN glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID INNER JOIN companies ON companies.intCompanyID = paymentheader.userFactoryCode WHERE paymentheader.intVoucherNo='$PayVoucherNo' AND paymentheader.strType='$strPaymentType' GROUP BY glaccounts.strDescription,invoiceglbreakdown.strAccID,invoiceglbreakdown.strInvoiceNo,paymentheader.userFactoryCode";
			
			
		
			
				$result=$db->RunQuery($strSQL);
				
				while($row = mysql_fetch_array($result))
				{ 
					$glacc			=$row["strDescription"];
					$glaccNo		=$row["strAccID"];
					$glaccAmt		=$row["dblAmount"];
					$glaccFactory	=$row["strName"];
					
					$strTSQL="insert into tempglbreackdown(description,glaccno,amount,factory) values('$glacc', '$glaccNo', '$glaccAmt', '$glaccFactory')";
					
					
					
					$db->RunQuery($strTSQL);
				}
				
				*/
				/*
				//$strTSQL="select description,glaccno,sum(amount) as dblGLAmount,factory from tempglbreackdown group by description, glaccno,factory";
				$strTSQL = "SELECT glaccounts.strDescription,invoiceglbreakdown.strAccID,(invoiceglbreakdown.dblAmount) AS dblAmount,companies.strName 
FROM invoiceglbreakdown INNER JOIN paymentscheduledetails ON invoiceglbreakdown.strInvoiceNo = paymentscheduledetails.strInvoiceNo 
INNER JOIN paymentscheduleheader ON paymentscheduledetails.strScheduelNo = paymentscheduleheader.strScheduelNo 
AND invoiceglbreakdown.strSupplierId = paymentscheduleheader.strSupplierId
 INNER JOIN paymentheader 
ON paymentscheduleheader.strScheduelNo = paymentheader.strSchedulNo AND paymentheader.strType=paymentscheduledetails.strType 
INNER JOIN glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID INNER JOIN companies 
ON companies.intCompanyID = paymentheader.userFactoryCode 
INNER JOIN paymentdetails ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo AND invoiceglbreakdown.strInvoiceNo = paymentdetails.strInvoiceNo
WHERE paymentheader.intVoucherNo='$PayVoucherNo' 
AND paymentheader.strType='$strPaymentType' GROUP BY glaccounts.strDescription,invoiceglbreakdown.strAccID,invoiceglbreakdown.strInvoiceNo,
paymentheader.userFactoryCode";
*/

//lasantha
/*$strTSQL = "SELECT SUM(invoiceglbreakdown.dblAmount ) AS PaidAmount , companies.strName, glaccounts.strDescription, glaccounts.strAccID
FROM invoiceglbreakdown
INNER JOIN glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID 
INNER JOIN companies ON companies.strComCode = glaccounts.strFacCode 
INNER JOIN invoiceheader ON invoiceheader.strInvoiceNo = invoiceglbreakdown.strInvoiceNo AND companies.intcompanyiD = invoiceheader.intcompanyiD AND
invoiceheader.strSupplierId = invoiceglbreakdown.strSupplierId
 WHERE  invoiceglbreakdown.strInvoiceNo 
 IN (SELECT DISTINCT strInvoiceNo FROM paymentdetails WHERE paymentdetails.strVoucherNo = '$PayVoucherNo' AND paymentdetails.strType = '$strPaymentType' )  AND invoiceglbreakdown.strType = '$strPaymentType' 
  AND invoiceheader.strSupplierId = (SELECT strSupCode FROM paymentheader WHERE intVoucherNo = '$PayVoucherNo' AND strType = '$strPaymentType')
 GROUP BY glaccounts.strDescription, companies.strName";*/
 
 //roshan
/* $strTSQL = "	SELECT
				glaccounts.strDescription,
				invoiceglbreakdown.strAccID,
				invoiceglbreakdown.dblAmount,
				companies.strName
				FROM
				paymentdetails
				Inner Join invoiceglbreakdown ON paymentdetails.strInvoiceNo = invoiceglbreakdown.strInvoiceNo
				Inner Join glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID
				Inner Join companies ON companies.strComCode = glaccounts.strFacCode
				Inner Join paymentheader ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo
				WHERE
				paymentdetails.strVoucherNo =  '$PayVoucherNo' AND
				paymentheader.strType =  '$strPaymentType'


				";
				*/
			/*$strTSQL = "SELECT
						glaccounts.strDescription,
						invoiceglbreakdown.strAccID,
						Sum(paymentdetails.dblAmount) AS tt,
						invoiceglbreakdown.dblAmount,
						companies.strName
						FROM
						paymentdetails
						Inner Join invoiceglbreakdown ON invoiceglbreakdown.strInvoiceNo = paymentdetails.strInvoiceNo
						Inner Join glaccounts ON glaccounts.strAccID = invoiceglbreakdown.strAccID
						Inner Join paymentheader ON paymentdetails.strVoucherNo = paymentheader.intVoucherNo
						Inner Join companies ON companies.intCompanyID = paymentheader.userFactoryCode
						WHERE
						paymentdetails.strType =  '$strPaymentType' AND
						paymentdetails.strVoucherNo =  '$PayVoucherNo'
						GROUP BY
						paymentdetails.strInvoiceNo,invoiceglbreakdown.strAccID
						";*/
				$sqlGS="select pd.strSchedulNo from paymentdetails pd 
inner join paymentscheduleheader psh on psh.strScheduelNo=pd.strSchedulNo
where pd.strVoucherNo='$PayVoucherNo' and pd.strType='$strPaymentType';";	
				//echo $sqlGS;
				$result=$db->RunQuery($sqlGS);
				
		
		while($rowSNo  = mysql_fetch_array($result))
		{ 
		/*$sqlGGL="select g.strAccID,g.strDescription,c.strName,ibd.dblAmount from paymentscheduledetails psd
				inner join invoiceglbreakdown ibd on ibd.strInvoiceNo=psd.strInvoiceNo
				inner join glallowcation glf on glf.GLAccNo=ibd.strAccID
				inner join glaccounts g on g.intGLAccID=glf.GLAccNo
				inner join companies c on c.intCompanyID=glf.FactoryCode
				where psd.strScheduelNo='".$rowSNo['strSchedulNo']."'";*/
				
				
		$sqlGGL="SELECT DISTINCT
				paymentscheduleheader.strScheduelNo,
				paymentscheduleheader.strSupplierId,
				paymentscheduledetails.strInvoiceNo,
				invoiceglbreakdown.dblAmount,
				invoiceglbreakdown.strAccID,
				paymentscheduleheader.strType,
				glallowcation.FactoryCode,
				glaccounts.strAccID,
				glaccounts.strDescription,
				companies.strName,
				companies.strAccountNo
				FROM
				paymentscheduleheader
				Inner Join paymentscheduledetails ON paymentscheduledetails.strScheduelNo = paymentscheduleheader.strScheduelNo
				Inner Join invoiceglbreakdown ON paymentscheduledetails.strInvoiceNo = invoiceglbreakdown.strInvoiceNo
				Inner Join glallowcation ON glallowcation.GLAccAllowNo = invoiceglbreakdown.strAccID
				Inner Join glaccounts ON glaccounts.intGLAccID = glallowcation.GLAccNo
				Inner Join companies ON glallowcation.FactoryCode = companies.intCompanyID
				WHERE
				paymentscheduleheader.strScheduelNo =  '".$rowSNo['strSchedulNo']."' AND
				paymentscheduleheader.strType =  '$strPaymentType';";
				$res=$db->RunQuery($sqlGGL);
				while($rowGL  = mysql_fetch_array($res)){
		?>
		
      <tr>
        <td height="18" class="normalfntTAB"><?php  echo  $rowGL["strDescription"]; ?></td>
        <td class="normalfntTAB"><?php  echo  $rowGL["strAccID"].''.$rowGL["strAccountNo"]; ?></td>
        <td class="normalfntTAB" style="text-align:right"><?php  echo(number_format($rowGL["dblAmount"],4))  ; ?></td>
        <td class="normalfntTAB" style="text-align:right"><?php  echo  $rowGL["strName"]; ?></td>
      </tr>
      <?php
	  	}
	  }
	  ?>

    </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td width="20%" class="normalfnt">PREPARED BY</td>
        <td width="25%" class="bcgl1txt1"><?php 
		
		$SQL = "select Name from useraccounts where intUserID  =" . $_SESSION["UserID"] ;
		$result = $db->RunQuery($SQL);
	
		while($row = mysql_fetch_array($result))
		{
			echo $row["Name"];
		}
		?>&nbsp;</td>
        <td width="13%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
        <td width="27%">&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">CHECKED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">AUTHORIZED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="normalfnt">APPROVED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnt">RECEIVED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
