<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";
	$PayVoucherNo=$_GET["PayVoucherNo"];
	$strPaymentType=$_GET["strPaymentType"];
	$supid=$_GET["supid"];
	//$report_companyId = $_SESSION["UserID"];
	$report_companyId=$_SESSION['FactoryID'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Voucher - Payment Schedule </title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
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

$strSQL="SELECT paymentheader.dtDate,paymentheader.strSupCode,suppliers.strTitle FROM paymentheader INNER JOIN suppliers ON (paymentheader.strSupCode=suppliers.strSupplierID) WHERE paymentheader.intVoucherNo=$PayVoucherNo  and paymentheader.strType='$strPaymentType'";
$result=$db->RunQuery($strSQL);
while($row = @mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["dtDate"];
}

?>


<table width="800" border="0" align="center"><!--
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="6%" class="normalfnt">&nbsp;</td>
        <td width="74%" class="tophead"><p class="topheadBLACK"><?php echo $companyName; ?></p>
            <p class="normalfnt"><?php echo $address; ?>. Tel: <?php echo $phone; ?> Fax: <?php echo $fax; ?></p>
          <p class="normalfnt">E-Mail: <?php echo $email; ?> Web: <?php echo $web; ?> </p></td>
      </tr>
    </table></td>
  </tr>
  -->
  <tr>
	    <td colspan="4"><?php include '../reportHeader.php';?></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="5" class="head2">PAYMENT SCHEDULE<?php if($strPaymentType=="S")
		{
			echo(" - STYLE");
		} 
		else if($strPaymentType=="G")
		{
			echo(" - GENERAL");
		}
		?></td>
      </tr>
      <tr>
        <td width="10%" class="normalfnth2B">PAYEE</td>
        <td width="40%" class="normalfnt"><?php echo $payee; ?></td>
        <td width="4%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">VOUCHER NO</td>
        <td width="27%" class="normalfnt"><?php echo $PayVoucherNo; ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">DATE</td>
        <td class="normalfnt"><?php echo $date; ?></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez">
      <tr>
        <td width="27%" height="25" class="normalfntBtab">INVOICE NO</td>
        <td width="15%" class="normalfntBtab">INVOICE AMOUNT</td>
        <td width="15%" class="normalfntBtab">TAX AMOUNT</td>
        <td width="15%" class="normalfntBtab">Cr/Dr AMOUNT</td>
        <td width="14%" class="normalfntBtab">Cr/Dr TAX</td>
        <td width="14%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
			//$strSQL="SELECT paymentdetails.*,paymentheader.dtDate,paymentheader.strSupCode,suppliers.strTitle FROM paymentheader  INNER JOIN paymentdetails  ON (paymentheader.intVoucherNo=paymentdetails.strVoucherNo) INNER JOIN suppliers ON (paymentheader.strSupCode=suppliers.strSupplierID) WHERE paymentdetails.strVoucherNo= '$PayVoucherNo'";
			
			//$strSQL="SELECT paymentdetails.strVoucherNo,paymentdetails.strInvoiceNo,SUM(paymentdetails.dblAmount) AS dblAmount,SUM(paymentdetails.balance)AS balance,SUM(paymentdetails.PaidAmount) AS PaidAmount,paymentheader.dtDate,paymentheader.strSupCode,suppliers.strTitle FROM paymentheader  INNER JOIN paymentdetails  ON (paymentheader.intVoucherNo=paymentdetails.strVoucherNo) INNER JOIN suppliers ON (paymentheader.strSupCode=suppliers.strSupplierID) WHERE paymentdetails.strVoucherNo= '$PayVoucherNo'  and paymentdetails.strType='$strPaymentType' and paymentheader.strSupCode='$supid' GROUP BY paymentdetails.strVoucherNo, paymentdetails.strInvoiceNo, paymentheader.dtDate, paymentheader.strSupCode,suppliers.strTitle"; 
			
			$strSQLTax="SELECT distinct (invoicetaxes.dblamount) AS taxAmount FROM paymentheader 
INNER JOIN paymentscheduleheader ON paymentheader.strSchedulNo=paymentscheduleheader.strScheduelNo
INNER JOIN paymentscheduledetails ON paymentscheduleheader.strScheduelNo=paymentscheduledetails.strScheduelNo
INNER JOIN invoicetaxes ON paymentscheduledetails.strInvoiceNo=invoicetaxes.strinvoiceno AND paymentheader.strSupCode=invoicetaxes.strsupplierid WHERE paymentheader.intVoucherNo='$PayVoucherNo' AND paymentheader.strType='$strPaymentType'";

		$taxresult=$db->RunQuery($strSQLTax);
		
		while($taxrow = mysql_fetch_array($taxresult))
		{ 
			$taxTotal=$taxTotal+$taxrow["taxAmount"];
		}
			
			/*
			$strSQL="SELECT invoiceglbreakdown.strInvoiceNo,invoiceglbreakdown.dblAmount AS PaidAmount,companies.strName 
FROM invoiceglbreakdown INNER JOIN paymentscheduledetails ON invoiceglbreakdown.strInvoiceNo = paymentscheduledetails.strInvoiceNo
 INNER JOIN paymentscheduleheader ON paymentscheduledetails.strScheduelNo = paymentscheduleheader.strScheduelNo 
 AND invoiceglbreakdown.strSupplierId = paymentscheduleheader.strSupplierId INNER JOIN paymentheader 
 ON paymentscheduleheader.strScheduelNo = paymentheader.strSchedulNo AND paymentheader.strType=paymentscheduledetails.strType 
 INNER JOIN glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID INNER JOIN companies 
 ON companies.intCompanyID = paymentheader.userFactoryCode 
 INNER JOIN paymentdetails ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo AND invoiceglbreakdown.strInvoiceNo = paymentdetails.strInvoiceNo
 WHERE paymentheader.intVoucherNo='$PayVoucherNo' AND paymentheader.strType='$strPaymentType' GROUP BY invoiceglbreakdown.strInvoiceNo,paymentheader.userFactoryCode";
 
 */
/* $strSQL = "SELECT strInvoiceNo,SUM(PaidAmount) AS PaidAmount FROM paymentdetails WHERE paymentdetails.strVoucherNo = '$PayVoucherNo' AND paymentdetails.strType = '$strPaymentType' 
GROUP BY strInvoiceNo";*/
			$strSQL = "	SELECT paymentscheduledetails.strInvoiceNo,
						Sum(paymentscheduledetails.dblSheduled) AS PaidAmount,
						paymentscheduledetails.strScheduelNo,paymentdetails.strType
						FROM
						paymentscheduleheader
						Inner Join paymentscheduledetails ON paymentscheduleheader.strScheduelNo = paymentscheduledetails.strScheduelNo
						Inner Join paymentdetails ON paymentscheduledetails.strScheduelNo = paymentdetails.strSchedulNo
						WHERE
						paymentdetails.strVoucherNo =  '$PayVoucherNo' AND
						paymentscheduledetails.strType =  '$strPaymentType'
						GROUP BY
						paymentscheduledetails.strInvoiceNo

						";
			$result=$db->RunQuery($strSQL);

			while($row = mysql_fetch_array($result))
			{ 
			
			
		?>
		
      <tr>
        <td class="normalfntTAB"><?php $strInvoiceNo=$row["strInvoiceNo"]; echo($row["strInvoiceNo"]);  ?></td>
        <td class="normalfntRiteTAB"><?php echo(number_format($row["PaidAmount"],4));  ?></td>
		<?php
			/*$strSQLInvoiceTax="SELECT DISTINCT (invoicetaxes.dblamount) AS taxAmount FROM paymentheader 
	INNER JOIN paymentscheduleheader ON paymentheader.strSchedulNo=paymentscheduleheader.strScheduelNo
	INNER JOIN paymentscheduledetails ON paymentscheduleheader.strScheduelNo=paymentscheduledetails.strScheduelNo
	INNER JOIN invoicetaxes ON paymentscheduledetails.strInvoiceNo=invoicetaxes.strinvoiceno AND paymentheader.strSupCode=invoicetaxes.strsupplierid WHERE paymentheader.intVoucherNo='$PayVoucherNo' AND invoicetaxes.strinvoiceno='$strInvoiceNo' AND  paymentheader.strType='$strPaymentType'";*/
	$strSQLInvoiceTax="SELECT
						distinct (invoicetaxes.dblamount) AS taxAmount 
						FROM
						paymentheader
						Inner Join paymentdetails ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo
						Inner Join paymentscheduleheader ON paymentscheduleheader.strScheduelNo = paymentdetails.strSchedulNo
						Inner Join paymentscheduledetails ON paymentscheduledetails.strScheduelNo = paymentscheduleheader.strScheduelNo
						INNER JOIN invoicetaxes ON paymentscheduledetails.strInvoiceNo=invoicetaxes.strinvoiceno 
						AND paymentheader.strSupCode=invoicetaxes.strsupplierid 
						WHERE invoicetaxes.strinvoiceno='$strInvoiceNo' AND paymentheader.strType='$strPaymentType';";

		$invoicetaxresult=$db->RunQuery($strSQLInvoiceTax);
		//echo $strSQLInvoiceTax;
		
		while($taxInvrow = mysql_fetch_array($invoicetaxresult))
		{ 
			$dblTaxAmount=$dblTaxAmount+$taxInvrow["taxAmount"];
		}
		?>

        <td class="normalfntRiteTAB"><?php echo(number_format($dblTaxAmount,4)) ;  ?></td>
        <td class="normalfntRiteTAB">0.00</td>
        <td class="normalfntMidTAB">0.00</td>
        <td class="normalfntRiteTAB"><?php 	$total +=$row["PaidAmount"]+$dblTaxAmount;
											    echo(number_format($row["PaidAmount"]+$dblTaxAmount,2)); ?></td>
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
        <td class="nfhighlite1"><?php echo(number_format($total,2)); ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>
		<table border="1" rules="all">
		<tr>
			<td width="27%" height="25" class="normalfntBtab">Schedule No</td><td width="27%" height="25" class="normalfntBtab">Invoice No</td><td width="27%" height="25" class="normalfntBtab">Amount</td>
		</tr>
		<?php 
		$sql="select pd.strSchedulNo,pd.strInvoiceNo,pd.dblAmount from paymentdetails pd where pd.strVoucherNo='$PayVoucherNo' and pd.strType='$strPaymentType';";
		$res=$db->RunQuery($sql);
		while($rowS=mysql_fetch_array($res)){?>
			<tr>
				<td class="normalfntRite"><?php echo $rowS['strSchedulNo'];?></td>
				<td class="normalfnt">&nbsp;<?php echo $rowS['strInvoiceNo'];?></td>
				<td class="normalfntRite"><?php echo number_format($rowS['dblAmount'],4);?></td>
			</tr>
		<?php }	?>
		</table>
	</td>
  </tr>
</table>
</body>
</html>
