<?php
	session_start();
	
	include "../Connector.php";

	$intPaymentNo=$_GET["PayNo"];
	$strPaymentType=$_GET["strPaymentType"];

	$STRUSER="";
	$strFactory="";
	//$report_companyId=$_SESSION['UserID'];
	$report_companyId=$_SESSION['FactoryID'];
	$backwardseperator 	= "../";
	//echo $strPaymentType;
	//echo ("ddd");
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
$strSQL= "SELECT
companies.strName,
companies.strAddress1,
companies.strAddress2,
companies.strCity,
strCountry,
companies.strPhone,
companies.strFax,
companies.strEMail,
companies.strWeb,
companies.strComCode,
country.strCountry
FROM
companies
Inner Join country ON companies.intCountry = country.intConID
WHERE companies.intCompanyID =" . $_SESSION["FactoryID"] ;

$result=$db->RunQuery($strSQL);

while($row = mysql_fetch_array($result))
{ 
	$companyName = $row["strName"];
	$address= $row["strAddress1"] ;//+ " " +  $row["strAddress2"] + " " +  $row["strCity"] + " " +  $row["strCountry"];
	$phone= $row["strPhone"];
	$fax= $row["strFax"];
	$web= $row["strWeb"];
	$email= $row["strEMail"];
	$strFactory=$row["strComCode"];
	
}
	 $strSQL="SELECT advancepayment.intPaymentNo,advancepayment.intUserId,advancepayment.dtmPayDate,suppliers.strTitle FROM advancepayment INNER JOIN suppliers ON advancepayment.intSupplierId =  suppliers.strSupplierID
	 WHERE advancepayment.intPaymentNo = '$intPaymentNo' AND advancepayment.strType='$strPaymentType'";


$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["dtmPayDate"];
	$STRUSER=$row["userID"];
}

?>
<table width="800" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <!--<td width="24%" rowspan="4"><img src="../images/eplan_logo.png" alt="" width="191" height="47" class="normalfnt" /></td>
        <td width="1%" rowspan="4" class="normalfnt">&nbsp;</td>
        <td colspan="4" class="tophead"><p align="left" class="topheadBLACK"><?php #echo $companyName; ?></p>            </td>
      </tr>
      <tr>
        <td colspan="4" class="tophead"><div align="left"><span class="normalfnt"><?php #echo $address; ?></span></div></td>
      </tr>
      <tr>
        <td width="8%" class="tophead"><span class="normalfnt"><strong>Tel</strong>: </span></td>
        <td width="20%" class="tophead"><span class="normalfnt"><?php #echo $phone; ?></span></td>
        <td width="8%" class="tophead"><span class="normalfnt"><strong>Fax</strong>: </span></td>
        <td width="39%" class="tophead"><span class="normalfnt"><?php #echo $fax; ?></span></td>
      </tr>
      <tr>
        <td class="tophead"><span class="normalfnt"><strong>E-Mail</strong>: </span></td>
        <td class="tophead"><span class="normalfnt"><?php #echo $email; ?></span></td>
        <td class="tophead"><span class="normalfnt"><strong>Web</strong>:  </span></td>
        <td class="tophead"><span class="normalfnt"><?php #echo $web; ?></span></td>-->
		<td> <?php include('../reportHeader.php'); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" colspan="5" class="head2">ADVANCE PAYMENT- <?php 
																		if($strPaymentType=="S")
																		{
																			echo(strtoupper("Style"));
																		}
																		else if($strPaymentType=="G")
																		{
																			echo(strtoupper("General"));
																		}
																		 ?></td>
      </tr>
      <tr>
        <td width="8%" class="normalfnth2B">PAYEE</td>
        <td width="40%" class="normalfnt"><?php echo($payee); ?></td>
        <td width="6%">&nbsp;</td>
        <td width="19%" class="normalfnth2B">PAYMENT NO</td>
        <td width="27%" class="normalfnt"><?php echo($intPaymentNo); ?></td>
      </tr>
      <tr>
        <td height="13" class="normalfnth2B">&nbsp;</td>
        <td class="normalfnt">&nbsp;</td>
        <td>&nbsp;</td>
        <td class="normalfnth2B">DATE</td>
        <td class="normalfnt"><?php echo($date); ?></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablez" id="tblItems">
      <tr>
	   <?php
	  	$sql_cur="SELECT
						currencytypes.strCurrency
						FROM
						advancepayment
						Inner Join currencytypes ON advancepayment.intCurrency = currencytypes.intCurID
						WHERE intPaymentNo=$intPaymentNo
					"; 
		$result_cur=$db->runQuery($sql_cur);
		$row_cur=mysql_fetch_array($result_cur);
	  ?>
        <td width="36%" height="25" class="normalfntBtab">DESCRIPTION</td>
        <td width="14%" class="normalfntBtab">AMOUNT IN <?php echo  $row_cur["strCurrency"]; ?></td>
        <td width="10%" class="normalfntBtab">VAT</td>
        <td width="13%" class="normalfntBtab">CHARGES</td>
        <td width="11%" class="normalfntBtab">DISCOUNT</td>
        <td width="16%" class="normalfntBtab">TOTAL AMOUNT IN <?php echo  $row_cur["strCurrency"]; ?></td>
        </tr>
		<?php
		$total = 0;

		$strSQL="SELECT * ,(dblFreightCharge+dblCourierCharge+dblBankCharge) AS charges FROM advancepayment WHERE intPaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType'";
	//echo $strSQL;

	$result=$db->RunQuery($strSQL);
	
	while($row = mysql_fetch_array($result))
	{ 
		?>
      <tr>
        <td class="normalfntTAB" style="text-align:center"><?php echo  $row["strDescription"]; ?></td>
        <td class="normalfntRiteTAB" style="text-align:center"><?php echo(number_format($row["dblPoAmt"],2))  ; ?></td>
        <td class="normalfntRiteTAB" style="text-align:center"><?php echo(number_format($row["dblTaxAmt"],2)) ; ?></td>
        <td class="normalfntRiteTAB" style="text-align:center"><?php echo(number_format($row["charges"],2))  ; ?></td>
        <td class="normalfntMidTAB" style="text-align:center"><?php echo(number_format($row["dblDiscount"],2))  ; ?></td>
        <td class="normalfntRiteTAB" style="text-align:center"><?php 
		
		$total += $row["dblTotAmt"];
		
		echo(number_format($row["dblTotAmt"],2)); ?></td>
        </tr>
		<?php
		}
		?>

      <tr>
        <td class="normalfnth2Bm" style="text-align:center">Grand Total</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="normalfnth2Bm">&nbsp;</td>
        <td class="nfhighlite1" style="text-align:center"><?php echo(number_format($total,2))  ; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" height="60" border="0" cellpadding="0" cellspacing="0">
      <tr>
	  <?php
	  	$sql_cur="SELECT
						currencytypes.strCurrency
						FROM
						advancepayment
						Inner Join currencytypes ON advancepayment.intCurrency = currencytypes.intCurID
						WHERE intPaymentNo=$intPaymentNo
					"; 
		$result_cur=$db->runQuery($sql_cur);
		$row_cur=mysql_fetch_array($result_cur);
	  ?>
        <td width="33%" height="25" class="normalfntBtab">ACCOUNT</td>
        <td width="34%" class="normalfntBtab">A/C CODE</td>
        <td width="33%" class="normalfntBtab">AMOUNT IN<br />
          <?php echo  $row_cur["strCurrency"]; ?></td>
        
        </tr>
			<?php
		$total = 0;
		//$strSQL="SELECT advancepaymentsglallowcation.Amount,  advancepaymentsglallowcation.GLAccNo,glaccounts.strFacCode,  	companies.strName,glaccounts.strDescription FROM  advancepaymentsglallowcation INNER JOIN glaccounts ON (advancepaymentsglallowcation.glAccNo=glaccounts.strAccID)  INNER JOIN companies ON (glaccounts.strFacCode = companies.strComCode)   WHERE advancepaymentsglallowcation.paymentNo= '$intPaymentNo' and advancepaymentsglallowcation.strType='$strPaymentType' AND  advancepaymentsglallowcation.Amount>0 and glaccounts.strFacCode='$strFactory'";		
		
		//$strSQL="SELECT advancepaymentsglallowcation.Amount, advancepaymentsglallowcation.GLAccNo,glaccounts.strFacCode, companies.strName,glaccounts.strDescription,advancepayment.userFactory FROM advancepaymentsglallowcation INNER JOIN glaccounts ON (advancepaymentsglallowcation.glAccNo=glaccounts.strAccID) INNER JOIN companies ON (glaccounts.strFacCode = companies.strComCode)  INNER JOIN advancepayment ON (advancepaymentsglallowcation.paymentNo=advancepayment.PaymentNo AND advancepayment.userFactory=companies.intCompanyID ) WHERE advancepaymentsglallowcation.paymentNo='$intPaymentNo' AND advancepaymentsglallowcation.strType='$strPaymentType'  AND advancepaymentsglallowcation.Amount>0" ;
		
						
								 $strSQL="SELECT DISTINCT
				advancepaymentsglallowcation.Amount,
				glaccounts.strAccID,
				glaccounts.strDescription,
				advancepaymentsglallowcation.glAccNo,
				advancepaymentsglallowcation.paymentNo,
				advancepayment.intUserId,
				companies.strName
				FROM
				advancepaymentsglallowcation
				Inner Join glaccounts ON glaccounts.strAccID = advancepaymentsglallowcation.glAccNo
				Inner Join advancepayment ON advancepayment.intPaymentNo = advancepaymentsglallowcation.paymentNo
				Inner Join companies ON advancepayment.intUserId = companies.intCompanyID
				WHERE advancepaymentsglallowcation.paymentNo = '$intPaymentNo' AND advancepaymentsglallowcation.strType='$strPaymentType'
				";
		
		
//echo($strSQL);

	$result=$db->RunQuery($strSQL);
	
	    while($row = mysql_fetch_array($result))
	   { 
		?>
      <tr>
        <td height="18" class="normalfntTAB" style="text-align:center"><?php echo  $row["strDescription"]; ?></td>
        <td class="normalfntTAB" style="text-align:center"><?php echo  $row["glAccNo"]; ?></td>
        <td class="normalfntTAB" style="text-align:center"><?php echo(number_format($row["Amount"],2))  ; ?></td>
        
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
		
		$SQL = "select Name from useraccounts where intUserID ='$STRUSER'";//" . $_SESSION["UserID"] ;
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
