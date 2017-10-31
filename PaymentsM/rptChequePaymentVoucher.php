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

$strSQL="SELECT paymentheader.intVoucherNo,paymentheader.strBatch,paymentheader.dtDate,paymentheader.strCheque,paymentheader.strSupCode,suppliers.strTitle FROM paymentheader INNER JOIN suppliers ON (paymentheader.strSupCode=suppliers.strSupplierID) WHERE intVoucherNo= '$PayVoucherNo' and strType='$strPaymentType';";
$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["dtDate"];
	$chequeNo= $row["strCheque"];
	$batchNo=$row["strBatch"];
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
		<td width="14%" class="normalfntBtab">Advance</td>
        <td width="10%" class="normalfntBtab">TAX</td>
        <td width="13%" class="normalfntBtab">Cr/Dr</td>
        <td width="11%" class="normalfntBtab">Cr/Dr Tax</td>
        <td width="16%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
		$strSQLTax="SELECT distinct (invoicetaxes.dblamount) AS taxAmount FROM paymentheader 
INNER JOIN paymentscheduleheader ON paymentheader.strSchedulNo=paymentscheduleheader.strScheduelNo
INNER JOIN paymentscheduledetails ON paymentscheduleheader.strScheduelNo=paymentscheduledetails.strScheduelNo
INNER JOIN invoicetaxes ON paymentscheduledetails.strInvoiceNo=invoicetaxes.strinvoiceno AND paymentheader.strSupCode=invoicetaxes.strsupplierid WHERE paymentheader.intVoucherNo='$PayVoucherNo' AND paymentheader.strType='$strPaymentType'";

		$taxresult=$db->RunQuery($strSQLTax);
		//echo $strSQLTax;
		while($taxrow = mysql_fetch_array($taxresult))
		{ 
			$taxTotal=$taxTotal+$taxrow["taxAmount"];
		}
		

						
		$adv_Paid = "SELECT DISTINCT
						suppliers.strTitle AS strSupCode,
						paymentheader.intVoucherNo,
						paymentheader.dtDate,
						paymentdetails.dblAmount AS PaidAmount,
						paymentheader.strCheque,
						paymentdetails.strType,
						advancepaymentpos.paidAmount
						FROM
						invoiceheader
						Inner Join invoicedetails ON invoiceheader.strInvoiceNo = invoicedetails.strInvoiceNo 
						AND invoiceheader.strSupplierId = invoicedetails.strSupplierId AND invoiceheader.strType = invoicedetails.strType
						Inner Join paymentscheduledetails ON invoicedetails.strInvoiceNo = paymentscheduledetails.strInvoiceNo 
						AND invoicedetails.strType = paymentscheduledetails.strType
						Inner Join paymentscheduleheader ON paymentscheduledetails.strScheduelNo = paymentscheduleheader.strScheduelNo 
						AND invoicedetails.strSupplierId = paymentscheduleheader.strSupplierId
						Inner Join paymentheader ON paymentscheduleheader.strScheduelNo = paymentheader.strSchedulNo 
						AND paymentscheduleheader.strSupplierId = paymentheader.strSupCode AND paymentscheduledetails.strType = paymentheader.strType
						Inner Join paymentdetails ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo 
						AND paymentscheduledetails.strInvoiceNo = paymentdetails.strInvoiceNo AND paymentheader.strType = paymentdetails.strType
						Left Join suppliers ON paymentheader.strSupCode = suppliers.strSupplierID
						Left Join advancepaymentpos ON paymentscheduledetails.strPONO = advancepaymentpos.POno 
						AND paymentscheduledetails.strPOYear = advancepaymentpos.POYear AND paymentdetails.strType = advancepaymentpos.strType
                        WHERE 
						paymentheader.intVoucherNo='$PayVoucherNo' AND paymentheader.strType='$strPaymentType'";			
		$advresult=$db->RunQuery($adv_Paid);
		while($advrow = mysql_fetch_array($advresult))
		{
		 
		 $paidAmount = $advrow["paidAmount"];
		 $totPaidAmt += $paidAmount; 
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
			<td class="normalfntRiteTAB"><?php  echo(number_format($amount,2))  ; ?></td>
			<td class="normalfntRiteTAB"><?php  echo(number_format($totPaidAmt,2))  ; ?></td>
			<td class="normalfntRiteTAB"><?php  echo(number_format($taxTotal,2));?></td>
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
		<td class="normalfnth2Bm">&nbsp;</td>
        <td class="nfhighlite1"><?php echo(number_format($total,2))  ; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td width="171"  class="normalfnth2B">Total Amount in Words : </td>
    <td width="619" class="normalfnt style3" ><?php echo($amt); ?></td>
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
        </tr>
		<?php

			$strTSQL = "SELECT
						invoiceglbreakdown.strAccID,
						Sum(paymentdetails.dblAmount) AS totAmt,
						paymentdetails.strType,
						glaccounts.strDescription
						FROM
						invoiceglbreakdown
						Inner Join paymentheader ON paymentheader.strSupCode = invoiceglbreakdown.strSupplierId
						Inner Join paymentdetails ON paymentheader.intVoucherNo = paymentdetails.strVoucherNo 
						AND paymentdetails.strInvoiceNo = invoiceglbreakdown.strInvoiceNo
						Inner Join glaccounts ON invoiceglbreakdown.strAccID = glaccounts.strAccID
						Inner Join companies ON glaccounts.intCompany = companies.intCompanyID
						WHERE
						
						paymentdetails.strVoucherNo =  '$PayVoucherNo' AND
						
						paymentdetails.strType =  '$strPaymentType'
						GROUP BY
						
						invoiceglbreakdown.strAccID,
						
						paymentdetails.strType";
						
				//echo $strTSQL;
				$result=$db->RunQuery($strTSQL);
		
		while($row = mysql_fetch_array($result))
		{ 
		?>
		
      <tr>
        <td height="18" class="normalfntTAB"><?php  echo  $row["strDescription"]; ?></td>
        <td class="normalfntTAB"><?php  echo  $row["strAccID"]; ?></td>
        <td class="normalfntTAB" style="text-align:right"><?php  echo(number_format($row["totAmt"],2))  ; ?></td>
        </tr>
      <?php
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
