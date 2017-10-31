		<?php
		session_start();

include "../Connector.php";



				
				$intPaymentNo=$_GET["PayNo"];
				//$intPaymentNo = 400049;
		 
		?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADVANCE PAYMENT</title>
<link href="../css/erpstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
$strSQL= "SELECT strName,strAddress1,strAddress2,strCity,strCountry,strPhone,strFax,strEMail,strWeb FROM companies WHERE companies.intCompanyID =" . $_SESSION["FactoryID"] ;
$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$companyName = $row["strName"];
	$address= $row["strAddress1"] + " " +  $row["strAddress2"] + " " +  $row["strCity"] + " " +  $row["strCountry"];
	$phone= $row["strPhone"];
	$fax= $row["strFax"];
	$web= $row["strWeb"];
	$email= $row["strEMail"];
}

$strSQL="SELECT advancepayment.PaymentNo,advancepayment.paydate,suppliers.strTitle FROM advancepayment INNER JOIN suppliers ON advancepayment.supid =  suppliers.strSupplierID WHERE advancepayment.PaymentNo = $intPaymentNo;";
$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["paydate"];
}

?>
<table width="800" border="0" align="center" bgcolor="#FFFFFF">
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
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" colspan="5" class="head2">ADVANCE PAYMENT</td>
      </tr>
      <tr>
        <td width="8%" class="normalfnth2B">PAYEE</td>
        <td width="40%" class="normalfnt"><?php echo $payee; ?></td>
        <td width="6%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">PAYMENT NO</td>
        <td width="27%" class="normalfnt"><?php echo $intPaymentNo; ?></td>
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
    <td class="normalfnth2B">Style Ratio</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblItems">
      <tr>
        <td width="36%" height="25" class="normalfntBtab">DISCRIPTION</td>
        <td width="14%" class="normalfntBtab">AMOUNT</td>
        <td width="10%" class="normalfntBtab">VAT</td>
        <td width="13%" class="normalfntBtab">CHARGERS</td>
        <td width="11%" class="normalfntBtab">DISCOUNT</td>
        <td width="16%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
		$total = 0;
		
$strSQL="SELECT advancepaymentpos.PaymentNo,suppliers.strTitle as payee,  advancepayment.PaymentNo,  advancepayment.paydate,  advancepayment.description,  advancepaymentpos.POno,  purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance,  advancepaymentpos.paidAmount,  advancepayment.taxamount,  advancepayment.discount,  advancepayment.totalamount,  (advancepayment.frightcharge + advancepayment.couriercharge + advancepayment.bankcharge) AS charge,  advancepayment.poamount,  advancepayment.frightcharge,  advancepayment.couriercharge,  advancepayment.bankcharge FROM advancepayment  INNER JOIN suppliers ON (advancepayment.supid = suppliers.strSupplierID)  INNER JOIN advancepaymentpos ON (advancepayment.PaymentNo = advancepaymentpos.PaymentNo)  INNER JOIN purchaseorderheader ON (advancepaymentpos.POno = purchaseorderheader.intPONo) WHERE  advancepaymentpos.PaymentNo = '$intPaymentNo' GROUP BY  suppliers.strCurrency,  advancepaymentpos.PaymentNo,  suppliers.strTitle,  advancepayment.PaymentNo,  advancepayment.paydate,  advancepayment.description,  advancepaymentpos.POno,  purchaseorderheader.dblPOValue,  purchaseorderheader.dblPOBalance,  advancepaymentpos.paidAmount,  advancepayment.taxamount,  advancepayment.discount";
//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	
	while($row = mysql_fetch_array($result))
				{ 
		?>
      <tr>
        <td class="normalfntTAB"><?php echo  $row["description"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo  $row["paidAmount"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo  $row["taxamount"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo  $row["charge"]; ?></td>
        <td class="normalfntMidTAB"><?php echo  $row["discount"]; ?></td>
        <td class="normalfntRiteTAB"><?php 
		
		$total += $row["totalamount"];
		
		echo  $row["totalamount"]; ?></td>
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
        <td class="nfhighlite1"><?php echo  $total; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" height="60" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="27%" height="25" class="normalfntBtab">ACCOUNT</td>
        <td width="26%" class="normalfntBtab">A/C CODE</td>
        <td width="13%" class="normalfntBtab">AMOUNT</td>
        <td width="34%" class="normalfntBtab">ADDRESS</td>
        </tr>
			<?php
		$total = 0;
		
$strSQL="SELECT glallowcation.GLAccAllowNo,  glallowcation.GLAccNo,  advancepaymentsglallowcation.Amount,  advancepaymentsglallowcation.paymentNo,  glaccounts.strFacCode,  companies.strName,glaccounts.strDescription FROM   glaccounts  INNER JOIN glallowcation ON (glaccounts.strAccID = glallowcation.GLAccNo)  INNER JOIN advancepaymentsglallowcation ON (glallowcation.GLAccAllowNo = advancepaymentsglallowcation.glAccNo)  INNER JOIN companies ON (glaccounts.strFacCode = companies.strComCode) WHERE   advancepaymentsglallowcation.paymentNo = '$intPaymentNo'";
//echo $strSQL;
	$result=$db->RunQuery($strSQL);
	
	while($row = mysql_fetch_array($result))
				{ 
		?>
      <tr>
        <td height="18" class="normalfntTAB"><?php echo  $row["GLAccAllowNo"]; ?></td>
        <td class="normalfntTAB"><?php echo  $row["GLAccNo"]; ?></td>
        <td class="normalfntTAB"><?php echo  $row["Amount"]; ?></td>
        <td class="normalfntTAB"><?php echo  $row["strName"]; ?></td>
        </tr>
      <?php
	  }
	  ?>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
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
