<?php
	session_start();
	
	include "../../Connector.php";

	$intPaymentNo=$_GET["PayNo"];
	$strPaymentType=$_GET["strPaymentType"];

	$STRUSER="";
	$strFactory="";
	//$report_companyId=$_SESSION['UserID'];
	$report_companyId=$_SESSION['FactoryID'];
	$backwardseperator 	= "../../";
	//echo $strPaymentType;
	//echo ("ddd");
	$printType="DUPLICATE";
	$sqlChkOD="select intPrintStaus from advancepayment where advancepayment.PaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType';";
	$resChk=$db->RunQuery($sqlChkOD);
	while($row=mysql_fetch_array($resChk)){
	if($row['intPrintStaus'] == 0)
		$printType="ORIGINAL";
		$sqlUp="update advancepayment set intPrintStaus=1 where advancepayment.PaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType';";
		$resUp=$db->RunQuery($sqlUp);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADVANCE PAYMENT</title>
<link href="../../css/erpstyle.css" rel="stylesheet" type="text/css" />
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
	$strSQL="SELECT advancepayment.PaymentNo,advancepayment.userID,advancepayment.paydate,suppliers.strTitle FROM advancepayment INNER JOIN suppliers ON advancepayment.supid =  suppliers.strSupplierID WHERE advancepayment.PaymentNo = $intPaymentNo AND advancepayment.strType='$strPaymentType'";


$result=$db->RunQuery($strSQL);
while($row = mysql_fetch_array($result))
{ 
	$payee= $row["strTitle"];
	$date= $row["paydate"];
	$STRUSER=$row["userID"];
}

?>
<table width="800" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td><table width="100%" cellpadding="0" cellspacing="0">
      <tr>
      	<td> <?php include('../../reportHeader.php'); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="0" id="tblCaption">
      <tr>
        <td height="36" colspan="4" class="head2">ADVANCE PAYMENT- <?php 
																		if($strPaymentType=="S")
																		{
																			echo(strtoupper("Style"));
																		}
																		else if($strPaymentType=="G")
																		{
																			echo(strtoupper("General"));
																		}
																		else if($strPaymentType=="B")
																		{
																			echo(strtoupper("Bulk"));
																		}
																		 ?></td> <td class="tablezRED style6" style="text-align:center"><?php echo($printType); ?></td>
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
        <td width="36%" height="25" class="normalfntBtab">DESCRIPTION</td>
        <td width="14%" class="normalfntBtab">AMOUNT</td>
        <td width="10%" class="normalfntBtab">TAX</td>
        <td width="13%" class="normalfntBtab">CHARGES</td>
        <td width="11%" class="normalfntBtab">DISCOUNT</td>
        <td width="16%" class="normalfntBtab">TOTAL AMOUNT</td>
        </tr>
		<?php
		$total = 0;

		$strSQL="SELECT * ,(frightcharge+couriercharge+bankcharge) AS charges FROM advancepayment WHERE PaymentNo='$intPaymentNo' and advancepayment.strType='$strPaymentType'";
	//echo $strSQL;

	$result=$db->RunQuery($strSQL);
	
	while($row = mysql_fetch_array($result))
	{ 
		?>
      <tr>
        <td class="normalfntTAB"><?php echo  $row["description"]; ?></td>
        <td class="normalfntRiteTAB"><?php echo(number_format($row["poamount"],4))  ; ?></td>
        <td class="normalfntRiteTAB"><?php echo(number_format($row["taxamount"],4)) ; ?></td>
        <td class="normalfntRiteTAB"><?php echo(number_format($row["charges"],4))  ; ?></td>
        <td class="normalfntMidTAB"><?php echo(number_format($row["discount"],4))  ; ?></td>
        <td class="normalfntRiteTAB"><?php 
		
		$total += $row["totalamount"];
		
		echo(number_format($row["totalamount"],4)); ?></td>
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
        <td class="nfhighlite1"><?php echo(number_format($total,4))  ; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" height="60" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="25%" height="25" class="normalfntBtab">ACCOUNT</td>
        <td width="15%" class="normalfntBtab">A/C CODE</td>
        <td width="15%" class="normalfntBtab">AMOUNT</td>
        <td width="35%" class="normalfntBtab">ADDRESS</td>
        </tr>
			<?php
		$total = 0;
		//$strSQL="SELECT advancepaymentsglallowcation.Amount,  advancepaymentsglallowcation.GLAccNo,glaccounts.strFacCode,  	companies.strName,glaccounts.strDescription FROM  advancepaymentsglallowcation INNER JOIN glaccounts ON (advancepaymentsglallowcation.glAccNo=glaccounts.strAccID)  INNER JOIN companies ON (glaccounts.strFacCode = companies.strComCode)   WHERE advancepaymentsglallowcation.paymentNo= '$intPaymentNo' and advancepaymentsglallowcation.strType='$strPaymentType' AND  advancepaymentsglallowcation.Amount>0 and glaccounts.strFacCode='$strFactory'";		
		
		//$strSQL="SELECT advancepaymentsglallowcation.Amount, advancepaymentsglallowcation.GLAccNo,glaccounts.strFacCode, companies.strName,glaccounts.strDescription,advancepayment.userFactory FROM advancepaymentsglallowcation INNER JOIN glaccounts ON (advancepaymentsglallowcation.glAccNo=glaccounts.strAccID) INNER JOIN companies ON (glaccounts.strFacCode = companies.strComCode)  INNER JOIN advancepayment ON (advancepaymentsglallowcation.paymentNo=advancepayment.PaymentNo AND advancepayment.userFactory=companies.intCompanyID ) WHERE advancepaymentsglallowcation.paymentNo='$intPaymentNo' AND advancepaymentsglallowcation.strType='$strPaymentType'  AND advancepaymentsglallowcation.Amount>0" ;
		
		
	/*	$strSQL="SELECT advancepaymentsglallowcation.Amount,advancepaymentsglallowcation.glAccNo,companies.strName, glaccounts.strDescription,advancepayment.userFactory, companies.strComCode,glaccounts.strAccID,companies.strAccountNo
		 FROM advancepaymentsglallowcation INNER JOIN glaccounts ON (advancepaymentsglallowcation.glAccNo = glaccounts.intGLAccID) INNER JOIN advancepayment ON (advancepaymentsglallowcation.paymentNo = advancepayment.PaymentNo) INNER JOIN companies ON advancepayment.userFactory = companies.intCompanyID WHERE advancepaymentsglallowcation.paymentNo='$intPaymentNo'  AND advancepaymentsglallowcation.strType='$strPaymentType' AND advancepaymentsglallowcation.Amount>0 GROUP BY advancepaymentsglallowcation.Amount,advancepaymentsglallowcation.glAccNo,companies.strName,glaccounts.strDescription,advancepayment.userFactory,companies.strComCode";*/
		/*$strSQL="SELECT
				advancepaymentsglallowcation.Amount,
				advancepaymentsglallowcation.glAccNo,
				glaccounts.strAccID,
				glaccounts.strDescription,
				glallowcation.GLAccAllowNo,
				glallowcation.GLAccNo,
				glallowcation.FactoryCode,
				advancepayment.intPrintStaus,
				companies.strComCode,
				companies.strName
				FROM
				advancepaymentsglallowcation
				Inner Join advancepayment ON (advancepaymentsglallowcation.paymentNo = advancepayment.PaymentNo)
				Inner Join glallowcation ON advancepaymentsglallowcation.glAccNo = glallowcation.GLAccAllowNo
				Inner Join glaccounts ON glaccounts.intGLAccID = glallowcation.GLAccNo
				Inner Join companies ON glallowcation.FactoryCode = companies.intCompanyID
				WHERE advancepaymentsglallowcation.paymentNo='$intPaymentNo' 
				AND advancepaymentsglallowcation.strType='$strPaymentType' 
				AND advancepaymentsglallowcation.Amount>0
				GROUP BY
				advancepaymentsglallowcation.Amount,
				advancepaymentsglallowcation.glAccNo,
				advancepayment.userFactory;";*/
				
				$strSQL="SELECT
						advancepaymentsglallowcation.Amount,
						advancepaymentsglallowcation.glAccNo,
						glaccounts.strAccID,
						glaccounts.strDescription,
						glallowcation.GLAccAllowNo,
						glallowcation.GLAccNo,
						glallowcation.FactoryCode,
						advancepayment.intPrintStaus,
						companies.strComCode,
						companies.strName,
						companies.strAccountNo
						FROM
						advancepaymentsglallowcation
						Inner Join advancepayment ON (advancepaymentsglallowcation.paymentNo = advancepayment.PaymentNo)
						Inner Join glallowcation ON advancepaymentsglallowcation.glAccNo = glallowcation.GLAccAllowNo
						Inner Join glaccounts ON glaccounts.intGLAccID = glallowcation.GLAccNo
						Inner Join companies ON glallowcation.FactoryCode = companies.intCompanyID
						WHERE advancepaymentsglallowcation.paymentNo='$intPaymentNo' 
						AND advancepaymentsglallowcation.strType='$strPaymentType' 
						AND advancepaymentsglallowcation.Amount>0
						GROUP BY
						advancepaymentsglallowcation.Amount,
						advancepaymentsglallowcation.glAccNo,
						advancepayment.userFactory ORDER BY
						glaccounts.strAccID ASC ;";


		
//echo($strSQL);

	$result=$db->RunQuery($strSQL);
	
	    while($row = mysql_fetch_array($result))
	   { 
		?>
      <tr>
        <td height="18" class="normalfntTAB"><?php echo  $row["strDescription"]; ?></td>
        <td class="normalfntTAB"><?php echo  $row["strAccID"].$row["strAccountNo"]; ?></td>
        <td class="normalfntTAB" style="text-align:right"><?php echo(number_format($row["Amount"],4))  ; ?></td>
        <td class="normalfntTAB"  style="text-align:left"><?php echo  $row["strName"]; ?></td>
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
