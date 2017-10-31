<?php
	session_start();
	
	include "../Connector.php";
	$PayVoucherNo=$_GET["PayVoucherNo"];
	$payeeID=$_GET["payeeid"];
	$backwardseperator = "../";
	$report_companyId=$_SESSION['FactoryID'];
	//$intPaymentNo = 40016;
	 ///$payeeID="";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Payment Voucher - Payment Schedule</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
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

$strSQL="SELECT withoutpovoucher.dtDate,payee.strTitle,withoutpovoucher.strPayeeID FROM withoutpovoucher INNER JOIN payee ON (withoutpovoucher.strPayeeID=payee.intPayeeID) WHERE withoutpovoucher.strVoucherNo='$PayVoucherNo'";
$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	//$payeeID= $row["strPayeeID"];
	//echo $payeeID;
	$payee= $row["strTitle"];
	$date= $row["dtDate"];
}

?>


<table width="800" border="0" align="center">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
	    <td colspan="4"><?php include '../reportHeader.php';?></td>
  </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td height="36" colspan="5" class="head2"> PAYMENT SCHEDULE</td>
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
        <td width="16%" height="25" class="normalfntBtab">INVOICE NO</td>
        <td width="15%" class="normalfntBtab">INVOICE AMOUNT</td>
        <td width="13%" class="normalfntBtab">TAX AMOUNT</td>
        <td width="12%" class="normalfntBtab">DISCOUNT</td>
        <td width="12%" class="normalfntBtab">Cr/Dr AMOUNT</td>
        <td width="12%" class="normalfntBtab">Cr/Dr TAX</td>
        <td width="20%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
			//$strSQL="SELECT paymentdetails.*,paymentheader.dtDate,paymentheader.strSupCode,suppliers.strTitle FROM paymentheader  INNER JOIN paymentdetails  ON (paymentheader.intVoucherNo=paymentdetails.strVoucherNo) INNER JOIN suppliers ON (paymentheader.strSupCode=suppliers.strSupplierID) WHERE paymentdetails.strVoucherNo= '$PayVoucherNo'";
			
			$strSQL="SELECT   withoutpoinvoice.invoiceNo,  withoutpoinvoice.discription,  sum(withoutpoinvoice.amount) AS amount,  sum(withoutpoinvoice.discount) AS discount,  sum(withoutpoinvoice.taxAmt) AS taxAmt,  sum(withoutpoinvoice.totalInvAmount) AS totalInvAmount,   withoutpoinvoice.currency FROM  withoutpoinvoicescheduledetails  INNER JOIN withoutpoinvoice ON (withoutpoinvoicescheduledetails.strInvoiceNo=withoutpoinvoice.invoiceNo)  INNER JOIN withoutpovoucher ON (withoutpovoucher.strScheduleNo=withoutpoinvoicescheduledetails.strScheduleNo) WHERE   (withoutpovoucher.strVoucherNo = '$PayVoucherNo') And withoutpoinvoice.payeeID='$payeeID' GROUP BY   withoutpoinvoice.invoiceNo,  withoutpoinvoice.discription,  withoutpoinvoice.currency"; 
			
			//echo($strSQL);
			$result=$db->RunQuery($strSQL);
			
			while($row = mysql_fetch_array($result))
			{ 
		?>
		
      <tr>
        <td class="normalfntTAB"><?php echo($row["invoiceNo"]);  ?></td>
        <td class="normalfntRiteTAB"><?php echo(round($row["amount"],2));  ?></td>
        <td class="normalfntRiteTAB"><?php echo(round($row["taxAmt"],2));  ?></td>
        <td class="normalfntRiteTAB"><?php echo(round($row["discount"],2));  ?></td>
        <td class="normalfntRiteTAB">0.00</td>
        <td class="normalfntMidTAB">0.00</td>
        <td class="normalfntRiteTAB"><?php $total +=round($row["totalInvAmount"],2);
											 echo (round($row["totalInvAmount"],2)); ?></td>
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
        <td class="nfhighlite1"><?php echo($total); ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
