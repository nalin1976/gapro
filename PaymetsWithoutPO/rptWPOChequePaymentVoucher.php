<?php
	session_start();
	$backwardseperator = "../";
	include "../Connector.php";
	$PayVoucherNo=$_GET["PayVoucherNo"];
	
	$strSQL="select strPayeeID from withoutpovoucher where strVoucherNo='$PayVoucherNo' ";
	
	$result=$db->RunQuery($strSQL);
	while($row = mysql_fetch_array($result))
	{ 
		$payeeID = $row["strPayeeID"];
	}
	
	$amt=$_GET["amt"];
	$report_companyId=$_SESSION['FactoryID'];
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
.style6 {
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
</head>

<body a="getTotalInWords()">
<?php
$strSQL= "SELECT strName,strAddress1,strAddress2,strCity,strCountry,strPhone,strFax,strEMail,strWeb FROM companies WHERE companies.intCompanyID =" . $_SESSION["FactoryID"] ;
$result=$db->RunQuery($strSQL);
while(@$row = mysql_fetch_array($result))
{ 
	$companyName = $row["strName"];
	$address= $row["strAddress1"] + " " +  $row["strAddress2"] + " " +  $row["strCity"] + " " +  $row["strCountry"];
	$phone= $row["strPhone"];
	$fax= $row["strFax"];
	$web= $row["strWeb"];
	$email= $row["strEMail"];
}

//$strSQL="SELECT withoutpovoucher.*,payee.strTitle FROM withoutpovoucher INNER JOIN payee ON (withoutpovoucher.strPayeeID=payee.intPayeeID) WHERE withoutpovoucher.strVoucherNo='$PayVoucherNo';";

$strSQL="SELECT withoutpovoucher.dtDate,withoutpovoucher.strPayeeID,withoutpovoucher.strDescription,withoutpovoucher.strScheduleNo,withoutpovoucher.strBatchNo,withoutpovoucher.strChequeno, withoutpovoucher.strAccNo, withoutpovoucher.strTaxCode, withoutpovoucher.strCurrFrom, withoutpovoucher.dblRatefrom, withoutpovoucher.strCurrTo,withoutpovoucher.dblRateTo, withoutpovoucher.dblTotalAmount, withoutpovoucher.strUser, withoutpovoucher.intPrintStatus,withoutpovoucher.userFactory,withoutpovoucher.intchequeprint, payee.strTitle ,SUM(withoutpoinvoicetaxes.amount) AS taxAmount,(withoutpovoucher.dblTotalAmount-SUM(withoutpoinvoicetaxes.amount)) AS Amount FROM withoutpovoucher INNER JOIN payee ON (withoutpovoucher.strPayeeID=payee.intPayeeID) INNER JOIN withoutpoinvoicescheduledetails  ON (withoutpovoucher.strScheduleNo=withoutpoinvoicescheduledetails.strScheduleNo)  LEFT JOIN withoutpoinvoicetaxes  ON (withoutpoinvoicescheduledetails.strInvoiceNo=withoutpoinvoicetaxes.invoiceNo)  WHERE withoutpovoucher.strVoucherNo='$PayVoucherNo' GROUP BY withoutpovoucher.dtDate,withoutpovoucher.strPayeeID, withoutpovoucher.strDescription, withoutpovoucher.strScheduleNo, withoutpovoucher.strBatchNo,withoutpovoucher.strChequeno,withoutpovoucher.strAccNo, withoutpovoucher.strTaxCode, withoutpovoucher.strCurrFrom,withoutpovoucher.dblRatefrom,withoutpovoucher.strCurrTo,withoutpovoucher.dblRateTo, withoutpovoucher.dblTotalAmount,withoutpovoucher.strUser,withoutpovoucher.intPrintStatus, withoutpovoucher.userFactory,withoutpovoucher.intchequeprint,payee.strTitle";


//echo ($strSQL);


$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["dtDate"];
	$chequeNo= $row["strChequeno"];
	$batchNo=$row["strBatchNo"];
}

?>

<table width="800" border="0" align="center">
  <tr>
    <td colspan="2"><table width="100%" cellpadding="0" cellspacing="0">
       	<tr>
	    	<td colspan="4"><?php include '../reportHeader.php';?></td>
  		</tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="42" colspan="5" class="head2">CHEQUE PAYMENT VOUCHER - WPO</td>
        <td height="42" class="head2">&nbsp;</td>
        <td width="16%"><DIV id="divPrintStatus">
		<table width="124" height="20" border="0" cellpadding="0" cellspacing="0">
          <tr>
		  <?php
			  	$strSQL="SELECT intPrintStatus FROM withoutpovoucher WHERE strVoucherNo='$PayVoucherNo'";
				$result=$db->RunQuery($strSQL);
				
				while($row = mysql_fetch_array($result))
				{ 
					$status= $row["intPrintStatus"];
				}
				
				if($status==0)
				{
					$strSQL="UPDATE withoutpovoucher SET intPrintStatus=1 WHERE strVoucherNo='$PayVoucherNo'";
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
        <td width="12%" height="23" class="normalfnth2B">PAYEE</td>
        <td width="32%" class="normalfnt"><?php echo $payee; ?></td>
        <td width="13%"><span class="normalfnth2B">VOUCHER NO</span></td>
        <td width="15%" class="normalfnth2B"><span class="normalfnt"><?php echo $PayVoucherNo; ?></span></td>
        <td width="9%" class="normalfnth2B">Batch No </td>
        <td colspan="2" class="normalfnt"><?php echo $batchNo; ?></td>
      </tr>
      <tr>
        <td class="normalfnth2B">CHEQUE NO</td>
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
        <td width="36%" height="25" class="normalfntBtab">DISCRIPTION</td>
        <td width="14%" class="normalfntBtab">AMOUNT</td>
        <td width="10%" class="normalfntBtab">VAT</td>
        <td width="13%" class="normalfntBtab">Cr/Dr</td>
        <td width="11%" class="normalfntBtab">Cr/Dr Tax</td>
        <td width="16%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
		//$strSQL="SELECT * FROM withoutpovoucher WHERE strVoucherNo='$PayVoucherNo'";
		$strSQL="SELECT withoutpovoucher.dtDate, withoutpovoucher.strPayeeID, withoutpovoucher.strDescription, withoutpovoucher.strScheduleNo,withoutpovoucher.strBatchNo,withoutpovoucher.strChequeno,withoutpovoucher.strAccNo, withoutpovoucher.strTaxCode,withoutpovoucher.strCurrFrom,withoutpovoucher.dblRatefrom,withoutpovoucher.strCurrTo, withoutpovoucher.dblRateTo,withoutpovoucher.strUser,withoutpovoucher.intPrintStatus,withoutpovoucher.userFactory, withoutpovoucher.intchequeprint,withoutpovoucher.dblTotalAmount,SUM(withoutpoinvoicetaxes.amount) AS taxAmount,(withoutpovoucher.dblTotalAmount-SUM(withoutpoinvoicetaxes.amount)) AS Amount FROM withoutpovoucher INNER JOIN withoutpoinvoicescheduledetails ON (withoutpovoucher.strScheduleNo=withoutpoinvoicescheduledetails.strScheduleNo) LEFT JOIN withoutpoinvoicetaxes ON (withoutpoinvoicescheduledetails.strInvoiceNo=withoutpoinvoicetaxes.invoiceNo) WHERE withoutpovoucher.strVoucherNo='$PayVoucherNo' GROUP BY withoutpovoucher.dtDate, withoutpovoucher.strPayeeID,withoutpovoucher.strDescription, withoutpovoucher.strScheduleNo,withoutpovoucher.strBatchNo,withoutpovoucher.strChequeno,withoutpovoucher.strAccNo, withoutpovoucher.strTaxCode,withoutpovoucher.strCurrFrom,withoutpovoucher.dblRatefrom,withoutpovoucher.strCurrTo, withoutpovoucher.dblRateTo,withoutpovoucher.dblTotalAmount,withoutpovoucher.strUser,withoutpovoucher.intPrintStatus, withoutpovoucher.userFactory,withoutpovoucher.intchequeprint";
		
		//echo $strSQL;
		
		$result=$db->RunQuery($strSQL);
		
		while($row = mysql_fetch_array($result))
		{ 
		?>
			<tr>
			<td class="normalfntTAB"><?php  echo  $row["strDescription"]; ?></td>
			<td class="normalfntRiteTAB"><?php echo(number_format($row["dblTotalAmount"]-$row["taxAmount"],2));	?></td>
			<td class="normalfntRiteTAB"><?php echo(number_format($row["taxAmount"],2)) ;?></td>
			<td class="normalfntRiteTAB"><?php echo("0.00");?></td>
			<td class="normalfntRiteTAB"><?php echo("0.00"); ?></td>
			<td class="normalfntRiteTAB"><?php $total += $row["dblTotalAmount"]; echo(number_format($row["dblTotalAmount"],2)); ?></td>
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
        <td width="34%" class="normalfntBtab">ADDRESS</td>
        </tr>
		<?php
		//$strSQL="SELECT invoiceglbreakdown.*,glaccounts.strDescription ,invoiceglbreakdown.dblAmount AS dblGLAmount ,companies.strName AS compName FROM paymentdetails INNER JOIN invoiceglbreakdown ON (paymentdetails.strInvoiceNo=invoiceglbreakdown.strInvoiceNo) INNER JOIN glaccounts ON (invoiceglbreakdown.strAccID=glaccounts.strAccID) INNER JOIN companies ON (glaccounts.strFacCode=companies.strComCode)   WHERE paymentdetails.strVoucherNo='$PayVoucherNo'";
		
		//$strSQL="SELECT   glaccounts.strAccID,  glaccounts.strDescription,  sum(withoutpoinvoiceglallowcation.amount) AS amount,  glaccounts.strFacCode,   companies.strName FROM  withoutpoinvoiceglallowcation  INNER JOIN glaccounts ON (withoutpoinvoiceglallowcation.glAccNo=glaccounts.strAccID)  INNER JOIN companies ON (glaccounts.strFacCode=companies.strComCode)  INNER JOIN withoutpoinvoice ON (withoutpoinvoice.invoiceNo=withoutpoinvoiceglallowcation.invoiceNo)  INNER JOIN withoutpoinvoicescheduledetails ON (withoutpoinvoicescheduledetails.strInvoiceNo=withoutpoinvoice.invoiceNo)  INNER JOIN withoutpovoucher ON (withoutpovoucher.strScheduleNo=withoutpoinvoicescheduledetails.strScheduleNo) WHERE   (withoutpovoucher.strVoucherNo = '$PayVoucherNo') GROUP BY   glaccounts.strAccID,  glaccounts.strDescription,  glaccounts.strFacCode,  companies.strName";
		
		//$strSQL="SELECT glaccounts.strAccID, glaccounts.strDescription, SUM(withoutpoinvoiceglallowcation.amount) AS amount, companies.strComCode, companies.strName FROM withoutpoinvoiceglallowcation INNER JOIN glaccounts ON (withoutpoinvoiceglallowcation.glAccNo=glaccounts.strAccID) INNER JOIN withoutpoinvoice ON (withoutpoinvoice.invoiceNo=withoutpoinvoiceglallowcation.invoiceNo) INNER JOIN withoutpoinvoicescheduledetails ON (withoutpoinvoicescheduledetails.strInvoiceNo=withoutpoinvoice.invoiceNo) INNER JOIN withoutpovoucher ON (withoutpovoucher.strScheduleNo=withoutpoinvoicescheduledetails.strScheduleNo) INNER JOIN companies ON (withoutpovoucher.userFactory=companies.intCompanyID) WHERE (withoutpovoucher.strVoucherNo = '101') GROUP BY glaccounts.strAccID, glaccounts.strDescription, companies.strComCode, companies.strName";
		
		//echo $strSQL;
		
		//$strSQL="SELECT withoutpoinvoiceglallowcation.glAccNo, withoutpoinvoiceglallowcation.invoiceNo, withoutpoinvoiceglallowcation.amount, withoutpoinvoicescheduledetails.strScheduleNo, glaccounts.strDescription, withoutpovoucher.userFactory, companies.strName FROM withoutpoinvoiceglallowcation INNER JOIN withoutpoinvoicescheduledetails ON withoutpoinvoicescheduledetails.strInvoiceNo = withoutpoinvoiceglallowcation.invoiceNo INNER JOIN glaccounts ON glaccounts.strAccID = withoutpoinvoiceglallowcation.glAccNo INNER JOIN withoutpovoucher ON withoutpovoucher.strScheduleNo = withoutpoinvoicescheduledetails.strScheduleNo INNER JOIN companies ON withoutpovoucher.userFactory = companies.intCompanyID WHERE withoutpovoucher.strVoucherNo='$PayVoucherNo'  GROUP BY withoutpoinvoiceglallowcation.glAccNo, withoutpoinvoiceglallowcation.invoiceNo, withoutpoinvoiceglallowcation.amount, withoutpoinvoicescheduledetails.strScheduleNo, glaccounts.strDescription, withoutpovoucher.userFactory, companies.strName";
		
		//$strSQL="SELECT withoutpoinvoiceglallowcation.glAccNo, withoutpoinvoiceglallowcation.invoiceNo, withoutpoinvoiceglallowcation.amount, withoutpoinvoicescheduledetails.strScheduleNo, glaccounts.strDescription, withoutpovoucher.userFactory, companies.strName FROM withoutpoinvoiceglallowcation INNER JOIN withoutpoinvoicescheduledetails ON withoutpoinvoicescheduledetails.strInvoiceNo = withoutpoinvoiceglallowcation.invoiceNo INNER JOIN glaccounts ON glaccounts.strAccID = withoutpoinvoiceglallowcation.glAccNo INNER JOIN withoutpovoucher ON withoutpovoucher.strScheduleNo = withoutpoinvoicescheduledetails.strScheduleNo INNER JOIN withoutpoinvoicescheduleheader ON withoutpoinvoicescheduleheader.strScheduleNo = withoutpoinvoicescheduledetails.strScheduleNo AND withoutpoinvoicescheduleheader.strPayeeID=withoutpovoucher.strPayeeID AND withoutpoinvoiceglallowcation.payeeID = withoutpoinvoicescheduleheader.strPayeeID INNER JOIN companies ON withoutpovoucher.userFactory = companies.intCompanyID WHERE withoutpovoucher.strVoucherNo='$PayVoucherNo' GROUP BY withoutpoinvoiceglallowcation.glAccNo, withoutpoinvoiceglallowcation.invoiceNo, withoutpoinvoiceglallowcation.amount,withoutpoinvoicescheduledetails.strScheduleNo, glaccounts.strDescription, withoutpovoucher.userFactory, companies.strName";
		
		
/*		$strSQL="SELECT withoutpoinvoiceglallowcation.glAccNo, withoutpoinvoiceglallowcation.invoiceNo, sum(withoutpoinvoiceglallowcation.amount) as amount, withoutpoinvoicescheduledetails.strScheduleNo, glaccounts.strDescription, withoutpovoucher.userFactory, companies.strName FROM withoutpoinvoiceglallowcation INNER JOIN withoutpoinvoicescheduledetails ON withoutpoinvoicescheduledetails.strInvoiceNo = withoutpoinvoiceglallowcation.invoiceNo INNER JOIN glaccounts ON glaccounts.strAccID = withoutpoinvoiceglallowcation.glAccNo INNER JOIN withoutpovoucher ON withoutpovoucher.strScheduleNo = withoutpoinvoicescheduledetails.strScheduleNo INNER JOIN withoutpoinvoicescheduleheader ON withoutpoinvoicescheduleheader.strScheduleNo = withoutpoinvoicescheduledetails.strScheduleNo AND withoutpoinvoicescheduleheader.strPayeeID=withoutpovoucher.strPayeeID INNER JOIN companies ON withoutpovoucher.userFactory = companies.intCompanyID WHERE withoutpovoucher.strVoucherNo='$PayVoucherNo' and withoutpoinvoiceglallowcation.payeeID='$payeeID' GROUP BY withoutpoinvoiceglallowcation.glAccNo, withoutpoinvoicescheduledetails.strScheduleNo, 
glaccounts.strDescription, withoutpovoucher.userFactory, companies.strName";*/
		
		$strSQL = "SELECT
				withoutpovoucher.strVoucherNo,
				withoutpoinvoiceglallowcation.invoiceNo,
				withoutpoinvoiceglallowcation.amount,
				withoutpoinvoiceglallowcation.glAccNo as glAccNo,
				companies.strName,
				(select distinct glaccounts.strDescription from glaccounts where glaccounts.strAccID = withoutpoinvoiceglallowcation.glAccNo) as strDescription
				FROM
				withoutpovoucher
				Inner Join withoutpoinvoicescheduleheader ON withoutpovoucher.strScheduleNo = withoutpoinvoicescheduleheader.strScheduleNo
				Inner Join withoutpoinvoicescheduledetails ON withoutpoinvoicescheduledetails.strScheduleNo = withoutpoinvoicescheduleheader.strScheduleNo
				Inner Join withoutpoinvoiceglallowcation ON withoutpoinvoicescheduledetails.strInvoiceNo = withoutpoinvoiceglallowcation.invoiceNo
				Inner Join withoutpoinvoice ON withoutpoinvoice.invoiceNo = withoutpoinvoicescheduledetails.strInvoiceNo AND withoutpoinvoice.payeeID = withoutpoinvoicescheduleheader.strPayeeID
				Inner Join companies ON companies.intCompanyID = withoutpoinvoice.companyID
				WHERE
				withoutpovoucher.strVoucherNo =  '$PayVoucherNo' AND
				withoutpovoucher.strPayeeID =  '$payeeID'
				";
		///echo $strSQL;
		
		$result=$db->RunQuery($strSQL);
		
		while($row = mysql_fetch_array($result))
		{ 
		?>
		
      <tr>
        <td height="18" class="normalfntTAB"><?php  echo  $row["strDescription"]; ?></td>
        <td class="normalfntTAB"><?php  echo  $row["glAccNo"]; ?></td>
        <td class="normalfntTAB" style="text-align:right"><?php  echo(number_format($row["amount"],2)); ?></td>
        <td class="normalfntTAB" style="text-align:right"><?php  echo  $row["strName"]; ?></td>
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
        <td class="normalfnt">RECIVED BY</td>
        <td class="bcgl1txt1">&nbsp;</td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
